<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating'   => 'required|integer|min:1|max:5',
            'ulasan'   => 'nullable|string|max:500',
        ]);

        // 2. Ambil data order berdasarkan ID yang dikirim
        $order = Order::findOrFail($request->order_id);

        // 3. Pastikan order ini milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bukan pesananmu!');
        }

        // 4. Pastikan order sudah completed (sudah diambil)
        if ($order->status !== 'completed') {
            return back()->with('error', 'Review hanya bisa diberikan setelah pesanan selesai.');
        }

        // 5. Pastikan order ini belum pernah direview
        if (Review::where('order_id', $order->id)->exists()) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk pesanan ini.');
        }

        // 6. Semua valid → simpan review ke database
        Review::create([
            'user_id'  => auth()->id(),
            'food_id'  => $order->food_id,
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'ulasan'   => $request->ulasan,
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim! Terima kasih 🙏');
    }
}
