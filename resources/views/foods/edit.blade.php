@extends('layouts.restaurant')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Makanan</h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi listing makanan kamu</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('foods.update', $food->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Makanan</label>
                <input type="text" name="nama" value="{{ old('nama', $food->nama) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('deskripsi', $food->deskripsi) }}</textarea>
            </div>

            {{-- Harga & Stok --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $food->harga) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $food->stok) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                </div>
            </div>

            {{-- Jenis & Status --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                    <select name="jenis" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="real_food" {{ $food->jenis === 'real_food' ? 'selected' : '' }}>Real Food</option>
                        <option value="gacha" {{ $food->jenis === 'gacha' ? 'selected' : '' }}>Gacha</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="aktif" {{ $food->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="habis" {{ $food->status === 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pickup</label>
                <input type="text" name="alamat" value="{{ old('alamat', $food->alamat) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
            </div>

            {{-- Jam Pickup --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Pickup</label>
                <input type="time" name="pickup_time" value="{{ old('pickup_time', $food->pickup_time) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
            </div>

            {{-- Foto --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto (kosongkan jika tidak ingin mengubah)</label>
                @if($food->foto)
                    <img src="{{ Storage::url($food->foto) }}" alt="foto" class="h-24 rounded-lg mb-2 object-cover">
                @endif
                <input type="file" name="foto" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('foods.index') }}"
                    class="flex-1 text-center border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
