<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
     * Pesanan Saya — list semua order yang dilakukan oleh customer ini.
     * Route: GET /my-orders  → name: my-orders.index
     */
    public function myOrders()
    {
        $orders = Order::with(['food', 'review'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
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
     * Store — dipakai customer untuk checkout (sisi customer).
     * Route: POST /foods/{food}/order  → name: orders.store
     */
    public function store(Request $request, Food $food)
    {
        // Fitur Checkout Sisi Customer
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        if ($food->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        if ($food->status !== 'aktif') {
            return back()->with('error', 'Makanan sedang tidak tersedia');
        }

        // Potong stok
        $food->stok -= $request->qty;

        // Auto non-aktif kalau stok habis
        if ($food->stok <= 0) {
            $food->status = 'habis';
        }
        $food->save();

        // Generate pickup code
        $pickupCode = 'TF-' . strtoupper(Str::random(6));

        // Create Order
        $order = Order::create([
            'user_id' => Auth::id(), // ID Customer
            'food_id' => $food->id,
            'qty' => $request->qty,
            'total' => $food->harga * $request->qty,
            'pickup_code' => $pickupCode,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.checkout', $order->id);
    }

    public function checkout(Order $order)
    {
        if ($order->user_id !== Auth::id() || $order->status !== 'pending') {
            abort(403);
        }
        $order->load('food');
        return view('orders.checkout', compact('order'));
    }

    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id() || $order->status !== 'pending') {
            abort(403);
        }
        
        $order->update(['status' => 'paid']);
        return redirect()->route('my-orders.show', $order->id)->with('success', 'Pembayaran berhasil! Pesanan sedang diproses.');
    }

    public function myOrderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Simulasi update otomatis (jika baru paid, ubah jadi ready setelah diakses untuk presentasi)
        // Di kenyataan, ini diupdate oleh Restoran.
        if ($order->status === 'paid') {
            $order->update(['status' => 'ready']);
        }

        $order->load('food.user');
        return view('orders.my-order-detail', compact('order'));
    }
}