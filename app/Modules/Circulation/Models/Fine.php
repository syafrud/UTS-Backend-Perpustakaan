<?php

namespace App\Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['loan_id', 'days_late', 'amount', 'paid_at'])]
class Fine extends Model
{
    protected function casts(): array
    {
        return ['paid_at' => 'datetime'];
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
