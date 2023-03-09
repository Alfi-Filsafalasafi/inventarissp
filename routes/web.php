<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;

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



Auth::routes(['register' => false]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {

//Data Pengguna
Route::get('/user', [UserController::class, 'index'])->name('user.index');  
Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');  
Route::post('/user', [UserController::class, 'store'])->name('user.store');  
Route::get('/user/{user}/hapus', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::patch('/user/{user}', [UserController::class, 'update'])->name('user.update');

});

//Data Lokasi
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');  
Route::get('/lokasi/tambah', [LokasiController::class, 'create'])->name('lokasi.create');  
Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');  
Route::get('/lokasi/{lokasi}/hapus', [LokasiController::class, 'destroy'])->name('lokasi.delete');
Route::get('/lokasi/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
Route::patch('/lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');

//Data Barang
Route::get('/barang/{lokasi}/', [BarangController::class, 'index'])->name('barang.index'); 
Route::get('/barang/{lokasi}/tambah', [BarangController::class, 'create'])->name('barang.create');  
Route::post('/barang/{lokasi}', [BarangController::class, 'store'])->name('barang.store');  
Route::get('/barang/{barang}/hapus', [BarangController::class, 'destroy'])->name('barang.delete');
Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::patch('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::get('/barang/{lokasi}/cetak', [BarangController::class, 'cetak'])->name('barang.cetak');


//Data Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');  
Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create'])->name('peminjaman.create');  
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');  
Route::get('/peminjaman/{peminjaman}/hapus', [PeminjamanController::class, 'destroy'])->name('peminjaman.delete');
Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::patch('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');


//ambil barang dari lokasi
Route::get('/getbarang', [PeminjamanController::class, 'getBarang']);
Route::get('/gettersedia', [PeminjamanController::class, 'getTersedia']);



//ganti pass
Route::get('/password', [UserController::class, 'passedit'])->name('pass.edit');
Route::patch('/password', [UserController::class, 'passupdate'])->name('pass.update');

