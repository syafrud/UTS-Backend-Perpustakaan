@extends('layouts.app')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori</h1>
<form method="POST" class="bg-white rounded shadow p-6 space-y-4 max-w-xl"
      action="{{ $category->exists ? route('catalog.categories.update', $category) : route('catalog.categories.store') }}">
    @csrf
    @if ($category->exists) @method('PUT') @endif
    <label class="block">Nama
        <input name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Deskripsi
        <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
    <a href="{{ route('catalog.categories.index') }}" class="ml-2">Batal</a>
</form>
@endsection
