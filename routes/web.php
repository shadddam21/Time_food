<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MenuController;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'restaurant') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('menu.index');
    }
    return view('welcome');
})->name('home');

// Login Restoran (custom page, redirect ke login biasa)
Route::get('/restoran/login', function () {
    if (auth()->check()) {
        return redirect('/');
    }
    return view('auth.login-restoran');
})->name('login.restoran');

Route::middleware('guest')->group(function () {
    Route::get('/restoran/register', [\App\Http\Controllers\Auth\RestaurantAuthController::class, 'create'])->name('register.restoran');
    Route::post('/restoran/register', [\App\Http\Controllers\Auth\RestaurantAuthController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {

    // Customer Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/menu/{food}', [MenuController::class, 'show'])->name('menu.show');
        Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{food}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::post('/foods/{food}/order', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('orders.checkout');
        Route::post('/checkout/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my-orders.index');
        Route::get('/my-orders/{order}', [OrderController::class, 'myOrderDetail'])->name('my-orders.show');
        Route::post('/review',[\App\Http\Controllers\ReviewController::class,'store'])->name('review.store');
    });

    // Restaurant Routes
    Route::middleware(['role:restaurant'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('foods', FoodController::class);
        Route::match(['get', 'patch'], '/foods/{food}/toggle-status', [FoodController::class, 'toggleStatus'])->name('foods.toggleStatus');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('/transaksi', [OrderController::class, 'transaksi'])->name('transaksi.index');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::patch('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    // Profile Routes (Bisa diakses keduanya)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';