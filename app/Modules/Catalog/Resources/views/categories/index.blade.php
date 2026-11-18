@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Kategori</h1>
    <a href="{{ route('catalog.categories.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Kategori</a>
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">Nama</th><th class="p-3">Deskripsi</th><th class="p-3">Jumlah Buku</th><th class="p-3"></th></tr></thead>
    <tbody>
    @forelse ($categories as $category)
        <tr class="border-t">
            <td class="p-3 font-medium">{{ $category->name }}</td>
            <td class="p-3">{{ $category->description }}</td>
            <td class="p-3">{{ $category->books_count }}</td>
            <td class="p-3 flex gap-3 justify-end">
                <a href="{{ route('catalog.categories.edit', $category) }}" class="text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('catalog.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="p-3 text-center text-slate-500">Belum ada kategori.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
