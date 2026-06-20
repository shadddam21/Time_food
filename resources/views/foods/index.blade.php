@extends('layouts.restaurant')

@section('content')
<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Makanan</h1>
            <p class="text-gray-500 text-sm mt-1">Semua listing makanan milik restoran kamu</p>
        </div>
        <a href="{{ route('foods.create') }}"
            class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Makanan
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Produk</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Harga</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Stok</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Jenis</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($foods as $food)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($food->foto)
                                <img src="{{ Storage::url($food->foto) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                    <i class="fa-solid fa-utensils text-orange-400"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-800">{{ $food->nama }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($food->pickup_time)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">Rp{{ number_format($food->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $food->stok }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $food->jenis === 'gacha' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $food->jenis === 'gacha' ? 'Gacha' : 'Real Food' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $food->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($food->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('foods.edit', $food->id) }}"
                                class="text-orange-500 hover:text-orange-700 font-medium text-xs">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('foods.destroy', $food->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus makanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-utensils text-3xl mb-3 block"></i>
                        Belum ada makanan. <a href="{{ route('foods.create') }}" class="text-orange-500 underline">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
