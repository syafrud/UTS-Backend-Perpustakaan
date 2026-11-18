@extends('layouts.app')
@section('title', '403')
@section('content')
<div class="bg-white rounded shadow p-8 text-center">
    <p class="text-5xl font-bold text-red-600">403</p>
    <h1 class="text-xl font-semibold mt-2">Akses Ditolak</h1>
    <p class="text-slate-600 mt-2">{{ $exception->getMessage() ?: 'Silakan kembali ke halaman sebelumnya.' }}</p>
    <a href="{{ url('/dashboard') }}" class="inline-block mt-4 text-indigo-600 underline">Kembali ke Dashboard</a>
</div>
@endsection
