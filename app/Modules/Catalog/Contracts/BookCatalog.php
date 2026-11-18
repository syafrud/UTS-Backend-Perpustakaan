<?php

namespace App\Modules\Catalog\Contracts;

use App\Modules\Catalog\Exceptions\BookOutOfStockException;

/**
 * Pintu publik CatalogModule untuk modul lain (mis. Circulation).
 * Mengembalikan array biasa, bukan Model, agar modul lain tidak terikat ke Eloquent Catalog.
 */
interface BookCatalog
{
    /** @return array{id:int,title:string,isbn:string,stock:int}|null */
    public function find(int $bookId): ?array;

    /** @return array<int,string> id => judul, untuk buku dengan stok > 0 */
    public function availableOptions(): array;

    /** @param  int[]  $bookIds  @return array<int,string> id => judul */
    public function titles(array $bookIds): array;

    /** @throws BookOutOfStockException jika buku tidak ada atau stok habis */
    public function decrementStock(int $bookId): void;

    public function incrementStock(int $bookId): void;
}
