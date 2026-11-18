@extends('layouts.app')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<div class="page-header">
    <h1>{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori</h1>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <form method="POST" class="form"
              action="{{ $category->exists ? route('catalog.categories.update', $category) : route('catalog.categories.store') }}">
            @csrf
            @if ($category->exists) @method('PUT') @endif
            <div class="field">
                <label for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name', $category->name) }}" @class(['input', 'is-invalid' => $errors->has('name')])>
                @error('name') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" @class(['textarea', 'is-invalid' => $errors->has('description')])>{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('catalog.categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
