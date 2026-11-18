@extends('layouts.app')
@section('title', 'Denda')
@section('content')
<div class="page-header">
    <h1>Denda Keterlambatan</h1>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>No.</th><th>Peminjaman</th><th>Anggota</th><th>Telat</th><th>Jumlah</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($fines as $fine)
            <tr>
                <td>{{ $fine->id }}</td>
                <td><a href="{{ route('circulation.loans.show', $fine->loan_id) }}">#{{ $fine->loan_id }}</a></td>
                <td>{{ $memberLabels[$fine->loan->member_id] ?? '(terhapus)' }}</td>
                <td>{{ $fine->days_late }} hari</td>
                <td><strong>Rp {{ number_format($fine->amount, 0, ',', '.') }}</strong></td>
                <td>
                    @if ($fine->paid_at)
                        <span class="badge badge-success">Lunas {{ $fine->paid_at->format('d/m/Y') }}</span>
                    @else
                        <form method="POST" action="{{ route('circulation.fines.pay', $fine) }}" class="inline-form">
                            @csrf
                            <button class="btn btn-success btn-sm">Tandai Lunas</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Belum ada denda.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $fines->links() }}
@endsection
