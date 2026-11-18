@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="page-header">
    <h1>{{ $book->title }}</h1>
    <div class="actions">
        <a href="{{ route('catalog.books.index') }}" class="btn btn-secondary">Kembali</a>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('catalog.books.edit', $book) }}" class="btn btn-primary">Edit</a>
        @endif
    </div>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <dl class="detail flush">
            <dt>ISBN</dt><dd class="mono">{{ $book->isbn }}</dd>
            <dt>Kategori</dt><dd>{{ $book->category->name }}</dd>
            <dt>Penerbit</dt><dd>{{ $book->publisher ?? '-' }}</dd>
            <dt>Tahun terbit</dt><dd>{{ $book->published_year ?? '-' }}</dd>
            <dt>Stok</dt>
            <dd><span @class(['badge', 'badge-success' => $book->stock > 0, 'badge-danger' => $book->stock < 1])>{{ $book->stock }}</span></dd>
            <dt>Penulis</dt>
            <dd>
                @foreach ($book->authors as $author)
                    <div>{{ $author->name }} <span class="badge badge-neutral">{{ $author->pivot->role }}</span></div>
                @endforeach
            </dd>
        </dl>
    </div>
</div>
@endsection
