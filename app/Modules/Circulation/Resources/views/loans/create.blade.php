@extends('layouts.app')
@section('title', 'Peminjaman Baru')
@section('content')
@php($selectedBooks = collect(old('book_ids', []))->map(fn ($id) => (int) $id))
<div class="page-header">
    <h1>Peminjaman Baru</h1>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <form method="POST" action="{{ route('circulation.loans.store') }}" class="form">
            @csrf
            <div class="field">
                <label for="member_id">Anggota <span class="hint">(hanya anggota aktif)</span></label>
                <select id="member_id" name="member_id" @class(['select', 'is-invalid' => $errors->has('member_id')])>
                    <option value="">-- pilih anggota --</option>
                    @foreach ($members as $id => $label)
                        <option value="{{ $id }}" @selected(old('member_id') == $id)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('member_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="book_ids">Buku <span class="hint">(Ctrl+klik untuk memilih banyak, maks. 5; hanya buku yang stoknya tersedia)</span></label>
                <select id="book_ids" name="book_ids[]" multiple size="8" @class(['select', 'is-invalid' => $errors->has('book_ids')])>
                    @foreach ($books as $id => $title)
                        <option value="{{ $id }}" @selected($selectedBooks->contains($id))>{{ $title }}</option>
                    @endforeach
                </select>
                @error('book_ids') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                <a href="{{ route('circulation.loans.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
