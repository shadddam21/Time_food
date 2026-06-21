<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = \DB::table('favorites')->where('user_id', auth()->id())->pluck('food_id')->toArray();
        $foods = \App\Models\Food::whereIn('id', $favorites)->get();
        return view('favorites.index', compact('foods', 'favorites'));
    }

    public function toggle(Food $food)
    {
        $user = Auth::user();
        
        $exists = \DB::table('favorites')
            ->where('user_id', $user->id)
            ->where('food_id', $food->id)
            ->exists();

        if ($exists) {
            \DB::table('favorites')
                ->where('user_id', $user->id)
                ->where('food_id', $food->id)
                ->delete();
            return response()->json(['status' => 'removed']);
        } else {
            \DB::table('favorites')->insert([
                'user_id' => $user->id,
                'food_id' => $food->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
