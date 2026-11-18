<?php

namespace App\Modules\Catalog\Exceptions;

use App\Support\Exceptions\BusinessRuleException;

class BookOutOfStockException extends BusinessRuleException
{
    public static function for(string $title): self
    {
        return new self("Stok buku \"{$title}\" habis. Peminjaman dibatalkan dan tidak ada data yang tersimpan.");
    }

    public static function notFound(int $bookId): self
    {
        return new self("Buku dengan ID {$bookId} tidak ditemukan di katalog.");
    }
}
