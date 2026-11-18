<?php

namespace App\Modules\Circulation\Database\Seeders;

use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Circulation\Services\LoanService;
use App\Modules\Membership\Contracts\MemberDirectory;
use Illuminate\Database\Seeder;

class CirculationSeeder extends Seeder
{
    public function run(LoanService $loans, BookCatalog $catalog, MemberDirectory $members): void
    {
        $memberIds = array_keys($members->activeOptions());
        $bookIds = array_keys($catalog->availableOptions());

        // 5 peminjaman aktif, masing-masing 1-2 buku.
        $created = collect(range(0, 4))->map(fn ($i) => $loans->borrow(
            $memberIds[$i],
            array_slice($bookIds, $i * 2, ($i % 2) + 1),
        ));

        // Jadikan 2 peminjaman terlambat untuk demo denda.
        $created->take(2)->each(fn ($loan) => $loan->update([
            'loaned_at' => today()->subDays(20),
            'due_at' => today()->subDays(13),
        ]));

        // Satu yang terlambat langsung dikembalikan -> menghasilkan denda.
        $loans->return($created->first());
    }
}
