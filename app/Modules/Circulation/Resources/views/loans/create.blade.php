@extends('layouts.app')
@section('title', 'Peminjaman Baru')
@section('content')
@php($selectedBooks = collect(old('book_ids', []))->map(fn ($id) => (int) $id))
<h1 class="text-2xl font-bold mb-4">Peminjaman Baru</h1>
<form method="POST" action="{{ route('circulation.loans.store') }}" class="bg-white rounded shadow p-6 space-y-4 max-w-xl">
    @csrf
    <label class="block">Anggota (aktif)
        <select name="member_id" class="w-full border rounded px-3 py-2 @error('member_id') border-red-500 @enderror">
            <option value="">-- pilih anggota --</option>
            @foreach ($members as $id => $label)
                <option value="{{ $id }}" @selected(old('member_id') == $id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('member_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <label class="block">Buku <span class="text-xs text-slate-500">(Ctrl+klik untuk pilih banyak, maks. 5; hanya buku dengan stok tersedia)</span>
        <select name="book_ids[]" multiple size="8" class="w-full border rounded px-3 py-2 @error('book_ids') border-red-500 @enderror">
            @foreach ($books as $id => $title)
                <option value="{{ $id }}" @selected($selectedBooks->contains($id))>{{ $title }}</option>
            @endforeach
        </select>
        @error('book_ids') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
    <button class="bg-indigo-600 text-white rounded px-4 py-2">Simpan Peminjaman</button>
    <a href="{{ route('circulation.loans.index') }}" class="ml-2">Batal</a>
</form>
@endsection
