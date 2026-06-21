<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Back Button -->
        <a href="{{ route('menu.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-orange-500 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Menu
        </a>

        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-10">
            
            <!-- Left: Images -->
            <div class="w-full md:w-1/2 space-y-4">
                <div class="relative w-full aspect-square rounded-3xl overflow-hidden bg-gray-100">
                    @if($food->foto)
                        <img src="{{ $food->foto_url }}" alt="{{ $food->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fa-solid fa-image text-6xl"></i>
                        </div>
                    @endif
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
                                btn.classList.remove('text-gray-400');
                            } else {
                                btn.classList.remove('text-red-500');
                                btn.classList.add('text-gray-400');
                            }
                        }).catch(err => console.error(err));
                    " class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center {{ in_array($food->id, $favorites) ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 shadow-sm transition-colors z-20">
                        <i class="fa-solid fa-heart pointer-events-none"></i>
                    </button>
                    <!-- Nav arrows -->
                    <button class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-700 shadow-sm hover:bg-white">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-700 shadow-sm hover:bg-white">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="aspect-square rounded-xl overflow-hidden border-2 border-orange-500 opacity-100">
                         @if($food->foto)
                            <img src="{{ $food->foto_url }}" class="w-full h-full object-cover">
                         @endif
                    </div>
                    <div class="aspect-square rounded-xl overflow-hidden border-2 border-transparent opacity-60 hover:opacity-100 transition-opacity bg-gray-100"></div>
                    <div class="aspect-square rounded-xl overflow-hidden border-2 border-transparent opacity-60 hover:opacity-100 transition-opacity bg-gray-100"></div>
                    <div class="aspect-square rounded-xl overflow-hidden border-2 border-transparent opacity-60 hover:opacity-100 transition-opacity bg-gray-100"></div>
                </div>
            </div>

            <!-- Right: Details -->
            <div class="w-full md:w-1/2 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex gap-2 mb-3">
                            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-lg">
                                {{ strtoupper(str_replace('_', ' ', $food->jenis)) }}
                            </span>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-lg">
                                Sisa {{ $food->stok }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $food->nama }}</h1>
                        <div class="flex items-center text-sm text-gray-500 gap-4 mb-6">
                            <span class="flex items-center text-gray-700 font-medium"><i class="fa-solid fa-store text-orange-500 mr-2"></i> Restoran Anda</span>
                            <span class="flex items-center"><i class="fa-solid fa-star text-yellow-400 mr-1.5"></i> 4.8 (100)</span>
                            <span class="flex items-center"><i class="fa-solid fa-location-dot text-gray-400 mr-1.5"></i> 1.2 km</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-black text-orange-500">Rp{{ number_format($food->harga, 0, ',', '.') }}</span>
                    @if(isset($food->harga_asli) && $food->harga_asli > $food->harga)
                        <span class="text-lg text-gray-400 line-through">Rp{{ number_format($food->harga_asli, 0, ',', '.') }}</span>
                        @php
                            $discount = round((($food->harga_asli - $food->harga) / $food->harga_asli) * 100);
                        @endphp
                        <span class="bg-red-50 text-red-600 text-xs font-bold px-2 py-1 rounded-md ml-2">-{{ $discount }}%</span>
                    @endif
                </div>

                <p class="text-gray-600 mb-8 leading-relaxed text-sm">
                    {{ $food->deskripsi ?: 'Tidak ada deskripsi yang tersedia untuk makanan ini.' }}
                </p>

                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi</h3>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 flex items-center"><i class="fa-regular fa-clock w-5 text-gray-400"></i> Ambil di tempat</span>
                        <span class="font-medium text-gray-800">
                            {{ $food->pickup_time_start ? date('H:i', strtotime($food->pickup_time_start)) : '00:00' }} - 
                            {{ $food->pickup_time_end ? date('H:i', strtotime($food->pickup_time_end)) : '23:59' }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 flex items-center"><i class="fa-solid fa-tag w-5 text-gray-400"></i> Kategori</span>
                        <span class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $food->jenis) }}</span>
                    </li>
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 flex items-center"><i class="fa-solid fa-box w-5 text-gray-400"></i> Stok Tersedia</span>
                        <span class="font-medium text-gray-800">{{ $food->stok }} Porsi</span>
                    </li>
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 flex items-center"><i class="fa-solid fa-map-location-dot w-5 text-gray-400"></i> Alamat Pengambilan</span>
                        <span class="font-medium text-gray-800 text-right w-1/2 truncate" title="{{ $food->alamat }}">{{ $food->alamat }}</span>
                    </li>
                </ul>

                <form action="{{ route('orders.store', $food->id) }}" method="POST" class="mt-auto">
                    @csrf
                    <div class="flex gap-4">
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 p-1 w-32">
                            <button type="button" onclick="document.getElementById('qty').stepDown()" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-orange-500 bg-white rounded-lg shadow-sm font-bold">-</button>
                            <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $food->stok }}" class="w-full text-center bg-transparent border-none focus:ring-0 font-bold text-gray-800" readonly>
                            <button type="button" onclick="document.getElementById('qty').stepUp()" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-orange-500 bg-white rounded-lg shadow-sm font-bold">+</button>
                        </div>
                        <button type="submit" name="action" value="cart" class="flex-1 border-2 border-orange-500 text-orange-500 hover:bg-orange-50 font-bold py-3.5 px-4 rounded-xl transition-colors">
                            Tambah Keranjang
                        </button>
                        <button type="submit" name="action" value="checkout" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-orange-500/30 transition-colors">
                            Beli Sekarang
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</x-app-layout>
