<?php

namespace App\Modules\Membership\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembershipTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('membership_types')->ignore($this->route('type'))],
            'max_loans' => ['required', 'integer', 'min:1', 'max:10'],
            'loan_days' => ['required', 'integer', 'min:1', 'max:60'],
            'fine_per_day' => ['required', 'integer', 'min:0', 'max:100000'],
        ];
    }
}
