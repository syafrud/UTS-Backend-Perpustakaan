@extends('layouts.app')
@section('title', $member->exists ? 'Edit Anggota' : 'Tambah Anggota')
@section('content')
<div class="page-header">
    <h1>{{ $member->exists ? 'Edit Anggota '.$member->member_code : 'Tambah Anggota' }}</h1>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <form method="POST" class="form"
              action="{{ $member->exists ? route('membership.members.update', $member) : route('membership.members.store') }}">
            @csrf
            @if ($member->exists) @method('PUT') @endif
            <div class="field">
                <label for="membership_type_id">Jenis Keanggotaan</label>
                <select id="membership_type_id" name="membership_type_id" @class(['select', 'is-invalid' => $errors->has('membership_type_id')])>
                    <option value="">-- pilih --</option>
                    @foreach ($types as $id => $name)
                        <option value="{{ $id }}" @selected(old('membership_type_id', $member->membership_type_id) == $id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('membership_type_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            @foreach (['name' => 'Nama', 'email' => 'Email', 'phone' => 'No. Telepon'] as $field => $label)
                <div class="field">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $member->$field) }}" @class(['input', 'is-invalid' => $errors->has($field)])>
                    @error($field) <span class="field-error">{{ $message }}</span> @enderror
                </div>
            @endforeach
            <div class="field">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" @class(['textarea', 'is-invalid' => $errors->has('address')])>{{ old('address', $member->address) }}</textarea>
                @error('address') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->is_active))> Aktif</label>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('membership.members.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
