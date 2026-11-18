<?php

namespace App\Modules\Catalog\Listeners;

use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Circulation\Events\LoanReturned;

/**
 * Subscriber CatalogModule untuk Domain Event LoanReturned: kembalikan stok buku.
 * Berjalan sinkron di dalam transaksi pengembalian, jadi jika gagal ikut di-rollback.
 */
class RestockReturnedBooks
{
    public function __construct(private BookCatalog $catalog) {}

    public function handle(LoanReturned $event): void
    {
        foreach ($event->bookIds as $bookId) {
            $this->catalog->incrementStock($bookId);
        }
    }
}
