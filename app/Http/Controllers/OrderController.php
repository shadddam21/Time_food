<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Pesanan Masuk — list semua order untuk food milik restoran ini.
     * Route: GET /orders  → name: orders.index
     */
    public function index()
    {
        $foodIds = Food::where('user_id', Auth::id())->pluck('id');

        $orders = Order::with(['food', 'user'])
            ->whereIn('food_id', $foodIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail satu pesanan (sisi restoran).
     * Route: GET /orders/{order}  → name: orders.show
     */
    public function show(Order $order)
    {
        // Pastikan order ini milik food dari restoran yang login
        $isOwner = Food::where('id', $order->food_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (! $isOwner) {
            abort(403);
        }

        $order->load(['food', 'user']);

        return view('orders.show', compact('order'));
    }

    /**
     * Update status pesanan oleh restoran.
     * Route: PATCH /orders/{order}/status  → name: orders.updateStatus
     */
    public function updateStatus(Request $request, Order $order)
    {
        $isOwner = Food::where('id', $order->food_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (! $isOwner) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,paid,ready,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui');
    }

    /**
     * Riwayat Transaksi — semua order yang sudah completed/cancelled.
     * Route: GET /transaksi  → name: transaksi.index
     */
    public function transaksi()
    {
        $foodIds = Food::where('user_id', Auth::id())->pluck('id');

        $orders = Order::with(['food', 'user'])
            ->whereIn('food_id', $foodIds)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalRevenue = $orders->where('status', 'completed')->sum('total');
        $totalOrders  = $orders->count();

        return view('orders.transaksi', compact('orders', 'totalRevenue', 'totalOrders'));
    }

    /**
     * Store — dipakai customer untuk checkout (sisi customer, bukan resto).
     * Route: POST /foods/{food}/order  → name: orders.store
     */
    public function store(Request $request, Food $food)
    {
        // Placeholder — akan dikerjakan oleh partner (customer side)
        abort(501, 'Belum diimplementasi');
    }
}
