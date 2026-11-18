<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4.1.11"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
@auth
    <nav class="bg-indigo-700 text-white">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap items-center gap-4">
            <a href="{{ route('dashboard') }}" class="font-bold mr-4">📚 {{ config('app.name') }}</a>
            <a href="{{ route('catalog.books.index') }}" class="hover:underline">Buku</a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('catalog.categories.index') }}" class="hover:underline">Kategori</a>
                <a href="{{ route('catalog.authors.index') }}" class="hover:underline">Penulis</a>
                <a href="{{ route('membership.types.index') }}" class="hover:underline">Jenis Keanggotaan</a>
            @endif
            <a href="{{ route('membership.members.index') }}" class="hover:underline">Anggota</a>
            <a href="{{ route('circulation.loans.index') }}" class="hover:underline">Peminjaman</a>
            <a href="{{ route('circulation.fines.index') }}" class="hover:underline">Denda</a>
            <div class="ml-auto flex items-center gap-3 text-sm">
                <span>{{ auth()->user()->name }}
                    <span class="px-2 py-0.5 rounded bg-white/20 uppercase text-xs">{{ auth()->user()->role }}</span></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>
@endauth

<main class="max-w-6xl mx-auto px-4 py-6">
    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800">✅ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">⛔ {{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
            <p class="font-semibold">Periksa kembali isian Anda:</p>
            <ul class="list-disc ml-5">
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
