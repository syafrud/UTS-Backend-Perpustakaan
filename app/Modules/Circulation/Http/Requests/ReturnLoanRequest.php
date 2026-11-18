<?php

namespace App\Modules\Circulation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'returned_at' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:'.$this->route('loan')->loaned_at->toDateString(),
            ],
        ];
    }
}
