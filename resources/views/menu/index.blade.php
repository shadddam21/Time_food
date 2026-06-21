<x-app-layout>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    <!-- Menambahkan inline style height 100vh agar layout tidak tembus ke bawah -->
    <div class="flex bg-[#EFEFEF] text-gray-800 font-sans" style="height: 100vh; overflow: hidden;">

        <!-- Memaksa lebar 260px dengan inline style agar tidak hilang -->
        <aside class="flex flex-col justify-between flex-shrink-0 py-6 bg-white border-r border-gray-200"
            style="width: 260px; min-width: 260px; overflow-y: auto;">
            <div>
                <!-- Logo -->
                <div class="flex items-center px-8 mb-10">
                    <img src="{{ asset('images/WhatsApp Image 2026-06-18 at 21.36.32.jpeg') }}" alt="TimeFood"
                        class="object-contain" style="height: 2.5rem;">
                </div>

                <!-- Main Menu -->
                <div class="space-y-1">
                    <a href="#"
                        class="flex items-center gap-4 px-8 py-3 font-bold text-[#9D4B00] bg-orange-50/50 border-l-4 border-[#9D4B00]">
                        <iconify-icon icon="mdi:home" class="text-2xl"></iconify-icon> Home
                    </a>
                    <a href="#"
                        class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                        <iconify-icon icon="mdi:near-me" class="text-2xl"></iconify-icon> Nearby Food
                    </a>
                    <a href="#"
                        class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                        <iconify-icon icon="mdi:gift-outline" class="text-2xl"></iconify-icon> Gacha
                    </a>
                    <a href="#"
                        class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                        <iconify-icon icon="mdi:silverware-fork-knife" class="text-2xl"></iconify-icon> Real Food
                    </a>
                </div>

                <!-- Account Menu -->
                <div class="mt-8">
                    <p class="px-8 mb-3 text-xs font-bold tracking-wider text-gray-400 uppercase">Account</p>
                    <div class="space-y-1">
                        <a href="#"
                            class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                            <iconify-icon icon="mdi:history" class="text-2xl"></iconify-icon> Order History
                        </a>
                        <a href="#"
                            class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                            <iconify-icon icon="mdi:heart-outline" class="text-2xl"></iconify-icon> Favorites
                        </a>
                        <a href="#"
                            class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 hover:text-[#9D4B00] hover:bg-orange-50/30 transition">
                            <iconify-icon icon="mdi:account-outline" class="text-2xl"></iconify-icon> Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Menu -->
            <div class="mt-8 space-y-1">
                <a href="#"
                    class="flex items-center gap-4 px-8 py-3 font-medium text-gray-500 transition hover:text-gray-800">
                    <iconify-icon icon="mdi:help-circle-outline" class="text-2xl"></iconify-icon> Help
                </a>
                <a href="#"
                    class="flex items-center gap-4 px-8 py-3 font-medium text-red-600 transition hover:bg-red-50">
                    <iconify-icon icon="mdi:logout" class="text-2xl"></iconify-icon> Logout
                </a>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full overflow-hidden">

            <header class="z-10 flex items-center flex-shrink-0 w-full bg-white border-b shadow-sm"
                style="height: 80px;">
                <div class="flex items-center justify-between w-full px-8"
                    style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <!-- Centered Nav -->
                    <nav class="flex mx-auto text-sm font-semibold"
                        style="display: flex; gap: 2.5rem; justify-content: center;">
                        <a href="#" class="pb-1 text-orange-500 border-b-2 border-orange-500"
                            style="color: #f97316; border-bottom: 2px solid #f97316; padding-bottom: 0.25rem;">Meal
                            Plans</a>
                        <a href="#" class="text-gray-500 transition hover:text-orange-500"
                            style="color: #6b7280;">Discover</a>
                        <a href="#" class="text-gray-500 transition hover:text-orange-500"
                            style="color: #6b7280;">Favorites</a>
                        <a href="#" class="text-gray-500 transition hover:text-orange-500"
                            style="color: #6b7280;">Stockists</a>
                        <a href="#" class="text-gray-500 transition hover:text-orange-500"
                            style="color: #6b7280;">About</a>
                        <a href="#" class="text-gray-500 transition hover:text-orange-500"
                            style="color: #6b7280;">Contact</a>
                    </nav>

                    <!-- Right Actions -->
                    <div class="flex items-center ml-auto" style="display: flex; gap: 1rem; align-items: center;">
                        <button class="flex items-center gap-2 mr-4 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition"
                            style="display: flex; align-items: center; gap: 0.5rem; margin-right: 1rem;">
                            <iconify-icon icon="mdi:cart-outline" class="text-xl text-green-600"
                                style="color: #16a34a; font-size: 1.5rem;"></iconify-icon>
                            <span class="text-sm font-semibold text-gray-700">Your Cart (0)</span>
                        </button>
                        <button class="p-2 text-gray-500 transition border border-gray-200 rounded-lg hover:bg-gray-50">
                            <iconify-icon icon="mdi:account-outline" class="text-lg"></iconify-icon>
                        </button>
                        <button class="p-2 text-gray-500 transition border border-gray-200 rounded-lg hover:bg-gray-50">
                            <iconify-icon icon="mdi:magnify" class="text-lg"></iconify-icon>
                        </button>
                        <button
                            class="relative p-2 text-gray-500 transition border border-gray-200 rounded-lg hover:bg-gray-50">
                            <iconify-icon icon="mdi:bell-outline" class="text-lg"></iconify-icon>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"
                                style="background-color: #ef4444;"></span>
                        </button>
                    </div>
                </div>
            </header>

            <div class="flex flex-1 gap-6 p-6 overflow-y-auto" style="flex-wrap: wrap; align-content: flex-start;">

                <main class="flex-1 p-6 bg-white shadow-sm" style="border-radius: 32px; min-width: 60%;">

                    <!-- BANNER -->
                    <div class="relative flex items-center mb-8 overflow-hidden shadow-sm"
                        style="border-radius: 16px; height: 220px; background-image:url('{{ asset('images/image.png') }}'); background-size:cover; background-position:center;">

                        <div class="absolute inset-0"
                            style="background: linear-gradient(to right, rgba(139, 58, 0, 0.9), rgba(139, 58, 0, 0.4));">
                        </div>

                        <div class="relative z-10 flex items-center justify-between w-full gap-6 px-8 text-white">
                            <div>
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 mb-3 text-xs font-bold rounded-full"
                                    style="background-color: #FF7A00;">
                                    <iconify-icon icon="mdi:bullhorn" class="text-sm"></iconify-icon>
                                    Diskon hingga 70% Hari Ini!
                                </span>
                                <h2 class="max-w-xl mb-2 text-3xl font-bold leading-tight">
                                    Makanan enak, harga hemat, food waste berkurang!
                                </h2>
                                <p class="max-w-md text-sm text-white/80">
                                    Pesan sekarang untuk membantu bumi sekaligus menghemat budget harianmu.
                                </p>
                            </div>
                            <button
                                class="px-6 py-3 text-sm font-bold text-white transition shadow-md rounded-xl whitespace-nowrap"
                                style="background-color: #FF7A00;">
                                Jelajahi Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- FILTERS -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <button
                            class="flex items-center justify-center p-2.5 text-gray-500 bg-white border border-gray-200 rounded-full hover:bg-gray-50">
                            <iconify-icon icon="mdi:tune-vertical" class="text-xl"></iconify-icon>
                        </button>
                        <button class="px-8 py-2.5 text-sm font-semibold text-white rounded-full shadow-md"
                            style="background-color: #9D4B00;">
                            Semua
                        </button>
                        <button
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition">
                            <iconify-icon icon="mdi:gift-outline" class="text-lg text-gray-400"></iconify-icon> Gacha
                        </button>
                        <button
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition">
                            <iconify-icon icon="mdi:silverware-fork-knife"
                                class="text-lg text-gray-400"></iconify-icon> Real Food
                        </button>
                        <button
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition">
                            <iconify-icon icon="mdi:near-me" class="text-lg text-gray-400"></iconify-icon> Jarak
                            Terdekat
                        </button>
                    </div>

                    <!-- Memaksa grid dengan inline CSS agar card tidak raksasa meskipun tailwind rusak -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
                        @foreach ($foods as $food)
                            <!-- STANDARD CARD -->
                            <div class="flex flex-col overflow-hidden transition bg-white border border-gray-200 hover:shadow-lg group"
                                style="border-radius: 16px;">

                                <!-- Image & Tags Area -->
                                <div class="relative w-full overflow-hidden bg-gray-100"
                                    style="height: 160px; min-height: 160px;">
                                    @if ($food->foto)
                                        <img src="{{ asset('storage/' . $food->foto) }}"
                                            style="object-fit: cover; width: 100%; height: 100%;">
                                    @else
                                        <!-- Placeholder Image -->
                                        <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=600&auto=format&fit=crop"
                                            style="object-fit: cover; width: 100%; height: 100%;">
                                    @endif

                                    <!-- Jenis/Category Tag -->
                                    <div class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-md"
                                        style="background-color: rgba(204, 251, 241, 0.9); color: #115e59; backdrop-filter: blur(4px);">
                                        {{ $food->jenis }}
                                    </div>

                                    <!-- Heart Icon -->
                                    <button
                                        class="absolute flex items-center justify-center w-8 h-8 rounded-full shadow-sm top-3 right-3"
                                        style="background-color: rgba(255,255,255,0.9); color: #9ca3af;">
                                        <iconify-icon icon="mdi:heart-outline" class="text-lg"></iconify-icon>
                                    </button>
                                </div>

                                <!-- Card Content -->
                                <div class="flex flex-col flex-1 p-4">
                                    <!-- Title & Distance -->
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1">
                                            <p
                                                class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">
                                                Kategori</p>
                                            <h3 class="text-base font-bold text-gray-800"
                                                style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;"
                                                title="{{ $food->nama }}">{{ $food->nama }}</h3>
                                        </div>
                                        <div class="flex flex-col items-end text-[11px] font-medium text-gray-400">
                                            <iconify-icon icon="mdi:near-me" class="text-sm"
                                                style="color: #14b8a6;"></iconify-icon>
                                            1.2 km
                                        </div>
                                    </div>

                                    <!-- Rating -->
                                    <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                        <iconify-icon icon="mdi:star" class="text-[#9D4B00] text-sm"
                                            style="color: #9D4B00;"></iconify-icon>
                                        <span class="font-bold text-gray-700">4.8</span>
                                        <span>(120+)</span>
                                    </div>

                                    <!-- Price Area -->
                                    <div class="flex items-end gap-2 mt-4 mb-5">
                                        <p class="text-lg font-bold" style="color: #9D4B00;">Rp
                                            {{ number_format($food->harga, 0, ',', '.') }}</p>
                                        <!-- Simulasi Harga Coret (Misal harga asli 2x lipat) -->
                                        <p class="text-[11px] text-gray-400 mb-1"
                                            style="text-decoration: line-through;">Rp
                                            {{ number_format($food->harga * 2, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('menu.show', $food) }}"
                                        class="block w-full py-2.5 mt-auto text-sm font-bold text-center transition rounded-xl"
                                        style="color: #9D4B00; border: 2px solid #9D4B00;">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </main>

                <aside class="flex-shrink-0 space-y-6" style="width: 320px;">

                    <!-- LOKASI -->
                    <div class="p-6 bg-white shadow-sm" style="border-radius: 24px;">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-gray-800">Lokasi Anda</h3>
                            <button class="text-sm font-semibold hover:text-orange-600"
                                style="color: #f97316;">Ubah</button>
                        </div>

                        <!-- Map Image Placeholder -->
                        <div class="relative w-full mb-4 overflow-hidden bg-gray-100"
                            style="height: 120px; border-radius: 12px;">
                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=400&auto=format&fit=crop"
                                alt="Map" class="object-cover w-full h-full opacity-60"
                                style="object-fit: cover; width: 100%; height: 100%;">
                            <!-- Pin -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="flex items-center justify-center w-8 h-8 text-white border-2 border-white rounded-full shadow-lg"
                                    style="background-color: #9D4B00;">
                                    <iconify-icon icon="mdi:map-marker" class="text-lg"></iconify-icon>
                                </div>
                            </div>
                        </div>

                        <!-- Address Info -->
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <iconify-icon icon="mdi:home-outline" class="text-lg text-gray-400 mt-0.5"></iconify-icon>
                            <p class="leading-relaxed">Jl. Sudirman No. 123, SCBD, Jakarta Selatan, 12190</p>
                        </div>
                    </div>

                    <!-- AJAK TEMAN BANNER -->
                    <div class="p-6 text-white shadow-md" style="background-color: #9D4B00; border-radius: 24px;">
                        <div class="flex items-center justify-center w-10 h-10 mb-4 rounded-xl"
                            style="background-color: rgba(255,255,255,0.2);">
                            <iconify-icon icon="mdi:account-multiple-plus" class="text-2xl"></iconify-icon>
                        </div>
                        <h3 class="mb-2 text-lg font-bold">Ajak teman, dapat voucher!</h3>
                        <p class="mb-6 text-xs leading-relaxed" style="color: rgba(255,255,255,0.8);">
                            Dapatkan saldo TimeFood Rp 20.000 untuk setiap teman yang mendaftar.
                        </p>
                        <button
                            class="px-5 py-2.5 text-sm font-bold bg-white rounded-full transition flex items-center gap-2"
                            style="color: #9D4B00;">
                            Undang Teman <iconify-icon icon="mdi:arrow-right"></iconify-icon>
                        </button>
                    </div>

                    <!-- PESANAN TERAKHIR -->
                    <div class="p-6 bg-white shadow-sm" style="border-radius: 24px;">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-sm font-bold text-gray-800">Pesanan Terakhir</h3>
                            <button class="text-xs font-semibold text-gray-400 hover:text-gray-600">Lihat
                                Semua</button>
                        </div>

                        <div class="space-y-4">
                            <!-- Item 1 -->
                            <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?q=80&w=150&auto=format&fit=crop"
                                        alt="Sushi" class="object-cover w-12 h-12 rounded-lg"
                                        style="object-fit: cover;">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Sushi Tei Pack</p>
                                        <p class="text-[10px] text-gray-400 mb-0.5">Kemarin, 18:45</p>
                                        <p class="text-xs font-bold" style="color: #9D4B00;">Rp 45.000</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-md"
                                    style="color: #0f766e; background-color: #f0fdfa;">Selesai</span>
                            </div>

                            <!-- Item 2 -->
                            <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=150&auto=format&fit=crop"
                                        alt="Pastry" class="object-cover w-12 h-12 rounded-lg"
                                        style="object-fit: cover;">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Morning Pastry Set</p>
                                        <p class="text-[10px] text-gray-400 mb-0.5">24 Okt, 08:30</p>
                                        <p class="text-xs font-bold" style="color: #9D4B00;">Rp 22.500</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-md"
                                    style="color: #0f766e; background-color: #f0fdfa;">Selesai</span>
                            </div>
                        </div>
                    </div>

                </aside>

            </div>
        </div>
    </div>
</x-app-layout>
