<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('foods.index') }}" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-500 hover:text-orange-500 shadow-sm transition-colors border border-gray-100">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Makanan</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Makanan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 mb-6">
                    <div class="w-full aspect-square rounded-2xl overflow-hidden bg-gray-100 mb-6">
                        @if($food->foto)
                            <img src="{{ $food->foto_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fa-solid fa-image text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $food->nama }}</h2>
                    <p class="text-gray-500 text-sm mb-6">{{ $food->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-gray-500 text-sm">Harga Jual</span>
                            <span class="font-bold text-orange-500">Rp{{ number_format($food->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-gray-500 text-sm">Sisa Stok</span>
                            <span class="font-bold text-gray-900">{{ $food->stok }} Porsi</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                            <span class="text-gray-500 text-sm">Rating</span>
                            <div class="flex items-center gap-1">
                                <i class="fa-solid fa-star text-yellow-400"></i>
                                <span class="font-bold text-gray-900">{{ number_format($food->averageRating(), 1) ?: '0.0' }}</span>
                                <span class="text-gray-400 text-xs">({{ $food->reviews->count() }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ulasan -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-gray-900">Ulasan Customer</h3>
                        <div class="bg-orange-50 text-orange-500 px-4 py-2 rounded-xl text-sm font-bold">
                            {{ $food->reviews->count() }} Ulasan
                        </div>
                    </div>

                    @if($food->reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($food->reviews as $review)
                                <div class="border-b border-gray-50 last:border-0 pb-6 last:pb-0">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center font-bold">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-sm bg-gray-50 p-4 rounded-xl">
                                        {{ $review->ulasan ?: 'Tidak ada teks ulasan.' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-regular fa-comment text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada ulasan</p>
                            <p class="text-gray-400 text-sm mt-1">Ulasan akan muncul di sini setelah customer menyelesaikan pesanan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
