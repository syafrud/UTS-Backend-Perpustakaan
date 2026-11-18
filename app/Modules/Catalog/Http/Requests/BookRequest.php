<?php

namespace App\Modules\Catalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'isbn' => ['required', 'regex:/^[0-9-]{10,17}$/', Rule::unique('books')->ignore($this->route('book'))],
            'publisher' => ['nullable', 'string', 'max:150'],
            'published_year' => ['nullable', 'integer', 'min:1900', 'max:'.date('Y')],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'author_ids' => ['required', 'array', 'min:1'],
            'author_ids.*' => ['integer', 'distinct', 'exists:authors,id'],
        ];
    }

    public function messages(): array
    {
        return ['isbn.regex' => 'ISBN hanya boleh angka dan tanda hubung (10-17 karakter).'];
    }
}
