@extends('layouts.app')
@section('title', '404')
@section('content')
<div class="card card-narrow card-center">
    <div class="error-page">
        <div class="error-code">404</div>
        <h1>Data Tidak Ditemukan</h1>
        <p>Data atau halaman yang Anda cari tidak ada.</p>
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
