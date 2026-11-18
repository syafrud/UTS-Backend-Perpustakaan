<?php

namespace App\Modules\Membership\Models;

use App\Modules\Membership\Database\Factories\MembershipTypeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'max_loans', 'loan_days', 'fine_per_day'])]
#[UseFactory(MembershipTypeFactory::class)]
class MembershipType extends Model
{
    use HasFactory;

    /** One-to-Many: satu jenis keanggotaan punya banyak anggota. */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
