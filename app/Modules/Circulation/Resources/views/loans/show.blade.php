@extends('layouts.app')
@section('title', 'Peminjaman #'.$loan->id)
@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
    <h1 class="text-2xl font-bold">Peminjaman #{{ $loan->id }} <span class="text-base font-normal text-slate-500">({{ $loan->status() }})</span></h1>
    <dl class="grid grid-cols-3 gap-2 mt-4 text-sm">
        <dt class="text-slate-500">Anggota</dt><dd class="col-span-2">{{ $memberLabel }}</dd>
        <dt class="text-slate-500">Tanggal pinjam</dt><dd class="col-span-2">{{ $loan->loaned_at->format('d/m/Y') }}</dd>
        <dt class="text-slate-500">Jatuh tempo</dt><dd class="col-span-2">{{ $loan->due_at->format('d/m/Y') }}</dd>
        <dt class="text-slate-500">Dikembalikan</dt><dd class="col-span-2">{{ $loan->returned_at?->format('d/m/Y') ?? '-' }}</dd>
        <dt class="text-slate-500">Denda/hari/buku</dt><dd class="col-span-2">Rp {{ number_format($loan->fine_per_day, 0, ',', '.') }}</dd>
        <dt class="text-slate-500">Buku</dt>
        <dd class="col-span-2">
            <ul class="list-disc ml-5">
                @foreach ($loan->items as $item)
                    <li>{{ $bookTitles[$item->book_id] ?? 'Buku #'.$item->book_id.' (terhapus)' }}</li>
                @endforeach
            </ul>
        </dd>
        @if ($loan->fine)
            <dt class="text-slate-500">Denda</dt>
            <dd class="col-span-2 text-red-700">
                {{ $loan->fine->days_late }} hari telat &times; Rp {{ number_format($loan->fine_per_day, 0, ',', '.') }} &times; {{ $loan->items->count() }} buku
                = <b>Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</b>
                ({{ $loan->fine->paid_at ? 'lunas' : 'belum dibayar' }})
            </dd>
        @endif
    </dl>

    @unless ($loan->isReturned())
        <form method="POST" action="{{ route('circulation.loans.return', $loan) }}" class="mt-6 flex flex-wrap items-end gap-3 border-t pt-4">
            @csrf
            <label class="block text-sm">Tanggal kembali
                <input type="date" name="returned_at" value="{{ old('returned_at', today()->toDateString()) }}" class="border rounded px-3 py-2 @error('returned_at') border-red-500 @enderror">
            </label>
            <button class="bg-green-600 text-white rounded px-4 py-2">Proses Pengembalian</button>
            @error('returned_at') <span class="text-red-600 text-sm w-full">{{ $message }}</span> @enderror
        </form>
    @endunless

    <a href="{{ route('circulation.loans.index') }}" class="inline-block mt-6 underline">Kembali</a>
</div>
@endsection
