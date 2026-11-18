@extends('layouts.app')
@section('title', '403')
@section('content')
<div class="card card-narrow card-center">
    <div class="error-page">
        <div class="error-code">403</div>
        <h1>Akses Ditolak</h1>
        <p>{{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses ke halaman ini.' }}</p>
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
