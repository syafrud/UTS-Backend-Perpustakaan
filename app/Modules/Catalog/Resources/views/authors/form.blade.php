@extends('layouts.app')
@section('title', $author->exists ? 'Edit Penulis' : 'Tambah Penulis')
@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $author->exists ? 'Edit' : 'Tambah' }} Penulis</h1>
<form method="POST" class="bg-white rounded shadow p-6 space-y-4 max-w-xl"
      action="{{ $author->exists ? route('catalog.authors.update', $author) : route('catalog.authors.store') }}">
    @csrf
    @if ($author->exists) @method('PUT') @endif
    <label class="block">Nama
        <input name="name" value="{{ old('name', $author->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Biografi
        <textarea name="bio" class="w-full border rounded px-3 py-2">{{ old('bio', $author->bio) }}</textarea>
        @error('bio') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
    <a href="{{ route('catalog.authors.index') }}" class="ml-2">Batal</a>
</form>
@endsection
