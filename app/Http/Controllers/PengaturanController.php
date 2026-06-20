<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pengaturan.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()
            ->route('pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan');
    }
}
