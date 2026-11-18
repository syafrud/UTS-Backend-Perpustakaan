<?php

namespace App\Support\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

/**
 * Induk semua custom exception aturan bisnis (stok habis, batas pinjam, dll).
 * Web: kembali ke form dengan pesan error. API: JSON 422.
 */
abstract class BusinessRuleException extends RuntimeException
{
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->getMessage()], 422);
        }

        return back()->withInput()->with('error', $this->getMessage());
    }
}
