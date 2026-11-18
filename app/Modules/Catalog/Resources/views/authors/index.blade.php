@extends('layouts.app')
@section('title', 'Penulis')
@section('content')
<div class="page-header">
    <h1>Penulis</h1>
    <div class="actions">
        <a href="{{ route('catalog.authors.create') }}" class="btn btn-primary">Tambah Penulis</a>
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>Nama</th><th>Biografi</th><th>Jumlah Buku</th><th></th></tr></thead>
        <tbody>
        @forelse ($authors as $author)
            <tr>
                <td><strong>{{ $author->name }}</strong></td>
                <td class="muted">{{ \Illuminate\Support\Str::limit($author->bio, 60) }}</td>
                <td>{{ $author->books_count }}</td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('catalog.authors.edit', $author) }}">Edit</a>
                        <form method="POST" action="{{ route('catalog.authors.destroy', $author) }}" onsubmit="return confirm('Hapus penulis ini?')">
                            @csrf @method('DELETE')
                            <button class="link-btn danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="empty">Belum ada penulis.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $authors->links() }}
@endsection
