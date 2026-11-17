<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('welcome');
});

// Menampilkan halaman katalog & memproses pencarian (Search)
Route::get('/katalog', [ProdukController::class, 'index']);

// Memproses penyimpanan data dari form Tambah Produk
Route::post('/katalog', [ProdukController::class, 'store']);

// Menampilkan halaman Tentang
Route::view('/tentang', 'produk.tentang');
