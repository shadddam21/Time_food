<?php

namespace App\Http\Controllers;

use App\Models\Food;

class MenuController extends Controller
{
    public function index()
    {
        $foods = Food::all();

        return view('menu.index', compact('foods'));
    }

    public function show(Food $food)
    {
        return view('menu.show', compact('food'));
    }
}