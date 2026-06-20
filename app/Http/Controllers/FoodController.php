<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('foods.index', compact('foods'));
    }

    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'jenis' => 'required',
            'alamat' => 'required',
            'pickup_time' => 'required',
            'foto' => 'nullable|image'
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
            'jenis' => $request->jenis,
            'alamat' => $request->alamat,
            'pickup_time' => $request->pickup_time,
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
            'nama'        => 'required',
            'deskripsi'   => 'nullable',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'jenis'       => 'required|in:gacha,real_food',
            'alamat'      => 'required',
            'pickup_time' => 'required',
            'status'      => 'required|in:aktif,habis',
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
            'jenis'       => $request->jenis,
            'alamat'      => $request->alamat,
            'pickup_time' => $request->pickup_time,
            'status'      => $request->status,
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
}