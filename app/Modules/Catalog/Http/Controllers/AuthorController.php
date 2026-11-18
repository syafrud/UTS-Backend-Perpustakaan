<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Http\Requests\AuthorRequest;
use App\Modules\Catalog\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        return view('catalog::authors.index', [
            'authors' => Author::withCount('books')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('catalog::authors.form', ['author' => new Author]);
    }

    public function store(AuthorRequest $request): RedirectResponse
    {
        Author::create($request->validated());

        return redirect()->route('catalog.authors.index')->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function edit(Author $author): View
    {
        return view('catalog::authors.form', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $author->update($request->validated());

        return redirect()->route('catalog.authors.index')->with('success', 'Penulis berhasil diperbarui.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();

        return back()->with('success', 'Penulis dihapus.');
    }
}
