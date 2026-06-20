@if(auth()->user()->role === 'restaurant')
    @extends('layouts.restaurant')

    @section('content')
    <div class="space-y-6">

        {{-- Greeting --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 text-sm mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-xl font-bold text-gray-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Dari pesanan selesai
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs text-gray-500 mb-1">Total Pesanan</p>
                <p class="text-xl font-bold text-gray-800">{{ $totalOrders }}</p>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Semua waktu
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs text-gray-500 mb-1">Menu Aktif</p>
                <p class="text-xl font-bold text-gray-800">{{ $totalFoods }}</p>
                <p class="text-xs text-orange-500 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-utensils"></i> Sedang aktif
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-xs text-gray-500 mb-1">Makanan Terselamatkan</p>
                <p class="text-xl font-bold text-gray-800">{{ $totalOrders * 1 }} porsi</p>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-leaf"></i> Food waste reduced
                </p>
            </div>
        </div>

        {{-- Chart + Recent Orders --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Grafik Penjualan --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Grafik Penjualan</h3>
                    <span class="text-xs text-gray-400">7 Hari Terakhir</span>
                </div>
                <canvas id="salesChart" height="120"></canvas>
            </div>

            {{-- Penjualan Terbaru --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Penjualan Terbaru</h3>
                    <a href="{{ route('orders.index') }}" class="text-orange-500 text-xs hover:underline">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $order->food->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $order->user->name ?? '-' }} · {{ $order->created_at->format('d M') }}</p>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            @php
                                $badge = match($order->status) {
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'ready'     => 'bg-purple-100 text-purple-700',
                                    'paid'      => 'bg-blue-100 text-blue-700',
                                    default     => 'bg-yellow-100 text-yellow-700',
                                };
                                $label = match($order->status) {
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Batal',
                                    'ready'     => 'Siap',
                                    'paid'      => 'Dibayar',
                                    default     => 'Pending',
                                };
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badge }}">{{ $label }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6 text-gray-400 text-sm">
                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                        Belum ada pesanan
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#F97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#F97316',
                    pointRadius: 4,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => 'Rp' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            callback: (v) => 'Rp' + (v/1000) + 'k',
                            font: { size: 10 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    });
    </script>
    @endsection

@else
    {{-- BAGIAN CUSTOMER — JANGAN DIUBAH --}}
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Makanan Tersedia</h3>

                    <div class="mt-4">
                        @forelse($foods as $food)
                            <div class="border-b py-2">
                                {{ $food->nama }} — Rp{{ number_format($food->harga) }}
                            </div>
                        @empty
                            <p>Belum ada makanan tersedia saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif