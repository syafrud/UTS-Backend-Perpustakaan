<?php

namespace App\Modules\Circulation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi bentuk input saja. Keberadaan anggota/buku & stok dicek lewat Contract
 * di LoanService (bukan rule exists:books) agar tidak menyentuh tabel modul lain.
 */
class BorrowBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // dibatasi middleware role
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'integer', 'min:1'],
            'book_ids' => ['required', 'array', 'min:1', 'max:5'],
            'book_ids.*' => ['integer', 'min:1', 'distinct'],
        ];
    }
}
