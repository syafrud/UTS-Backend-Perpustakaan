<?php

namespace App\Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['loan_id', 'book_id'])]
class LoanItem extends Model
{
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
