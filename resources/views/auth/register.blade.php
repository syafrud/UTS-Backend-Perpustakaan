@extends('layouts.guest')
@section('title', 'Register')
@section('subtitle', 'Daftar sebagai pustakawan')
@section('content')
<form method="POST" action="{{ route('register') }}" class="form">
    @csrf
    <div class="field">
        <label for="name">Nama</label>
        <input id="name" name="name" value="{{ old('name') }}" @class(['input', 'is-invalid' => $errors->has('name')]) autofocus>
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" @class(['input', 'is-invalid' => $errors->has('email')])>
    </div>
    <div class="field">
        <label for="password">Password <span class="hint">(min. 8 karakter)</span></label>
        <input id="password" name="password" type="password" @class(['input', 'is-invalid' => $errors->has('password')])>
    </div>
    <div class="field">
        <label for="password_confirmation">Ulangi password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="input">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
</form>
@endsection
@section('footer')
Sudah punya akun? <a href="{{ route('login') }}">Login</a>
@endsection
