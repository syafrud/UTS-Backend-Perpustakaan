<?php

namespace App\Modules\Circulation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Circulation\Http\Requests\BorrowBookRequest;
use App\Modules\Circulation\Http\Requests\ReturnLoanRequest;
use App\Modules\Circulation\Models\Loan;
use App\Modules\Circulation\Services\LoanService;
use App\Modules\Membership\Contracts\MemberDirectory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function __construct(
        private LoanService $loans,
        private BookCatalog $catalog,
        private MemberDirectory $members,
    ) {}

    public function index(Request $request): View
    {
        $loans = Loan::with(['items', 'fine'])
            ->when($request->status === 'active', fn ($q) => $q->whereNull('returned_at'))
            ->when($request->status === 'returned', fn ($q) => $q->whereNotNull('returned_at'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('circulation::loans.index', [
            'loans' => $loans,
            'memberLabels' => $this->members->labels($loans->pluck('member_id')->unique()->all()),
            'bookTitles' => $this->catalog->titles($loans->getCollection()->flatMap(fn (Loan $loan) => $loan->items->pluck('book_id'))->unique()->all()),
        ]);
    }

    public function create(): View
    {
        return view('circulation::loans.create', [
            'members' => $this->members->activeOptions(),
            'books' => $this->catalog->availableOptions(),
        ]);
    }

    public function store(BorrowBookRequest $request): RedirectResponse
    {
        $loan = $this->loans->borrow(
            $request->integer('member_id'),
            array_map('intval', $request->validated('book_ids')),
            $request->user()->id,
        );

        return redirect()->route('circulation.loans.show', $loan)
            ->with('success', "Peminjaman #{$loan->id} berhasil. Jatuh tempo {$loan->due_at->format('d/m/Y')}.");
    }

    public function show(Loan $loan): View
    {
        $loan->load(['items', 'fine']);

        return view('circulation::loans.show', [
            'loan' => $loan,
            'memberLabel' => $this->members->labels([$loan->member_id])[$loan->member_id] ?? "Anggota #{$loan->member_id} (terhapus)",
            'bookTitles' => $this->catalog->titles($loan->items->pluck('book_id')->all()),
        ]);
    }

    public function return(ReturnLoanRequest $request, Loan $loan): RedirectResponse
    {
        $loan = $this->loans->return($loan, Carbon::parse($request->validated('returned_at')));

        $message = $loan->fine
            ? "Buku dikembalikan. Terlambat {$loan->fine->days_late} hari, denda Rp ".number_format($loan->fine->amount, 0, ',', '.').'.'
            : 'Buku dikembalikan tepat waktu.';

        return redirect()->route('circulation.loans.show', $loan)->with('success', $message);
    }
}
