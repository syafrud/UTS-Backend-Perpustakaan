@extends('layouts.app')
@section('title', 'Buku')
@section('content')
<div class="page-header">
    <h1>Katalog Buku</h1>
    <div class="actions">
        <form class="search">
            <input name="q" value="{{ request('q') }}" placeholder="Cari judul / ISBN" class="input">
            <button class="btn btn-secondary">Cari</button>
        </form>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('catalog.books.create') }}" class="btn btn-primary">Tambah Buku</a>
        @endif
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>Judul</th><th>ISBN</th><th>Kategori</th><th>Penulis</th><th>Stok</th><th></th></tr></thead>
        <tbody>
        @forelse ($books as $book)
            <tr>
                <td><a href="{{ route('catalog.books.show', $book) }}"><strong>{{ $book->title }}</strong></a></td>
                <td class="mono">{{ $book->isbn }}</td>
                <td>{{ $book->category->name }}</td>
                <td class="muted">{{ $book->authors->pluck('name')->join(', ') }}</td>
                <td>
                    <span @class(['badge', 'badge-success' => $book->stock > 0, 'badge-danger' => $book->stock < 1])>{{ $book->stock }}</span>
                </td>
                <td>
                    @if (auth()->user()->isAdmin())
                        <div class="row-actions">
                            <a href="{{ route('catalog.books.edit', $book) }}">Edit</a>
                            <form method="POST" action="{{ route('catalog.books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button class="link-btn danger">Hapus</button>
                            </form>
                        </div>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Tidak ada buku.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $books->links() }}
@endsection
