@extends('layouts.guest')
@section('title', 'Login')
@section('subtitle', 'Masuk untuk mengelola perpustakaan')
@section('content')
<form method="POST" action="{{ route('login') }}" class="form">
    @csrf
    <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" @class(['input', 'is-invalid' => $errors->has('email')]) autofocus>
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" class="input">
    </div>
    <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
</form>
@endsection
@section('footer')
Belum punya akun? <a href="{{ route('register') }}">Register</a>
@endsection
