@extends('layouts.app')
@section('title', 'Buku')
@section('content')
<div class="flex flex-wrap items-center gap-3 justify-between mb-4">
    <h1 class="text-2xl font-bold">Katalog Buku</h1>
    <form class="flex gap-2">
        <input name="q" value="{{ request('q') }}" placeholder="Cari judul / ISBN" class="border rounded px-3 py-2">
        <button class="border rounded px-3">Cari</button>
    </form>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('catalog.books.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Buku</a>
    @endif
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">Judul</th><th class="p-3">ISBN</th><th class="p-3">Kategori</th><th class="p-3">Penulis</th><th class="p-3">Stok</th><th class="p-3"></th></tr></thead>
    <tbody>
    @forelse ($books as $book)
        <tr class="border-t">
            <td class="p-3 font-medium"><a href="{{ route('catalog.books.show', $book) }}" class="text-indigo-700">{{ $book->title }}</a></td>
            <td class="p-3">{{ $book->isbn }}</td>
            <td class="p-3">{{ $book->category->name }}</td>
            <td class="p-3">{{ $book->authors->pluck('name')->join(', ') }}</td>
            <td class="p-3"><span class="{{ $book->stock ? 'text-green-700' : 'text-red-600 font-semibold' }}">{{ $book->stock }}</span></td>
            <td class="p-3 flex gap-3 justify-end">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('catalog.books.edit', $book) }}" class="text-indigo-600">Edit</a>
                    <form method="POST" action="{{ route('catalog.books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="p-3 text-center text-slate-500">Tidak ada buku.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $books->links() }}</div>
@endsection
