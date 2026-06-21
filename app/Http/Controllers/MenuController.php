<?php

namespace App\Http\Controllers;

use App\Models\Food;

class MenuController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Food::query();
        
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%');
        }
        
        $foods = $query->get();
        $favorites = auth()->check() ? \DB::table('favorites')->where('user_id', auth()->id())->pluck('food_id')->toArray() : [];

        return view('menu.index', compact('foods', 'favorites'));
    }

    public function show(Food $food)
    {
        $favorites = auth()->check() ? \DB::table('favorites')->where('user_id', auth()->id())->pluck('food_id')->toArray() : [];
        return view('menu.show', compact('food', 'favorites'));
    }
}