<?php

namespace App\Modules\Catalog\Services;

use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Catalog\Exceptions\BookOutOfStockException;
use App\Modules\Catalog\Models\Book;

class EloquentBookCatalog implements BookCatalog
{
    public function find(int $bookId): ?array
    {
        return Book::find($bookId)?->only('id', 'title', 'isbn', 'stock');
    }

    public function availableOptions(): array
    {
        return Book::where('stock', '>', 0)->orderBy('title')->pluck('title', 'id')->all();
    }

    public function titles(array $bookIds): array
    {
        return Book::whereIn('id', $bookIds)->pluck('title', 'id')->all();
    }

    public function decrementStock(int $bookId): void
    {
        // lockForUpdate: cegah dua transaksi meminjam stok terakhir bersamaan.
        $book = Book::lockForUpdate()->find($bookId) ?? throw BookOutOfStockException::notFound($bookId);

        if ($book->stock < 1) {
            throw BookOutOfStockException::for($book->title);
        }

        $book->decrement('stock');
    }

    public function incrementStock(int $bookId): void
    {
        Book::whereKey($bookId)->increment('stock');
    }
}
