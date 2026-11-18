@extends('layouts.app')
@section('title', $type->exists ? 'Edit Jenis' : 'Tambah Jenis')
@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $type->exists ? 'Edit' : 'Tambah' }} Jenis Keanggotaan</h1>
<form method="POST" class="bg-white rounded shadow p-6 space-y-4 max-w-xl"
      action="{{ $type->exists ? route('membership.types.update', $type) : route('membership.types.store') }}">
    @csrf
    @if ($type->exists) @method('PUT') @endif
    @foreach (['name' => 'Nama', 'max_loans' => 'Maksimal pinjam (buku)', 'loan_days' => 'Lama pinjam (hari)', 'fine_per_day' => 'Denda per hari (Rp)'] as $field => $label)
        <label class="block">{{ $label }}
            <input name="{{ $field }}" type="{{ $field === 'name' ? 'text' : 'number' }}" value="{{ old($field, $type->$field) }}"
                   class="w-full border rounded px-3 py-2 @error($field) border-red-500 @enderror">
            @error($field) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </label>
    @endforeach
    <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
    <a href="{{ route('membership.types.index') }}" class="ml-2">Batal</a>
</form>
@endsection
