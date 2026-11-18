@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
    <dl class="grid grid-cols-3 gap-2 mt-4 text-sm">
        <dt class="text-slate-500">ISBN</dt><dd class="col-span-2">{{ $book->isbn }}</dd>
        <dt class="text-slate-500">Kategori</dt><dd class="col-span-2">{{ $book->category->name }}</dd>
        <dt class="text-slate-500">Penerbit</dt><dd class="col-span-2">{{ $book->publisher ?? '-' }}</dd>
        <dt class="text-slate-500">Tahun</dt><dd class="col-span-2">{{ $book->published_year ?? '-' }}</dd>
        <dt class="text-slate-500">Stok</dt><dd class="col-span-2">{{ $book->stock }}</dd>
        <dt class="text-slate-500">Penulis</dt>
        <dd class="col-span-2">
            @foreach ($book->authors as $author)
                <div>{{ $author->name }} <span class="text-xs text-slate-500">({{ $author->pivot->role }})</span></div>
            @endforeach
        </dd>
    </dl>
    <div class="mt-6 flex gap-3">
        <a href="{{ route('catalog.books.index') }}" class="underline">Kembali</a>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('catalog.books.edit', $book) }}" class="text-indigo-600 underline">Edit</a>
        @endif
    </div>
</div>
@endsection
