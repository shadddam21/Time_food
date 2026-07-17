@extends('layouts.restaurant')
@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Kelola Makanan</h1>
            <p class="text-slate-400 text-xs mt-0.5">{{ $foods->count() }} produk terdaftar</p>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('foods.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..."
                    class="pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400">
                <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            </form>
            <a href="{{ route('foods.create') }}"
                class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Makanan
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Produk</th>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Harga</th>
                    <th class="text-center px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Stok</th>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Jenis</th>
                    <th class="text-left px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-center px-6 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($foods as $food)
                <tr class="hover:bg-orange-50/20 transition-colors">
                    {{-- Produk --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($food->foto)
                                <img src="{{ asset('storage/' . $food->foto) }}" alt="{{ $food->nama }}"
                                    class="w-11 h-11 rounded-lg object-cover flex-shrink-0">
                            @else
                                <div class="w-11 h-11 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-bowl-food text-orange-400"></i>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 truncate">{{ $food->nama }}</p>
                                <p class="text-slate-400 text-xs mt-0.5 truncate">{{ Str::limit($food->deskripsi, 40) }}</p>
                                @if($food->pickup_time_start && $food->pickup_time_end)
                                    <p class="text-orange-500 text-xs font-medium mt-1">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ date('H:i', strtotime($food->pickup_time_start)) }} - {{ date('H:i', strtotime($food->pickup_time_end)) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    {{-- Harga --}}
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">Rp{{ number_format($food->harga, 0, ',', '.') }}</p>
                        @if(isset($food->harga_asli) && $food->harga_asli > $food->harga)
                            <p class="text-slate-400 text-xs line-through">Rp{{ number_format($food->harga_asli, 0, ',', '.') }}</p>
                        @endif
                    </td>
                    {{-- Stok --}}
                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold {{ $food->stok <= 3 ? 'text-red-500' : 'text-slate-700' }}">
                            {{ $food->stok }}
                        </span>
                    </td>
                    {{-- Jenis --}}
                    <td class="px-6 py-4">
                        @if(strtolower($food->jenis) === 'gacha')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                <i class="fa-solid fa-dice mr-1"></i>Gacha
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                <i class="fa-solid fa-bowl-food mr-1"></i>Real Food
                            </span>
                        @endif

                    </td>
                    {{-- Status --}}
                    <td class="px-6 py-4">
                        <form action="{{ route('foods.toggleStatus', $food->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-semibold focus:outline-none transition-colors
                                {{ $food->status === 'aktif' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                {{ $food->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('foods.show', $food->id) }}"
                                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors"
                                title="Lihat Ulasan">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <a href="{{ route('foods.edit', $food->id) }}"
                                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-orange-100 flex items-center justify-center text-slate-500 hover:text-orange-600 transition-colors"
                                title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('foods.destroy', $food->id) }}" method="POST"
                                id="delete-form-{{ $food->id }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $food->id }}')"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors"
                                    title="Hapus">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-bowl-food text-slate-300 text-2xl"></i>
                        </div>
                        <p class="text-slate-500 font-medium">Belum ada menu</p>
                        <p class="text-slate-400 text-xs mt-1 mb-4">Tambahkan makanan pertama kamu</p>
                        <a href="{{ route('foods.create') }}"
                            class="inline-flex items-center gap-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                            <i class="fa-solid fa-plus"></i> Tambah Sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus makanan ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // red-500
            cancelButtonColor: '#64748b', // slate-500
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            customClass: {
                title: 'text-slate-800 font-bold',
                htmlContainer: 'text-slate-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
