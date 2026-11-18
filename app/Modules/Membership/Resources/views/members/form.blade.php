@extends('layouts.app')
@section('title', $member->exists ? 'Edit Anggota' : 'Tambah Anggota')
@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $member->exists ? 'Edit Anggota '.$member->member_code : 'Tambah Anggota' }}</h1>
<form method="POST" class="bg-white rounded shadow p-6 space-y-4 max-w-xl"
      action="{{ $member->exists ? route('membership.members.update', $member) : route('membership.members.store') }}">
    @csrf
    @if ($member->exists) @method('PUT') @endif
    <label class="block">Jenis Keanggotaan
        <select name="membership_type_id" class="w-full border rounded px-3 py-2 @error('membership_type_id') border-red-500 @enderror">
            <option value="">-- pilih --</option>
            @foreach ($types as $id => $name)
                <option value="{{ $id }}" @selected(old('membership_type_id', $member->membership_type_id) == $id)>{{ $name }}</option>
            @endforeach
        </select>
        @error('membership_type_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    @foreach (['name' => 'Nama', 'email' => 'Email', 'phone' => 'No. Telepon'] as $field => $label)
        <label class="block">{{ $label }}
            <input name="{{ $field }}" value="{{ old($field, $member->$field) }}" class="w-full border rounded px-3 py-2 @error($field) border-red-500 @enderror">
            @error($field) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </label>
    @endforeach
    <label class="block">Alamat
        <textarea name="address" class="w-full border rounded px-3 py-2">{{ old('address', $member->address) }}</textarea>
        @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="flex gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active))> Aktif</label>
    <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan</button>
    <a href="{{ route('membership.members.index') }}" class="ml-2">Batal</a>
</form>
@endsection
