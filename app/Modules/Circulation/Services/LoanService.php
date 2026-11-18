<?php

namespace App\Modules\Circulation\Services;

use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Circulation\Events\LoanReturned;
use App\Modules\Circulation\Exceptions\FineAlreadyPaidException;
use App\Modules\Circulation\Exceptions\LoanAlreadyReturnedException;
use App\Modules\Circulation\Exceptions\LoanLimitExceededException;
use App\Modules\Circulation\Models\Fine;
use App\Modules\Circulation\Models\Loan;
use App\Modules\Circulation\Models\LoanItem;
use App\Modules\Membership\Contracts\MemberDirectory;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

/**
 * Logika peminjaman. Data buku & anggota HANYA diakses lewat Contract modul lain;
 * pengembalian diumumkan lewat Domain Event LoanReturned.
 */
class LoanService
{
    public function __construct(
        private BookCatalog $catalog,
        private MemberDirectory $members,
    ) {}

    /**
     * Semua langkah dalam satu transaksi: jika satu buku stoknya habis,
     * loan, loan_items, dan pengurangan stok buku sebelumnya ikut di-rollback.
     *
     * @param  int[]  $bookIds
     */
    public function borrow(int $memberId, array $bookIds, ?int $userId = null): Loan
    {
        return DB::transaction(function () use ($memberId, $bookIds, $userId) {
            $member = $this->members->findActive($memberId);

            $current = LoanItem::whereHas('loan', fn ($q) => $q->where('member_id', $memberId)->whereNull('returned_at'))->count();
            if ($current + count($bookIds) > $member['max_loans']) {
                throw LoanLimitExceededException::for($member['name'], $member['max_loans'], $current, count($bookIds));
            }

            $loan = Loan::create([
                'member_id' => $memberId,
                'user_id' => $userId,
                'loaned_at' => today(),
                'due_at' => today()->addDays($member['loan_days']),
                'fine_per_day' => $member['fine_per_day'],
            ]);

            foreach ($bookIds as $bookId) {
                $this->catalog->decrementStock((int) $bookId); // bisa throw BookOutOfStockException
                $loan->items()->create(['book_id' => $bookId]);
            }

            return $loan;
        });
    }

    /** Kembalikan buku, buat denda bila terlambat, lalu publish LoanReturned (stok dikembalikan Catalog). */
    public function return(Loan $loan, ?CarbonInterface $returnedAt = null): Loan
    {
        $returnedAt = ($returnedAt ?? today())->copy()->startOfDay();

        return DB::transaction(function () use ($loan, $returnedAt) {
            $loan = Loan::lockForUpdate()->findOrFail($loan->id);

            if ($loan->isReturned()) {
                throw LoanAlreadyReturnedException::for($loan->id, $loan->returned_at->format('d/m/Y'));
            }

            $loan->update(['returned_at' => $returnedAt]);

            $daysLate = $this->daysLate($loan->due_at, $returnedAt);
            if ($daysLate > 0) {
                $loan->fine()->create([
                    'days_late' => $daysLate,
                    'amount' => $daysLate * $loan->fine_per_day * $loan->items->count(),
                ]);
            }

            // Domain Event: Catalog mengembalikan stok lewat listener-nya sendiri.
            LoanReturned::dispatch(
                $loan->id,
                $loan->member_id,
                $loan->items->pluck('book_id')->all(),
                $returnedAt->toDateString(),
                $daysLate,
            );

            return $loan->load('fine');
        });
    }

    public function payFine(Fine $fine): Fine
    {
        return DB::transaction(function () use ($fine) {
            $fine = Fine::lockForUpdate()->findOrFail($fine->id);

            if ($fine->paid_at) {
                throw FineAlreadyPaidException::for($fine->id);
            }

            $fine->update(['paid_at' => now()]);

            return $fine;
        });
    }

    public function daysLate(CarbonInterface $dueAt, CarbonInterface $returnedAt): int
    {
        return max(0, (int) $dueAt->copy()->startOfDay()->diffInDays($returnedAt->copy()->startOfDay(), false));
    }
}
