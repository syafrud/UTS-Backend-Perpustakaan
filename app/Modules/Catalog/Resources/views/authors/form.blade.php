@extends('layouts.app')
@section('title', $author->exists ? 'Edit Penulis' : 'Tambah Penulis')
@section('content')
<div class="page-header">
    <h1>{{ $author->exists ? 'Edit' : 'Tambah' }} Penulis</h1>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <form method="POST" class="form"
              action="{{ $author->exists ? route('catalog.authors.update', $author) : route('catalog.authors.store') }}">
            @csrf
            @if ($author->exists) @method('PUT') @endif
            <div class="field">
                <label for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name', $author->name) }}" @class(['input', 'is-invalid' => $errors->has('name')])>
                @error('name') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="bio">Biografi</label>
                <textarea id="bio" name="bio" @class(['textarea', 'is-invalid' => $errors->has('bio')])>{{ old('bio', $author->bio) }}</textarea>
                @error('bio') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('catalog.authors.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
