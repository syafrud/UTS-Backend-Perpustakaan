@extends('layouts.app')
@section('title', 'Anggota')
@section('content')
<div class="flex flex-wrap items-center gap-3 justify-between mb-4">
    <h1 class="text-2xl font-bold">Anggota</h1>
    <form class="flex gap-2">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama / kode" class="border rounded px-3 py-2">
        <button class="border rounded px-3">Cari</button>
    </form>
    <a href="{{ route('membership.members.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Anggota</a>
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">Kode</th><th class="p-3">Nama</th><th class="p-3">Email</th><th class="p-3">Jenis</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead>
    <tbody>
    @forelse ($members as $member)
        <tr class="border-t">
            <td class="p-3 font-mono">{{ $member->member_code }}</td>
            <td class="p-3 font-medium">{{ $member->name }}</td>
            <td class="p-3">{{ $member->email }}</td>
            <td class="p-3">{{ $member->type->name }}</td>
            <td class="p-3">{!! $member->is_active ? '<span class="text-green-700">Aktif</span>' : '<span class="text-red-600">Nonaktif</span>' !!}</td>
            <td class="p-3 flex gap-3 justify-end">
                <a href="{{ route('membership.members.edit', $member) }}" class="text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('membership.members.destroy', $member) }}" onsubmit="return confirm('Hapus anggota ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="p-3 text-center text-slate-500">Belum ada anggota.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $members->links() }}</div>
@endsection
