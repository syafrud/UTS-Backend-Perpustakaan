@extends('layouts.app')
@section('title', '429')
@section('content')
<div class="card card-narrow card-center">
    <div class="error-page">
        <div class="error-code">429</div>
        <h1>Terlalu Banyak Permintaan</h1>
        <p>Tunggu sebentar sebelum mencoba lagi.</p>
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
