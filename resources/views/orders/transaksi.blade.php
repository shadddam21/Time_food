@extends('layouts.restaurant')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
        <p class="text-gray-500 text-sm mt-1">Semua transaksi yang sudah selesai atau dibatalkan</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
            <p class="text-xl font-bold text-orange-500">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-500 mb-1">Total Transaksi</p>
            <p class="text-xl font-bold text-gray-800">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-500 mb-1">Berhasil</p>
            <p class="text-xl font-bold text-green-600">{{ $orders->where('status','completed')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-500 mb-1">Dibatalkan</p>
            <p class="text-xl font-bold text-red-500">{{ $orders->where('status','cancelled')->count() }}</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2">
        <button onclick="filterTx('semua')" class="tx-btn px-4 py-1.5 rounded-full text-xs font-semibold border transition-all bg-orange-500 text-white border-orange-500" data-filter="semua">Semua</button>
        <button onclick="filterTx('completed')" class="tx-btn px-4 py-1.5 rounded-full text-xs font-semibold border transition-all bg-white text-gray-600 border-gray-200" data-filter="completed">Selesai</button>
        <button onclick="filterTx('cancelled')" class="tx-btn px-4 py-1.5 rounded-full text-xs font-semibold border transition-all bg-white text-gray-600 border-gray-200" data-filter="cancelled">Dibatalkan</button>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Tanggal</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Pelanggan</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Produk</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Total</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-orange-50/30 transition-colors tx-row" data-status="{{ $order->status }}">
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $order->updated_at->format('d M Y · H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 text-xs font-bold">
                                {{ substr($order->user->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-gray-700">{{ $order->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $order->food->nama ?? '-' }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $order->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 font-medium">Belum ada riwayat transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTx(filter) {
    document.querySelectorAll('.tx-btn').forEach(btn => {
        btn.classList.remove('bg-orange-500','text-white','border-orange-500');
        btn.classList.add('bg-white','text-gray-600','border-gray-200');
    });
    document.querySelector(`.tx-btn[data-filter="${filter}"]`).classList.add('bg-orange-500','text-white','border-orange-500');
    document.querySelectorAll('.tx-row').forEach(row => {
        row.style.display = (filter === 'semua' || row.dataset.status === filter) ? '' : 'none';
    });
}
</script>
@endsection
