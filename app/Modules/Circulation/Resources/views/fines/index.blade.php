@extends('layouts.app')
@section('title', 'Denda')
@section('content')
<h1 class="text-2xl font-bold mb-4">Denda Keterlambatan</h1>
<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-slate-50 text-left"><tr><th class="p-3">#</th><th class="p-3">Peminjaman</th><th class="p-3">Anggota</th><th class="p-3">Telat</th><th class="p-3">Jumlah</th><th class="p-3">Status</th></tr></thead>
    <tbody>
    @forelse ($fines as $fine)
        <tr class="border-t">
            <td class="p-3">{{ $fine->id }}</td>
            <td class="p-3"><a href="{{ route('circulation.loans.show', $fine->loan_id) }}" class="text-indigo-700 underline">#{{ $fine->loan_id }}</a></td>
            <td class="p-3">{{ $memberLabels[$fine->loan->member_id] ?? '(terhapus)' }}</td>
            <td class="p-3">{{ $fine->days_late }} hari</td>
            <td class="p-3">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
            <td class="p-3">
                @if ($fine->paid_at)
                    <span class="text-green-700">Lunas {{ $fine->paid_at->format('d/m/Y') }}</span>
                @else
                    <form method="POST" action="{{ route('circulation.fines.pay', $fine) }}">
                        @csrf
                        <button class="bg-green-600 text-white rounded px-3 py-1 text-xs">Tandai Lunas</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="p-3 text-center text-slate-500">Belum ada denda.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4">{{ $fines->links() }}</div>
@endsection
