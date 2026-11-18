<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Http\Requests\BookRequest;
use App\Modules\Catalog\Models\Author;
use App\Modules\Catalog\Models\Book;
use App\Modules\Catalog\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $books = Book::with(['category', 'authors'])
            ->when($request->q, fn ($q, $term) => $q->where('title', 'like', "%{$term}%")->orWhere('isbn', 'like', "%{$term}%"))
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('catalog::books.index', compact('books'));
    }

    public function show(Book $book): View
    {
        return view('catalog::books.show', ['book' => $book->load(['category', 'authors'])]);
    }

    public function create(): View
    {
        return view('catalog::books.form', ['book' => new Book] + $this->formOptions());
    }

    public function store(BookRequest $request): RedirectResponse
    {
        // Buku + pivot penulis disimpan atomik.
        $book = DB::transaction(function () use ($request) {
            $book = Book::create($request->safe()->except('author_ids'));
            $book->syncAuthors($request->validated('author_ids'));

            return $book;
        });

        return redirect()->route('catalog.books.show', $book)->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book): View
    {
        return view('catalog::books.form', ['book' => $book->load('authors')] + $this->formOptions());
    }

    public function update(BookRequest $request, Book $book): RedirectResponse
    {
        DB::transaction(function () use ($request, $book) {
            $book->update($request->safe()->except('author_ids'));
            $book->syncAuthors($request->validated('author_ids'));
        });

        return redirect()->route('catalog.books.show', $book)->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('catalog.books.index')->with('success', 'Buku dihapus.');
    }

    private function formOptions(): array
    {
        return [
            'categories' => Category::orderBy('name')->pluck('name', 'id'),
            'authors' => Author::orderBy('name')->pluck('name', 'id'),
        ];
    }
}
