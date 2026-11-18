@extends('layouts.app')
@section('title', 'Peminjaman')
@section('content')
<div class="flex flex-wrap items-center gap-3 justify-between mb-4">
    <h1 class="text-2xl font-bold">Peminjaman</h1>
    <div class="flex gap-2 text-sm">
        <a href="{{ route('circulation.loans.index') }}" class="px-3 py-1 rounded {{ request('status') ? 'bg-white' : 'bg-indigo-100' }}">Semua</a>
        <a href="{{ route('circulation.loans.index', ['status' => 'active']) }}" class="px-3 py-1 rounded {{ request('status') === 'active' ? 'bg-indigo-100' : 'bg-white' }}">Dipinjam</a>
        <a href="{{ route('circulation.loans.index', ['status' => 'returned']) }}" class="px-3 py-1 rounded {{ request('status') === 'returned' ? 'bg-indigo-100' : 'bg-white' }}">Dikembalikan</a>
    </div>
    <a href="{{ route('circulation.loans.create') }}" class="bg-indigo-600 text-white rounded px-4 py-2">+ Peminjaman</a>
</div>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">#</th><th class="p-3">Anggota</th><th class="p-3">Buku</th><th class="p-3">Pinjam</th><th class="p-3">Jatuh Tempo</th><th class="p-3">Status</th></tr></thead>
    <tbody>
    @forelse ($loans as $loan)
        @php($status = $loan->status())
        <tr class="border-t">
            <td class="p-3"><a href="{{ route('circulation.loans.show', $loan) }}" class="text-indigo-700 underline">#{{ $loan->id }}</a></td>
            <td class="p-3">{{ $memberLabels[$loan->member_id] ?? '(terhapus)' }}</td>
            <td class="p-3">{{ $loan->items->map(fn ($i) => $bookTitles[$i->book_id] ?? '(terhapus)')->join(', ') }}</td>
            <td class="p-3">{{ $loan->loaned_at->format('d/m/Y') }}</td>
            <td class="p-3">{{ $loan->due_at->format('d/m/Y') }}</td>
            <td class="p-3">
                <span class="px-2 py-0.5 rounded text-xs {{ ['Dikembalikan' => 'bg-green-100 text-green-800', 'Terlambat' => 'bg-red-100 text-red-800', 'Dipinjam' => 'bg-yellow-100 text-yellow-800'][$status] }}">{{ $status }}</span>
                @if ($loan->fine) <span class="text-xs text-red-700">Denda Rp {{ number_format($loan->fine->amount, 0, ',', '.') }}</span> @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="p-3 text-center text-slate-500">Belum ada peminjaman.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $loans->links() }}</div>
@endsection
