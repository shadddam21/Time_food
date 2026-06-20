<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TimeFood') }} - Restoran</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-slate-700">
            <span class="text-xl font-bold text-orange-500">TimeFood</span>
            <span class="ml-2 text-sm text-slate-300">Restoran</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('foods.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('foods.*') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-utensils w-5 text-center"></i>
                <span>Kelola Makanan</span>
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('orders.*') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
                <span>Pesanan Masuk</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                <span>Riwayat Transaksi</span>
            </a>
            <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('pengaturan.*') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
            <div class="md:hidden">
                <span class="text-xl font-bold text-orange-500">TimeFood</span>
            </div>
            
            <!-- Spacer for desktop -->
            <div class="hidden md:block"></div>

            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Restoran' }}</span>
                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 font-bold">
                    {{ substr(auth()->user()->name ?? 'R', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
