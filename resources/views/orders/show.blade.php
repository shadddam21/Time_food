@extends('layouts.restaurant')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('orders.index') }}"
            class="w-9 h-9 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Detail Pesanan</h1>
            <p class="text-gray-400 text-sm font-mono">#TFB{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Timeline Status --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-5 text-sm">Status Pesanan</h3>
        @php
            $steps = ['pending' => 'Menunggu', 'paid' => 'Diproses', 'ready' => 'Siap Diambil', 'completed' => 'Selesai'];
            $stepKeys = array_keys($steps);
            $currentIndex = array_search($order->status, $stepKeys);
        @endphp
        <div class="flex items-center">
            @foreach($steps as $key => $label)
                @php $idx = array_search($key, $stepKeys); @endphp
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $idx <= $currentIndex ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                        @if($idx < $currentIndex)
                            <i class="fa-solid fa-check text-xs"></i>
                        @else
                            {{ $idx + 1 }}
                        @endif
                    </div>
                    <span class="text-xs mt-1.5 text-center {{ $idx <= $currentIndex ? 'text-orange-500 font-semibold' : 'text-gray-400' }}">
                        {{ $label }}
                    </span>
                </div>
                @if(!$loop->last)
                    <div class="flex-1 h-0.5 mb-5 {{ $idx < $currentIndex ? 'bg-orange-400' : 'bg-gray-200' }}"></div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Info Pesanan --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4 text-sm">Informasi Pesanan</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-gray-500">Pelanggan</span>
                <span class="font-semibold text-gray-800">{{ $order->user->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-gray-500">Makanan</span>
                <span class="font-semibold text-gray-800">{{ $order->food->nama ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-gray-500">Jumlah</span>
                <span class="font-semibold text-gray-800">{{ $order->qty }}x</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-gray-500">Total Pembayaran</span>
                <span class="font-bold text-orange-500 text-base">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-gray-500">Tanggal</span>
                <span class="text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="py-2">
                <p class="text-gray-500 mb-2">Kode Pickup</p>
                <div class="bg-slate-900 rounded-xl p-4 text-center">
                    <p class="font-mono font-black text-3xl text-orange-500 tracking-widest">{{ $order->pickup_code }}</p>
                    <p class="text-slate-400 text-xs mt-1">Tunjukkan kode ini kepada pelanggan saat pengambilan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Status --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4 text-sm">Update Status</h3>
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-3">
                <select name="status"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 bg-gray-50">
                    <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="paid"      {{ $order->status === 'paid'      ? 'selected' : '' }}>Sudah Dibayar / Diproses</option>
                    <option value="ready"     {{ $order->status === 'ready'     ? 'selected' : '' }}>Siap Diambil</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
