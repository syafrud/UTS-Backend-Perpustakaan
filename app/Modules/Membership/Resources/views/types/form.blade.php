@extends('layouts.app')
@section('title', $type->exists ? 'Edit Jenis' : 'Tambah Jenis')
@section('content')
<div class="page-header">
    <h1>{{ $type->exists ? 'Edit' : 'Tambah' }} Jenis Keanggotaan</h1>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <form method="POST" class="form"
              action="{{ $type->exists ? route('membership.types.update', $type) : route('membership.types.store') }}">
            @csrf
            @if ($type->exists) @method('PUT') @endif
            @foreach (['name' => 'Nama', 'max_loans' => 'Maksimal pinjam (buku)', 'loan_days' => 'Lama pinjam (hari)', 'fine_per_day' => 'Denda per hari (Rp)'] as $field => $label)
                <div class="field">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'name' ? 'text' : 'number' }}" value="{{ old($field, $type->$field) }}"
                           @class(['input', 'is-invalid' => $errors->has($field)])>
                    @error($field) <span class="field-error">{{ $message }}</span> @enderror
                </div>
            @endforeach
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('membership.types.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
