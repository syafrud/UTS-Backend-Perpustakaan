<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <h1>{{ config('app.name') }}</h1>
            <p>@yield('subtitle')</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>

        <div class="auth-footer">@yield('footer')</div>
    </div>
</main>
</body>
</html>
