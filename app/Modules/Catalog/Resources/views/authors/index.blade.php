@extends('layouts.app')
@section('title', 'Penulis')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Penulis</h1>
    <a href="{{ route('catalog.authors.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Penulis</a>
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">Nama</th><th class="p-3">Bio</th><th class="p-3">Jumlah Buku</th><th class="p-3"></th></tr></thead>
    <tbody>
    @forelse ($authors as $author)
        <tr class="border-t">
            <td class="p-3 font-medium">{{ $author->name }}</td>
            <td class="p-3">{{ \Illuminate\Support\Str::limit($author->bio, 60) }}</td>
            <td class="p-3">{{ $author->books_count }}</td>
            <td class="p-3 flex gap-3 justify-end">
                <a href="{{ route('catalog.authors.edit', $author) }}" class="text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('catalog.authors.destroy', $author) }}" onsubmit="return confirm('Hapus penulis ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="p-3 text-center text-slate-500">Belum ada penulis.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $authors->links() }}</div>
@endsection
