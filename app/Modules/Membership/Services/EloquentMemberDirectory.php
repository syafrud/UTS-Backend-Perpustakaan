<?php

namespace App\Modules\Membership\Services;

use App\Modules\Membership\Contracts\MemberDirectory;
use App\Modules\Membership\Exceptions\MemberNotEligibleException;
use App\Modules\Membership\Models\Member;

class EloquentMemberDirectory implements MemberDirectory
{
    public function findActive(int $memberId): array
    {
        $member = Member::with('type')->find($memberId) ?? throw MemberNotEligibleException::notFound($memberId);

        if (! $member->is_active) {
            throw MemberNotEligibleException::inactive($member->name);
        }

        return [
            'id' => $member->id,
            'member_code' => $member->member_code,
            'name' => $member->name,
            'max_loans' => $member->type->max_loans,
            'loan_days' => $member->type->loan_days,
            'fine_per_day' => $member->type->fine_per_day,
        ];
    }

    public function activeOptions(): array
    {
        return Member::where('is_active', true)->orderBy('name')->get()
            ->mapWithKeys(fn (Member $m) => [$m->id => $m->label()])->all();
    }

    public function labels(array $memberIds): array
    {
        return Member::whereIn('id', $memberIds)->get()
            ->mapWithKeys(fn (Member $m) => [$m->id => $m->label()])->all();
    }
}
