<?php

namespace App\Modules\Membership\Models;

use App\Modules\Membership\Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[Fillable(['membership_type_id', 'member_code', 'name', 'email', 'phone', 'address', 'is_active'])]
#[UseFactory(MemberFactory::class)]
class Member extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(fn (Member $member) => $member->member_code ??= 'AGT-'.Str::upper(Str::random(6)));
    }

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }

    public function label(): string
    {
        return "{$this->member_code} - {$this->name}";
    }
}
