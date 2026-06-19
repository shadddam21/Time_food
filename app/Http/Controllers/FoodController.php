<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::orderBy('created_at', 'desc')->get();

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
}