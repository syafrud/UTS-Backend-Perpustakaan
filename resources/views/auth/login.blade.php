@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="max-w-sm mx-auto bg-white rounded shadow p-6 mt-10">
    <h1 class="text-xl font-bold mb-4">Login</h1>
    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf
        <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded px-3 py-2">
        <input name="password" type="password" placeholder="Password" class="w-full border rounded px-3 py-2">
        <label class="flex gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
        <button class="w-full bg-indigo-600 text-white rounded py-2">Masuk</button>
    </form>
    <p class="text-sm mt-4">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 underline">Register</a></p>
</div>
@endsection
