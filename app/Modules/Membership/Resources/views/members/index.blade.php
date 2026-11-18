@extends('layouts.app')
@section('title', 'Anggota')
@section('content')
<div class="page-header">
    <h1>Anggota</h1>
    <div class="actions">
        <form class="search">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama / kode" class="input">
            <button class="btn btn-secondary">Cari</button>
        </form>
        <a href="{{ route('membership.members.create') }}" class="btn btn-primary">Tambah Anggota</a>
    </div>
</div>
<div class="card table-wrap">
    <table class="table">
        <thead><tr><th>Kode</th><th>Nama</th><th>Email</th><th>Jenis</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($members as $member)
            <tr>
                <td class="mono">{{ $member->member_code }}</td>
                <td><strong>{{ $member->name }}</strong></td>
                <td class="muted">{{ $member->email }}</td>
                <td>{{ $member->type->name }}</td>
                <td>
                    <span @class(['badge', 'badge-success' => $member->is_active, 'badge-danger' => ! $member->is_active])>{{ $member->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('membership.members.edit', $member) }}">Edit</a>
                        <form method="POST" action="{{ route('membership.members.destroy', $member) }}" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button class="link-btn danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="empty">Belum ada anggota.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $members->links() }}
@endsection
