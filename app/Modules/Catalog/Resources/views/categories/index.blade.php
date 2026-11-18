@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="page-header">
    <h1>Kategori</h1>
    <div class="actions">
        <a href="{{ route('catalog.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>Nama</th><th>Deskripsi</th><th>Jumlah Buku</th><th></th></tr></thead>
        <tbody>
        @forelse ($categories as $category)
            <tr>
                <td><strong>{{ $category->name }}</strong></td>
                <td class="muted">{{ $category->description }}</td>
                <td>{{ $category->books_count }}</td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('catalog.categories.edit', $category) }}">Edit</a>
                        <form method="POST" action="{{ route('catalog.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="link-btn danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="empty">Belum ada kategori.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $categories->links() }}
@endsection
