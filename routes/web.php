<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Rute Web
 *
 * File ini berisi semua rute web untuk aplikasi katalog produk.
 * 
 * Rute:
 * - GET /: Mengembalikan tampilan welcome.
 * - GET /home: Mengembalikan tampilan home, ditangani oleh HomeController@index.
 * - GET /products: Mengembalikan tampilan indeks produk, ditangani oleh ProductController@index.
 * 
 * Rute Autentikasi:
 * - Auth::routes(): Mendaftarkan rute autentikasi.
 * 
 * Rute Manajemen Produk (dilindungi oleh RoleMiddleware):
 * - GET /products/create: Mengembalikan tampilan pembuatan produk, ditangani oleh ProductController@create.
 * - GET /products/{product}/edit: Mengembalikan tampilan edit produk, ditangani oleh ProductController@edit.
 * - POST /products: Menyimpan produk baru, ditangani oleh ProductController@store.
 * - PUT /products/{product}: Memperbarui produk yang ada, ditangani oleh ProductController@update.
 * - DELETE /products/{product}: Menghapus produk, ditangani oleh ProductController@destroy.
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::middleware([RoleMiddleware::class])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
