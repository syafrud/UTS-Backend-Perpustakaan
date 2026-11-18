@extends('layouts.app')
@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')
@section('content')
@php($selectedAuthors = collect(old('author_ids', $book->exists ? $book->authors->pluck('id')->all() : []))->map(fn ($id) => (int) $id))
<div class="page-header">
    <h1>{{ $book->exists ? 'Edit' : 'Tambah' }} Buku</h1>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" class="form-grid"
              action="{{ $book->exists ? route('catalog.books.update', $book) : route('catalog.books.store') }}">
            @csrf
            @if ($book->exists) @method('PUT') @endif
            <div class="field span-all">
                <label for="title">Judul</label>
                <input id="title" name="title" value="{{ old('title', $book->title) }}" @class(['input', 'is-invalid' => $errors->has('title')])>
                @error('title') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="isbn">ISBN</label>
                <input id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" @class(['input', 'is-invalid' => $errors->has('isbn')])>
                @error('isbn') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" @class(['select', 'is-invalid' => $errors->has('category_id')])>
                    <option value="">-- pilih --</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id', $book->category_id) == $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="publisher">Penerbit</label>
                <input id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" @class(['input', 'is-invalid' => $errors->has('publisher')])>
                @error('publisher') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="published_year">Tahun Terbit</label>
                <input id="published_year" name="published_year" type="number" value="{{ old('published_year', $book->published_year) }}" @class(['input', 'is-invalid' => $errors->has('published_year')])>
                @error('published_year') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="stock">Stok</label>
                <input id="stock" name="stock" type="number" value="{{ old('stock', $book->stock ?? 0) }}" @class(['input', 'is-invalid' => $errors->has('stock')])>
                @error('stock') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field span-all">
                <label for="author_ids">Penulis <span class="hint">(Ctrl+klik untuk memilih banyak; urutan pertama = penulis utama)</span></label>
                <select id="author_ids" name="author_ids[]" multiple size="6" @class(['select', 'is-invalid' => $errors->has('author_ids')])>
                    @foreach ($authors as $id => $name)
                        <option value="{{ $id }}" @selected($selectedAuthors->contains($id))>{{ $name }}</option>
                    @endforeach
                </select>
                @error('author_ids') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions span-all">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('catalog.books.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
