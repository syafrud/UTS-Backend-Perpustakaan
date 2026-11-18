<?php

namespace App\Modules\Catalog\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Models\Book;
use Illuminate\Http\JsonResponse;

class BookApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Book::with(['category:id,name', 'authors:id,name'])->orderBy('title')->paginate(15));
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json($book->load(['category:id,name', 'authors:id,name']));
    }
}
