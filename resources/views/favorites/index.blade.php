<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-heart text-red-500"></i> Favorit Saya
            </h1>
            <p class="text-slate-500 mt-2">Daftar makanan yang kamu simpan.</p>
        </div>

        @if($foods->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center">
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-regular fa-heart text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada makanan favorit</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">Mulai jelajahi menu dan klik tombol hati (Love) untuk menyimpan makanan incaranmu di sini.</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    Jelajahi Menu
                </a>
            </div>
        @else
            <!-- Grid Makanan Favorit -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($foods as $food)
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative">
                        <a href="{{ route('menu.show', $food->id) }}" class="group block">
                            <!-- Image Container -->
                            <div class="relative h-48 overflow-hidden bg-slate-100">
                                @if($food->foto)
                                    @if(filter_var($food->foto, FILTER_VALIDATE_URL))
                                        <img src="{{ $food->foto }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $food->nama }}">
                                    @else
                                        <img src="{{ asset('storage/' . $food->foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $food->nama }}">
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i class="fa-solid fa-image text-4xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Tags on Image -->
                                <div class="absolute top-4 left-4 flex flex-col gap-2">
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm {{ $food->jenis === 'gacha' ? 'bg-purple-500 text-white' : 'bg-green-500 text-white' }}">
                                        {{ $food->jenis === 'gacha' ? 'Gacha Box' : 'Real Food' }}
                                    </span>
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
                            
                            <!-- Content -->
                            <div class="p-5 relative">
                                <h3 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-orange-500 transition-colors line-clamp-1">{{ $food->nama }}</h3>
                                <p class="text-slate-500 text-xs mb-4 line-clamp-2">{{ $food->deskripsi }}</p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <div>
                                        <p class="text-[10px] text-slate-400 line-through">Rp {{ number_format($food->harga_asli, 0, ',', '.') }}</p>
                                        <p class="text-orange-500 font-black text-lg">Rp {{ number_format($food->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-bold text-slate-400 block mb-1">STOK TERBATAS</span>
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-50 text-orange-600 font-bold text-sm">
                                            {{ $food->stok }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        
    </div>
</x-app-layout>
