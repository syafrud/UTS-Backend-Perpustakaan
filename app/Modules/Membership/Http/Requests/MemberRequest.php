<?php

namespace App\Modules\Membership\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // dibatasi middleware role:admin,pustakawan
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        return [
            'membership_type_id' => ['required', 'integer', 'exists:membership_types,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('members')->ignore($this->route('member'))],
            'phone' => ['nullable', 'regex:/^08[0-9]{8,12}$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return ['phone.regex' => 'No. telepon harus diawali 08 dan berisi 10-14 digit.'];
    }
}
