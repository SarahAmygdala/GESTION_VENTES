<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/db-seed', function () {
    try {
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return "Base de données réinitialisée et seedée avec succès !";
    } catch (\Exception $e) {
        return "Erreur lors du seeding : " . $e->getMessage();
    }
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Shared routes (Admin & Caissier)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // POS module
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/store', [PosController::class, 'store'])->name('pos.store');

    // Clients & Sales History (Shared)
    Route::resource('clients', ClientController::class);
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales/{sale}/pdf', [SaleController::class, 'downloadPdf'])->name('sales.pdf');
    Route::get('/sales/export/excel', [SaleController::class, 'exportExcel'])->name('sales.export');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index'); // Placeholder
        Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
        // Stock Management & History (Archive)
        Route::get('/stock', [\App\Http\Controllers\StockController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [\App\Http\Controllers\StockController::class, 'create'])->name('stock.create');
        Route::post('/stock', [\App\Http\Controllers\StockController::class, 'store'])->name('stock.store');
    });
});

require __DIR__ . '/auth.php';
