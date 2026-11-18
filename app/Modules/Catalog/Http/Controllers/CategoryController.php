<?php

namespace App\Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\Http\Requests\CategoryRequest;
use App\Modules\Catalog\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('catalog::categories.index', [
            'categories' => Category::withCount('books')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('catalog::categories.form', ['category' => new Category]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('catalog.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('catalog::categories.form', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('catalog.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->books()->exists()) {
            return back()->with('error', "Kategori \"{$category->name}\" masih dipakai oleh buku, tidak bisa dihapus.");
        }

        $category->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}
