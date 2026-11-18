@extends('layouts.app')
@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')
@section('content')
@php($selectedAuthors = collect(old('author_ids', $book->exists ? $book->authors->pluck('id')->all() : []))->map(fn ($id) => (int) $id))
<h1 class="text-2xl font-bold mb-4">{{ $book->exists ? 'Edit' : 'Tambah' }} Buku</h1>
<form method="POST" class="bg-white rounded shadow p-6 grid sm:grid-cols-2 gap-4 max-w-3xl"
      action="{{ $book->exists ? route('catalog.books.update', $book) : route('catalog.books.store') }}">
    @csrf
    @if ($book->exists) @method('PUT') @endif
    <label class="block sm:col-span-2">Judul
        <input name="title" value="{{ old('title', $book->title) }}" class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
        @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">ISBN
        <input name="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full border rounded px-3 py-2 @error('isbn') border-red-500 @enderror">
        @error('isbn') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Kategori
        <select name="category_id" class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
            <option value="">-- pilih --</option>
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" @selected(old('category_id', $book->category_id) == $id)>{{ $name }}</option>
            @endforeach
        </select>
        @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Penerbit
        <input name="publisher" value="{{ old('publisher', $book->publisher) }}" class="w-full border rounded px-3 py-2">
        @error('publisher') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Tahun Terbit
        <input name="published_year" type="number" value="{{ old('published_year', $book->published_year) }}" class="w-full border rounded px-3 py-2 @error('published_year') border-red-500 @enderror">
        @error('published_year') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Stok
        <input name="stock" type="number" value="{{ old('stock', $book->stock ?? 0) }}" class="w-full border rounded px-3 py-2 @error('stock') border-red-500 @enderror">
        @error('stock') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Penulis <span class="text-xs text-slate-500">(Ctrl+klik untuk pilih banyak; urutan pertama = penulis utama)</span>
        <select name="author_ids[]" multiple size="6" class="w-full border rounded px-3 py-2 @error('author_ids') border-red-500 @enderror">
            @foreach ($authors as $id => $name)
                <option value="{{ $id }}" @selected($selectedAuthors->contains($id))>{{ $name }}</option>
            @endforeach
        </select>
        @error('author_ids') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <div class="sm:col-span-2">
        <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
        <a href="{{ route('catalog.books.index') }}" class="ml-2">Batal</a>
    </div>
</form>
@endsection
