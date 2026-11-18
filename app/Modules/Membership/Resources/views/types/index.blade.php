@extends('layouts.app')
@section('title', 'Jenis Keanggotaan')
@section('content')
<div class="page-header">
    <h1>Jenis Keanggotaan</h1>
    <div class="actions">
        <a href="{{ route('membership.types.create') }}" class="btn btn-primary">Tambah Jenis</a>
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>Nama</th><th>Maks. Pinjam</th><th>Lama Pinjam</th><th>Denda / Hari</th><th>Anggota</th><th></th></tr></thead>
        <tbody>
        @forelse ($types as $type)
            <tr>
                <td><strong>{{ $type->name }}</strong></td>
                <td>{{ $type->max_loans }} buku</td>
                <td>{{ $type->loan_days }} hari</td>
                <td>Rp {{ number_format($type->fine_per_day, 0, ',', '.') }}</td>
                <td>{{ $type->members_count }}</td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('membership.types.edit', $type) }}">Edit</a>
                        <form method="POST" action="{{ route('membership.types.destroy', $type) }}" onsubmit="return confirm('Hapus jenis ini?')">
                            @csrf @method('DELETE')
                            <button class="link-btn danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Belum ada jenis keanggotaan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
