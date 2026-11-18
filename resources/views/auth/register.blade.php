@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="max-w-sm mx-auto bg-white rounded shadow p-6 mt-10">
    <h1 class="text-xl font-bold mb-4">Register Pustakawan</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf
        <input name="name" value="{{ old('name') }}" placeholder="Nama" class="w-full border rounded px-3 py-2">
        <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded px-3 py-2">
        <input name="password" type="password" placeholder="Password (min. 8)" class="w-full border rounded px-3 py-2">
        <input name="password_confirmation" type="password" placeholder="Ulangi password" class="w-full border rounded px-3 py-2">
        <button class="w-full bg-indigo-600 text-white rounded py-2">Daftar</button>
    </form>
    <p class="text-sm mt-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 underline">Login</a></p>
</div>
@endsection
