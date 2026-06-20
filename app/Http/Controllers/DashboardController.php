<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'restaurant') {
            $foodIds = Food::where('user_id', $user->id)->pluck('id');

            // Stats
            $totalRevenue = Order::whereIn('food_id', $foodIds)
                ->where('status', 'completed')
                ->sum('total');

            $totalOrders = Order::whereIn('food_id', $foodIds)->count();

            $totalFoods = Food::where('user_id', $user->id)
                ->where('status', 'aktif')
                ->count();

            // Recent orders (5 terbaru)
            $recentOrders = Order::with(['food', 'user'])
                ->whereIn('food_id', $foodIds)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Data chart mingguan (7 hari terakhir)
            $chartLabels = [];
            $chartData   = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $chartLabels[] = $date->format('d M');
                $chartData[] = Order::whereIn('food_id', $foodIds)
                    ->where('status', 'completed')
                    ->whereDate('created_at', $date->toDateString())
                    ->sum('total');
            }

            return view('dashboard', compact(
                'totalRevenue',
                'totalOrders',
                'totalFoods',
                'recentOrders',
                'chartLabels',
                'chartData'
            ));
        }

        // Customer side — jangan diubah
        $foods = Food::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('foods'));
    }
}