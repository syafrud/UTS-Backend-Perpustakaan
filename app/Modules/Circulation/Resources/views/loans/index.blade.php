@extends('layouts.app')
@section('title', 'Peminjaman')
@section('content')
@php($statusBadge = ['Dikembalikan' => 'badge-success', 'Terlambat' => 'badge-danger', 'Dipinjam' => 'badge-warning'])
<div class="page-header">
    <h1>Peminjaman</h1>
    <div class="actions">
        <nav class="tabs">
            <a href="{{ route('circulation.loans.index') }}" @class(['tab', 'active' => ! request('status')])>Semua</a>
            <a href="{{ route('circulation.loans.index', ['status' => 'active']) }}" @class(['tab', 'active' => request('status') === 'active'])>Dipinjam</a>
            <a href="{{ route('circulation.loans.index', ['status' => 'returned']) }}" @class(['tab', 'active' => request('status') === 'returned'])>Dikembalikan</a>
        </nav>
        <a href="{{ route('circulation.loans.create') }}" class="btn btn-primary">Peminjaman Baru</a>
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>No.</th><th>Anggota</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($loans as $loan)
            @php($status = $loan->status())
            <tr class="row-link">
                <td><a href="{{ route('circulation.loans.show', $loan) }}" class="stretched"><strong>#{{ $loan->id }}</strong></a></td>
                <td>{{ $memberLabels[$loan->member_id] ?? '(terhapus)' }}</td>
                <td class="muted">{{ $loan->items->map(fn ($i) => $bookTitles[$i->book_id] ?? '(terhapus)')->join(', ') }}</td>
                <td>{{ $loan->loaned_at->format('d/m/Y') }}</td>
                <td>{{ $loan->due_at->format('d/m/Y') }}</td>
                <td>
                    <span class="badge {{ $statusBadge[$status] }}">{{ $status }}</span>
                    @if ($loan->fine)
                        <div class="fine-note">Denda Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</div>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Belum ada peminjaman.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $loans->links() }}
@endsection
