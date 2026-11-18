@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-2">Halo, {{ auth()->user()->name }}</h1>
<p class="mb-6 text-slate-600">Anda login sebagai <b>{{ auth()->user()->role }}</b>.</p>
<div class="grid sm:grid-cols-3 gap-4">
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold">CatalogModule</h2>
        <p class="text-sm text-slate-600">Buku, Penulis, Kategori{{ auth()->user()->isAdmin() ? ' (kelola)' : ' (lihat)' }}.</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold">MembershipModule</h2>
        <p class="text-sm text-slate-600">Anggota & Jenis Keanggotaan.</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold">CirculationModule</h2>
        <p class="text-sm text-slate-600">Peminjaman, Pengembalian, Denda.</p>
    </div>
</div>
@endsection
