<?php

namespace App\Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['member_id', 'user_id', 'loaned_at', 'due_at', 'returned_at', 'fine_per_day'])]
class Loan extends Model
{
    protected function casts(): array
    {
        return [
            'loaned_at' => 'date',
            'due_at' => 'date',
            'returned_at' => 'date',
        ];
    }

    /** One-to-Many: satu peminjaman berisi banyak buku. */
    public function items(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function status(): string
    {
        return match (true) {
            $this->isReturned() => 'Dikembalikan',
            $this->due_at->isPast() && ! $this->due_at->isToday() => 'Terlambat',
            default => 'Dipinjam',
        };
    }
}
