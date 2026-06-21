<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <div x-data="{
            filter: 'semua',
            sortByDistance: false,
            // Modal state
            modalOpen: false,
            modalTitle: '',
            modalContent: '',
            openModal(title, content) {
                this.modalTitle = title;
                this.modalContent = content;
                this.modalOpen = true;
            }
        }">
            
            <!-- Secondary Navigation (Interactive) -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-8">
                <div class="flex space-x-8 text-sm font-medium text-slate-500 overflow-x-auto">
                    <a href="#" @click.prevent="openModal('Meal Plans', 'Fitur Meal Plans sedang dalam pengembangan. Nantikan segera!')" class="text-orange-500 border-b-2 border-orange-500 pb-4 -mb-[17px] whitespace-nowrap">Meal Plans</a>
                    <a href="#" @click.prevent="openModal('Discover', 'Temukan restoran baru dan makanan menarik di sekitarmu.')" class="hover:text-slate-800 pb-4 whitespace-nowrap">Discover</a>
                    <a href="#" @click.prevent="openModal('Favorites', 'Daftar makanan favoritmu akan muncul di sini.')" class="hover:text-slate-800 pb-4 whitespace-nowrap">Favorites</a>
                    <a href="#" @click.prevent="openModal('Stockists', 'Lihat daftar mitra penyedia TimeFood.')" class="hover:text-slate-800 pb-4 whitespace-nowrap">Stockists</a>
                    <a href="#" @click.prevent="openModal('About Us', 'TimeFood adalah platform penyelamat makanan surplus terbaik.')" class="hover:text-slate-800 pb-4 whitespace-nowrap">About</a>
                    <a href="#" @click.prevent="openModal('Contact', 'Hubungi kami di support@timefood.com')" class="hover:text-slate-800 pb-4 whitespace-nowrap">Contact</a>
                </div>
            </div>

            <!-- Global Modal -->
            <div x-show="modalOpen" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                <div @click.away="modalOpen = false" class="bg-white rounded-[2rem] p-8 max-w-sm w-full shadow-2xl transform transition-all">
                    <div class="w-12 h-12 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-bell text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2" x-text="modalTitle"></h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed" x-text="modalContent"></p>
                    <button @click="modalOpen = false" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition-colors">Mengerti</button>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Content (Hero & Foods) -->
                <div class="flex-1 min-w-0">
                    
                    <!-- Hero Banner -->
                    <div class="relative bg-gradient-to-br from-orange-800 to-orange-900 rounded-3xl overflow-hidden shadow-lg mb-8 min-h-[240px] flex items-center">
                        <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1543339308-43e59d6b73a6?q=80&w=2070&auto=format&fit=crop');"></div>
                        <div class="relative z-10 p-8 sm:p-10 max-w-lg">
                            <div class="inline-block bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 shadow-sm">
                                <i class="fa-solid fa-bullhorn mr-1"></i> Diskon hingga 70% Hari Ini!
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-tight">
                                Makanan enak, harga hemat, food waste berkurang!
                            </h2>
                            <p class="text-orange-100 text-sm mb-6 hidden sm:block">Pesan sekarang untuk membantu bumi sekaligus menghemat budget harianmu.</p>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center gap-3 mb-6 overflow-x-auto pb-4 scrollbar-hide">
                        <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-500 flex-shrink-0">
                            <i class="fa-solid fa-sliders"></i>
                        </button>
                        <button @click="filter = 'semua'" :class="filter === 'semua' ? 'bg-orange-600 text-white border-orange-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="border px-6 py-2 rounded-full font-semibold text-sm flex-shrink-0 transition-colors">
                            Semua
                        </button>
                        <button @click="filter = 'gacha'" :class="filter === 'gacha' ? 'bg-orange-600 text-white border-orange-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="border px-6 py-2 rounded-full font-semibold text-sm flex items-center gap-2 flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-dice" :class="filter === 'gacha' ? 'text-white' : 'text-orange-500'"></i> Gacha
                        </button>
                        <button @click="filter = 'real_food'" :class="filter === 'real_food' ? 'bg-orange-600 text-white border-orange-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="border px-6 py-2 rounded-full font-semibold text-sm flex items-center gap-2 flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-utensils" :class="filter === 'real_food' ? 'text-white' : 'text-orange-500'"></i> Real Food
                        </button>
                        <button @click="sortByDistance = !sortByDistance" :class="sortByDistance ? 'bg-slate-800 text-white border-slate-800 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="border px-6 py-2 rounded-full font-semibold text-sm flex items-center gap-2 flex-shrink-0 transition-colors">
                            <i class="fa-solid fa-location-arrow" :class="sortByDistance ? 'text-white' : 'text-orange-500'"></i> Jarak Terdekat
                        </button>
                    </div>

                    <!-- Food Grid (Alpine Loop not possible with pure Blade, so we use Blade loop with Alpine x-show) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" :class="sortByDistance ? 'flex flex-col' : ''">
                        @forelse($foods as $food)
                            <a href="{{ route('menu.show', $food->id) }}" 
                               x-show="(filter === 'semua' || filter === '{{ $food->jenis }}')"
                               x-transition
                               class="group block bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                               :style="sortByDistance ? `order: ${Math.floor(Math.random() * 10)};` : ''">
                                <div class="relative h-48 overflow-hidden bg-slate-100">
                                    @if($food->foto)
                                        <img src="{{ $food->foto_url }}" alt="{{ $food->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-image text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Tags on Image -->
                                    <div class="absolute top-4 left-4 flex gap-2">
                                        @if(strtolower($food->jenis) === 'gacha')
                                            <span class="bg-teal-100/90 backdrop-blur-sm text-teal-700 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                                gacha
                                            </span>
                                        @else
                                            <span class="bg-emerald-100/90 backdrop-blur-sm text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                                real_food
                                            </span>
                                        @endif
                                        @if(isset($food->harga_asli) && $food->harga_asli > $food->harga)
                                            @php
                                                $discount = round((($food->harga_asli - $food->harga) / $food->harga_asli) * 100);
                                            @endphp
                                            <span class="bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                                                -{{ $discount }}%
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Favorite Button -->
                                    <button @click.prevent.stop="
                                        let btn = $el;
                                        fetch('{{ route('favorites.toggle', $food->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                                'Accept': 'application/json'
                                            }
                                        }).then(res => res.json()).then(data => {
                                            if(data.status === 'added') {
                                                btn.classList.add('text-red-500');
                                                btn.classList.remove('text-slate-400');
                                            } else {
                                                btn.classList.remove('text-red-500');
                                                btn.classList.add('text-slate-400');
                                            }
                                        }).catch(err => console.error(err));
                                    " class="absolute top-4 right-4 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center {{ in_array($food->id, $favorites) ? 'text-red-500' : 'text-slate-400' }} hover:text-red-500 shadow-sm transition-colors z-20">
                                        <i class="fa-solid fa-heart text-xs pointer-events-none"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col h-[140px]">
                                    <h3 class="text-lg font-bold text-slate-800 line-clamp-1 mb-1">{{ $food->nama }}</h3>
                                    <div class="flex items-center text-xs text-slate-500 mb-4 gap-3">
                                        <span class="flex items-center"><i class="fa-solid fa-store text-orange-400 mr-1.5"></i> Resto ABC</span>
                                        <span class="flex items-center"><i class="fa-solid fa-star text-yellow-400 mr-1"></i> 4.8</span>
                                        <span class="flex items-center"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> <span x-text="sortByDistance ? (Math.random() * 2 + 0.1).toFixed(1) + ' km' : '1.2 km'"></span></span>
                                    </div>
                                    <div class="flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-lg font-black text-orange-500 leading-none">Rp{{ number_format($food->harga, 0, ',', '.') }}</p>
                                            @if(isset($food->harga_asli) && $food->harga_asli > $food->harga)
                                                <p class="text-[10px] font-semibold text-slate-400 line-through mt-0.5">Rp{{ number_format($food->harga_asli, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                        <span class="bg-orange-50 text-orange-600 text-xs font-bold px-4 py-2 rounded-xl transition-colors group-hover:bg-orange-500 group-hover:text-white">
                                            Pesan
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-1 sm:col-span-2 text-center py-12 bg-white rounded-3xl border border-slate-100">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-basket-shopping text-2xl text-slate-300"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada makanan tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Sidebar (Location & Promo) -->
                <div class="w-full lg:w-80 space-y-6 flex-shrink-0 hidden lg:block">
                
                <!-- Map Card -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800">Lokasi Anda</h3>
                        <button class="text-orange-500 text-sm font-semibold hover:underline">Ubah</button>
                    </div>
                    <div class="relative w-full h-32 rounded-xl overflow-hidden bg-gray-100 mb-4">
                        <!-- Simulated Map Image -->
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2074&auto=format&fit=crop" class="w-full h-full object-cover opacity-60 grayscale" alt="Map">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                                <i class="fa-solid fa-location-dot text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start text-sm text-gray-600 gap-2">
                        <i class="fa-solid fa-house mt-1 text-gray-400"></i>
                        <p>Jl. Sudirman No. 123, SCBD, Jakarta Selatan, 12190</p>
                    </div>
                </div>

                <!-- Invite Banner -->
                <div class="bg-orange-700 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-orange-600 rounded-full opacity-50 blur-xl"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-user-group text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 leading-tight">Ajak teman, dapat voucher!</h3>
                        <p class="text-orange-100 text-sm mb-6 leading-relaxed">Dapatkan saldo TimeFood Rp 20.000 untuk setiap teman yang mendaftar.</p>
                        <button class="bg-white text-orange-700 w-full py-2.5 rounded-xl font-bold text-sm shadow-sm hover:bg-orange-50 transition-colors flex items-center justify-center gap-2">
                            Undang Teman <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        </div> <!-- End x-data -->

    </div>

</x-app-layout>
