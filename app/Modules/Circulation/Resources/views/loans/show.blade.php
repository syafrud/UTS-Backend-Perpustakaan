@extends('layouts.app')
@section('title', 'Peminjaman #'.$loan->id)
@section('content')
@php($status = $loan->status())
@php($statusBadge = ['Dikembalikan' => 'badge-success', 'Terlambat' => 'badge-danger', 'Dipinjam' => 'badge-warning'])
<div class="page-header">
    <h1>Peminjaman #{{ $loan->id }} <span class="badge {{ $statusBadge[$status] }}">{{ $status }}</span></h1>
    <div class="actions">
        <a href="{{ route('circulation.loans.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
<div class="card card-narrow">
    <div class="card-body">
        <dl class="detail flush">
            <dt>Anggota</dt><dd>{{ $memberLabel }}</dd>
            <dt>Tanggal pinjam</dt><dd>{{ $loan->loaned_at->format('d/m/Y') }}</dd>
            <dt>Jatuh tempo</dt><dd>{{ $loan->due_at->format('d/m/Y') }}</dd>
            <dt>Dikembalikan</dt><dd>{{ $loan->returned_at?->format('d/m/Y') ?? '-' }}</dd>
            <dt>Denda / hari / buku</dt><dd>Rp {{ number_format($loan->fine_per_day, 0, ',', '.') }}</dd>
            <dt>Buku</dt>
            <dd>
                <ul>
                    @foreach ($loan->items as $item)
                        <li>{{ $bookTitles[$item->book_id] ?? 'Buku #'.$item->book_id.' (terhapus)' }}</li>
                    @endforeach
                </ul>
            </dd>
            @if ($loan->fine)
                <dt>Denda</dt>
                <dd>
                    {{ $loan->fine->days_late }} hari &times; Rp {{ number_format($loan->fine_per_day, 0, ',', '.') }} &times; {{ $loan->items->count() }} buku
                    = <strong class="text-danger">Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</strong>
                    <span @class(['badge', 'badge-success' => $loan->fine->paid_at, 'badge-danger' => ! $loan->fine->paid_at])>{{ $loan->fine->paid_at ? 'Lunas' : 'Belum dibayar' }}</span>
                </dd>
            @endif
        </dl>

        @unless ($loan->isReturned())
            <hr class="divider">
            <form method="POST" action="{{ route('circulation.loans.return', $loan) }}" class="form-actions return-form">
                @csrf
                <div class="field">
                    <label for="returned_at">Tanggal kembali</label>
                    <input id="returned_at" type="date" name="returned_at" value="{{ old('returned_at', today()->toDateString()) }}" @class(['input', 'is-invalid' => $errors->has('returned_at')])>
                </div>
                <button type="submit" class="btn btn-success">Proses Pengembalian</button>
            </form>
            @error('returned_at') <span class="field-error">{{ $message }}</span> @enderror
        @endunless
    </div>
</div>
@endsection
