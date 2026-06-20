@extends('layouts.restaurant')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola semua pesanan yang masuk</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Filter Tabs --}}
    <div class="flex gap-2 flex-wrap">
        @foreach([
            'semua'     => ['label' => 'Semua',       'count' => $orders->count()],
            'pending'   => ['label' => 'Menunggu',    'count' => $orders->where('status','pending')->count()],
            'paid'      => ['label' => 'Diproses',    'count' => $orders->where('status','paid')->count()],
            'ready'     => ['label' => 'Siap Diambil','count' => $orders->where('status','ready')->count()],
            'completed' => ['label' => 'Selesai',     'count' => $orders->where('status','completed')->count()],
        ] as $val => $info)
            <button onclick="filterStatus('{{ $val }}')"
                class="filter-btn px-4 py-1.5 rounded-full text-xs font-semibold border transition-all duration-150"
                data-status="{{ $val }}">
                {{ $info['label'] }}
                <span class="ml-1 bg-white bg-opacity-30 px-1.5 py-0.5 rounded-full">{{ $info['count'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">ID Pesanan</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Pelanggan</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Makanan</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Total</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-500 text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="orderTable">
                @forelse($orders as $order)
                @php
                    $statusColor = match($order->status) {
                        'pending'   => 'bg-yellow-100 text-yellow-700',
                        'paid'      => 'bg-blue-100 text-blue-700',
                        'ready'     => 'bg-purple-100 text-purple-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default     => 'bg-gray-100 text-gray-600',
                    };
                    $statusLabel = match($order->status) {
                        'pending'   => 'Menunggu',
                        'paid'      => 'Diproses',
                        'ready'     => 'Siap Diambil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default     => $order->status,
                    };
                @endphp
                <tr class="hover:bg-orange-50/30 transition-colors order-row" data-status="{{ $order->status }}">
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs text-gray-500">#TFB{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 text-xs font-bold">
                                {{ substr($order->user->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-gray-700 font-medium">{{ $order->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $order->food->nama ?? '-' }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('orders.show', $order->id) }}"
                            class="inline-flex items-center gap-1 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i> Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <i class="fa-solid fa-clipboard-list text-4xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 font-medium">Belum ada pesanan masuk</p>
                        <p class="text-gray-300 text-xs mt-1">Pesanan dari pelanggan akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterStatus(status) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-orange-500', 'text-white', 'border-orange-500');
        btn.classList.add('border-gray-200', 'text-gray-600', 'bg-white');
    });
    const activeBtn = document.querySelector(`.filter-btn[data-status="${status}"]`);
    activeBtn.classList.remove('border-gray-200', 'text-gray-600', 'bg-white');
    activeBtn.classList.add('bg-orange-500', 'text-white', 'border-orange-500');

    document.querySelectorAll('.order-row').forEach(row => {
        row.style.display = (status === 'semua' || row.dataset.status === status) ? '' : 'none';
    });
}
document.addEventListener('DOMContentLoaded', () => filterStatus('semua'));
</script>
@endsection
