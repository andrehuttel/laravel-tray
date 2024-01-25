<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SaleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/sellers', function () {
    return Inertia::render('Seller');
})->middleware(['auth', 'verified'])->name('sellers');

Route::get('/sales', function () {
    return Inertia::render('Sale');
})->middleware(['auth', 'verified'])->name('sales');

Route::get('/sellers/{id}', [SellerController::class, 'viewSeller'])->name('sellers.viewSeller');
Route::get('/newSellers', [SellerController::class, 'newSeller'])->name('sellers.newSeller');
Route::get('/editSellers/{id}', [SellerController::class, 'editSeller'])->name('sellers.editSeller');
Route::get('/sales/{id}', [SaleController::class, 'viewSale'])->name('sales.viewSale');
Route::get('/newSales', [SaleController::class, 'newSale'])->name('sales.newSale');
Route::get('/editSales/{id}', [SaleController::class, 'editSale'])->name('sales.editSale');
Route::post('/sellers/send-summary-email/{seller}', [SellerController::class, 'sendSellerSummaryEmail'])->name('sellers.send-summary-email');

Route::get('/sales', function () {
    return Inertia::render('Sale');
})->middleware(['auth', 'verified'])->name('sales');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
