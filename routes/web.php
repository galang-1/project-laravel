<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('budgets', BudgetController::class)->only(['index', 'store', 'destroy']);

    Route::resource('goals', GoalController::class)->only(['index', 'store', 'destroy']);
    Route::post('/goals/{goal}/saving', [GoalController::class, 'addSaving'])->name('goals.addSaving');

    Route::resource('wishlists', WishlistController::class)->only(['index', 'store', 'destroy']);
    Route::post('/wishlists/{wishlist}/toggle', [WishlistController::class, 'toggleBought'])->name('wishlists.toggle');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('wishlists', WishlistController::class)->only(['index', 'store', 'destroy']);
    Route::post('/wishlists/{wishlist}/toggle', [WishlistController::class, 'toggleBought'])->name('wishlists.toggle');
});

require __DIR__.'/auth.php';