@extends('layouts.app')
@section('content')
<div class="page-header">
    <div>
        <h1>Halo, {{ auth()->user()->name }}</h1>
        <p class="page-subtitle">Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.</p>
    </div>
</div>
<div class="grid-3">
    <div class="card module-card">
        <div class="card-body">
            <span class="label">CatalogModule</span>
            <h2>Katalog Buku</h2>
            <p>Buku, penulis, dan kategori{{ auth()->user()->isAdmin() ? '' : ' (lihat saja)' }}.</p>
            <a href="{{ route('catalog.books.index') }}" class="btn btn-secondary btn-sm">Buka katalog</a>
        </div>
    </div>
    <div class="card module-card">
        <div class="card-body">
            <span class="label">MembershipModule</span>
            <h2>Keanggotaan</h2>
            <p>Data anggota dan jenis keanggotaan.</p>
            <a href="{{ route('membership.members.index') }}" class="btn btn-secondary btn-sm">Buka anggota</a>
        </div>
    </div>
    <div class="card module-card">
        <div class="card-body">
            <span class="label">CirculationModule</span>
            <h2>Sirkulasi</h2>
            <p>Peminjaman, pengembalian, dan denda.</p>
            <a href="{{ route('circulation.loans.index') }}" class="btn btn-secondary btn-sm">Buka peminjaman</a>
        </div>
    </div>
</div>
@endsection
