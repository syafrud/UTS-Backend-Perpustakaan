<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@auth
    @php
        $menu = [
            ['Dashboard', 'dashboard', 'dashboard', false],
            ['Buku', 'catalog.books.index', 'catalog.books.*', false],
            ['Kategori', 'catalog.categories.index', 'catalog.categories.*', true],
            ['Penulis', 'catalog.authors.index', 'catalog.authors.*', true],
            ['Anggota', 'membership.members.index', 'membership.members.*', false],
            ['Jenis Keanggotaan', 'membership.types.index', 'membership.types.*', true],
            ['Peminjaman', 'circulation.loans.index', 'circulation.loans.*', false],
            ['Denda', 'circulation.fines.index', 'circulation.fines.*', false],
        ];
    @endphp
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('dashboard') }}" class="navbar-brand">{{ config('app.name') }}</a>
            <ul class="navbar-menu">
                @foreach ($menu as [$label, $route, $pattern, $adminOnly])
                    @continue($adminOnly && ! auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route($route) }}" @class(['nav-link', 'active' => request()->routeIs($pattern)])>{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="navbar-user">
                <span>{{ auth()->user()->name }}</span>
                <span class="role">{{ auth()->user()->role }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
@endauth

<main class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali isian Anda:</strong>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
