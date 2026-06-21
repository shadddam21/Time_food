<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TimeFood') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }">
        
        <div class="flex min-h-screen">
            
            <!-- Desktop Sidebar -->
            <aside class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 fixed inset-y-0 z-20">
                <div class="p-6 flex items-center justify-center border-b border-slate-100">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54 54" class="w-8 h-8 flex-shrink-0">
                            <circle cx="27" cy="27" r="23" fill="none" stroke="#1E293B" stroke-width="3"/>
                            <circle cx="27" cy="27" r="2.5" fill="#F97316"/>
                            <circle cx="27" cy="7" r="2" fill="#F97316"/>
                            <circle cx="47" cy="27" r="2" fill="#F97316"/>
                            <circle cx="27" cy="47" r="2" fill="#F97316"/>
                            <circle cx="7" cy="27" r="2" fill="#F97316"/>
                            <line x1="27" y1="27" x2="16" y2="12" stroke="#1E293B" stroke-width="2.5" stroke-linecap="round"/>
                            <g transform="translate(27,27) rotate(50)">
                                <line x1="0" y1="0" x2="0" y2="-17" stroke="#F97316" stroke-width="2.5" stroke-linecap="round"/>
                                <line x1="-3.5" y1="-17" x2="-3.5" y2="-24" stroke="#F97316" stroke-width="1.8" stroke-linecap="round"/>
                                <line x1="0" y1="-17" x2="0" y2="-24" stroke="#F97316" stroke-width="1.8" stroke-linecap="round"/>
                                <line x1="3.5" y1="-17" x2="3.5" y2="-24" stroke="#F97316" stroke-width="1.8" stroke-linecap="round"/>
                            </g>
                        </svg>
                        <span class="text-xl font-black tracking-tight">Time<span class="text-orange-500">Food</span></span>
                    </a>
                </div>
                
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('menu.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('menu.*') ? 'bg-orange-50 text-orange-600 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                        <i class="fa-solid fa-house w-6"></i> Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" class="flex items-center gap-4 px-6 py-3 text-sm font-semibold text-slate-500 hover:text-orange-500 hover:bg-orange-50 transition-colors">
                        <i class="fa-solid fa-compass w-5 text-center text-lg"></i>
                        Jelajahi
                    </a>
                    <a href="{{ route('my-orders.index') }}" class="flex items-center gap-4 px-6 py-3 text-sm font-semibold text-slate-500 hover:text-orange-500 hover:bg-orange-50 transition-colors">
                        <i class="fa-solid fa-receipt w-5 text-center text-lg"></i>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('favorites.index') }}" class="flex items-center gap-4 px-6 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('favorites.*') ? 'text-red-500 bg-red-50' : 'text-slate-500 hover:text-red-500 hover:bg-red-50' }}">
                        <i class="fa-solid fa-heart w-5 text-center text-lg"></i>
                        Favorit
                    </a>
                    
                    <div class="px-6 py-4 mt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-4 px-4 py-3 text-sm font-semibold text-red-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                <i class="fa-solid fa-right-from-bracket w-5 text-center text-lg"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </nav>

                <!-- Resto Banner -->
                <div class="p-6 mt-auto">
                    <div class="bg-orange-50 rounded-2xl p-5 text-center relative overflow-hidden" x-data="{ showRestoModal: false }">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-orange-100 rounded-full opacity-50"></div>
                        <h4 class="font-bold text-orange-800 text-sm mb-1 relative z-10">Punya Restoran?</h4>
                        <p class="text-[10px] text-orange-600 mb-4 relative z-10">Gabung dan jual makanan berlebihmu!</p>
                        <button @click.prevent="showRestoModal = true" class="w-full py-2 bg-orange-500 text-white rounded-xl text-xs font-bold hover:bg-orange-600 transition-colors shadow-sm relative z-10">
                            Daftar Restoran
                        </button>
                        
                        <!-- Modal Restoran -->
                        <div x-show="showRestoModal" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                            <div @click.away="showRestoModal = false" class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl text-left transform transition-all">
                                <div class="w-12 h-12 bg-red-100 text-red-500 rounded-2xl flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 mb-2">Logout Diperlukan</h3>
                                <p class="text-slate-500 text-sm mb-6 leading-relaxed">Anda saat ini sedang login sebagai Customer. Silakan logout terlebih dahulu jika Anda ingin mendaftar akun baru sebagai Restoran.</p>
                                <div class="flex gap-3">
                                    <button @click="showRestoModal = false" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl transition-colors">Batal</button>
                                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition-colors">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col md:ml-64 w-full">
                
                <!-- Top Navbar (Desktop & Mobile) -->
                <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-10">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                        <!-- Mobile Logo / Menu Toggle -->
                        <div class="flex items-center gap-3 md:hidden">
                            <span class="text-lg font-black tracking-tight text-slate-800">Time<span class="text-orange-500">Food</span></span>
                        </div>

                        <!-- Desktop Search -->
                        <div class="hidden md:block flex-1 max-w-md ml-4">
                            <form action="{{ route('menu.index') }}" method="GET" class="relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari makanan, restoran..." class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full focus:ring-2 focus:ring-orange-500 text-sm">
                            </form>
                        </div>

                        <!-- Right Profile & Actions -->
                        <div class="flex items-center gap-4">
                            <!-- Notifications Dropdown -->
                            <div class="relative" x-data="{ notifDropdownOpen: false }">
                                <button @click="notifDropdownOpen = !notifDropdownOpen" @click.away="notifDropdownOpen = false" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-orange-50 hover:text-orange-500 transition-colors relative focus:outline-none">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                                </button>
                                
                                <div x-show="notifDropdownOpen" x-transition x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center">
                                        <h3 class="font-bold text-slate-800">Notifikasi</h3>
                                        <span class="text-xs text-orange-500 font-semibold bg-orange-50 px-2 py-1 rounded-md">2 Baru</span>
                                    </div>
                                    <div class="max-h-64 overflow-y-auto">
                                        <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors cursor-pointer opacity-100 bg-orange-50/30">
                                            <p class="text-sm font-bold text-slate-800 mb-0.5">Pesanan Siap Diambil!</p>
                                            <p class="text-xs text-slate-500">Misteri Box Nasi kamu sudah siap di Restoran XYZ. Jangan lupa ambil sebelum jam 22.30.</p>
                                            <p class="text-[10px] text-slate-400 mt-1">2 menit yang lalu</p>
                                        </div>
                                        <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors cursor-pointer opacity-100 bg-orange-50/30">
                                            <p class="text-sm font-bold text-slate-800 mb-0.5">Promo Spesial Hari Ini 🚀</p>
                                            <p class="text-xs text-slate-500">Dapatkan diskon hingga 50% untuk kategori Real Food di sekitarmu. Cek sekarang!</p>
                                            <p class="text-[10px] text-slate-400 mt-1">1 jam yang lalu</p>
                                        </div>
                                        <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors cursor-pointer opacity-75">
                                            <p class="text-sm font-bold text-slate-800 mb-0.5">Selamat Datang di TimeFood</p>
                                            <p class="text-xs text-slate-500">Terima kasih telah bergabung menjadi pahlawan anti food waste.</p>
                                            <p class="text-[10px] text-slate-400 mt-1">1 hari yang lalu</p>
                                        </div>
                                    </div>
                                    <div class="px-4 py-2 border-t border-slate-100 text-center">
                                        <a href="#" class="text-xs font-bold text-orange-500 hover:text-orange-600">Tandai semua dibaca</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button @click="profileDropdownOpen = !profileDropdownOpen" @click.away="profileDropdownOpen = false" class="flex items-center gap-2 focus:outline-none">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover" alt="Profile">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f97316&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="Profile">
                                    @endif
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500">Customer</p>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 hidden md:block"></i>
                                </button>

                                <!-- Profile Dropdown Menu -->
                                <div x-show="profileDropdownOpen" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-lg border border-slate-100 py-2 z-50">
                                    <div class="px-4 py-2 border-b border-slate-100 mb-2 md:hidden">
                                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                        <i class="fa-regular fa-user w-5"></i> Profil Saya
                                    </a>
                                    <a href="{{ route('my-orders.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-orange-50 hover:text-orange-600 transition-colors md:hidden">
                                        <i class="fa-solid fa-receipt w-5"></i> Pesanan Saya
                                    </a>
                                    <div class="border-t border-slate-100 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 pb-20 md:pb-8">
                    {{ $slot }}
                </main>
            </div>
            
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 px-6 py-3 flex justify-between items-center shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
            <a href="{{ route('menu.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('menu.*') ? 'text-orange-500' : 'text-slate-400' }}">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center gap-1 text-slate-400">
                <i class="fa-solid fa-compass text-lg"></i>
                <span class="text-[10px] font-medium">Jelajahi</span>
            </a>
            <a href="{{ route('my-orders.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('my-orders.*') || request()->routeIs('orders.checkout') ? 'text-orange-500' : 'text-slate-400' }}">
                <div class="relative">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </div>
                <span class="text-[10px] font-medium">Pesanan</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('profile.*') ? 'text-orange-500' : 'text-slate-400' }}">
                <i class="fa-regular fa-user text-lg"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        </div>

    </body>
</html>
