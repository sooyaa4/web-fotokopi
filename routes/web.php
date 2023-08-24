<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate'])->name('postlogin');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        'produk' => ProdukController::class,
        'jenis-produk' => JenisProdukController::class,
        'supplier' => SuppliersController::class,
        'produk-masuk' => ProdukMasukController::class,
        'transaksi' => TransaksiController::class

    ]);

});