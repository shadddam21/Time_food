<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::where('user_id', Auth::id());

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $foods = $query->orderBy('created_at', 'desc')->get();

        return view('foods.index', compact('foods'));
    }

    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            abort(403);
        }

        return view('foods.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'harga_asli' => 'nullable|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'jenis' => 'required|in:gacha,real food,real_food',
            'alamat' => 'nullable|string',
            'pickup_time_start' => 'required|date_format:H:i',
            'pickup_time_end' => 'required|date_format:H:i|after:pickup_time_start',
            'foto' => 'nullable|image|max:2048'
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('foods', 'public');
        }

        Food::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'jenis' => str_replace(' ', '_', $request->jenis), // normalize: 'real food' → 'real_food'
            'alamat' => $request->alamat ?? '',
            'pickup_time_start' => $request->pickup_time_start,
            'pickup_time_end' => $request->pickup_time_end,
            'foto' => $foto,
            'status' => 'aktif'
        ]);

        return redirect()
            ->route('foods.index')
            ->with('success', 'Makanan berhasil ditambahkan');
    }

    public function edit(Food $food)
    {
        // Pastikan yang edit adalah pemilik food
        if ($food->user_id !== Auth::id()) {
            abort(403);
        }

        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        if ($food->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'harga_asli'  => 'nullable|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'jenis'       => 'required|in:gacha,real food,real_food',
            'alamat'      => 'nullable|string',
            'pickup_time_start' => 'required|date_format:H:i',
            'pickup_time_end' => 'required|date_format:H:i|after:pickup_time_start',
            'status'      => 'nullable|in:aktif,habis,nonaktif',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $foto = $food->foto; // default: foto lama

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foods', 'public');
        }

        $food->update([
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'jenis'       => str_replace(' ', '_', $request->jenis), // normalize
            'alamat'      => $request->alamat ?? '',
            'pickup_time_start' => $request->pickup_time_start,
            'pickup_time_end' => $request->pickup_time_end,
            'status'      => $request->status ?? 'aktif',
            'foto'        => $foto,
        ]);

        return redirect()
            ->route('foods.index')
            ->with('success', 'Makanan berhasil diperbarui');
    }

    public function destroy(Food $food)
    {
        if ($food->user_id !== Auth::id()) {
            abort(403);
        }

        $food->delete();

        return redirect()
            ->route('foods.index')
            ->with('success', 'Makanan berhasil dihapus');
    }

    public function toggleStatus(Food $food)
    {
        if ($food->user_id !== Auth::id()) {
            abort(403);
        }

        $food->status = $food->status === 'aktif' ? 'nonaktif' : 'aktif';
        $food->save();

        return redirect()
            ->route('foods.index')
            ->with('success', 'Status makanan berhasil diubah');
    }
    }
}