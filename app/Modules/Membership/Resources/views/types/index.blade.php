@extends('layouts.app')
@section('title', 'Jenis Keanggotaan')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Jenis Keanggotaan</h1>
    <a href="{{ route('membership.types.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Jenis</a>
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">Nama</th><th class="p-3">Maks. Pinjam</th><th class="p-3">Lama Pinjam</th><th class="p-3">Denda/Hari</th><th class="p-3">Anggota</th><th class="p-3"></th></tr></thead>
    <tbody>
    @foreach ($types as $type)
        <tr class="border-t">
            <td class="p-3 font-medium">{{ $type->name }}</td>
            <td class="p-3">{{ $type->max_loans }} buku</td>
            <td class="p-3">{{ $type->loan_days }} hari</td>
            <td class="p-3">Rp {{ number_format($type->fine_per_day, 0, ',', '.') }}</td>
            <td class="p-3">{{ $type->members_count }}</td>
            <td class="p-3 flex gap-3 justify-end">
                <a href="{{ route('membership.types.edit', $type) }}" class="text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('membership.types.destroy', $type) }}" onsubmit="return confirm('Hapus jenis ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
