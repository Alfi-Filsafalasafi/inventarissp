<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LokasiManajerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangManajerController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamanManajerController;
use App\Http\Controllers\HomeManajerController;

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



Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:admin'])->group(function () {

//Data Pengguna
Route::get('/user', [UserController::class, 'index'])->name('user.index');  
Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');  
Route::post('/user', [UserController::class, 'store'])->name('user.store');  
// Route::get('/user/{user}/hapus', [UserController::class, 'destroy'])->name('user.delete');
Route::delete('/user/{user}/hapus', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::patch('/user/{user}', [UserController::class, 'update'])->name('user.update');

});

//Data Lokasi
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');  
Route::get('/lokasi/tambah', [LokasiController::class, 'create'])->name('lokasi.create');  
Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');  
Route::delete('/lokasi/{lokasi}/hapus', [LokasiController::class, 'destroy'])->name('lokasi.delete');
Route::get('/lokasi/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
Route::patch('/lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');

//Data Barang
Route::get('/alat/{lokasi}/', [BarangController::class, 'index'])->name('barang.index'); 
Route::get('/alat/{lokasi}/tambah', [BarangController::class, 'create'])->name('barang.create');  
Route::post('/alat/{lokasi}', [BarangController::class, 'store'])->name('barang.store');  
Route::delete('/alat/{barang}/hapus', [BarangController::class, 'destroy'])->name('barang.delete');
Route::get('/alat/{barang}/edit/{lokasi}', [BarangController::class, 'edit'])->name('barang.edit');
Route::patch('/alat/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::get('/alat/{lokasi}/cetak', [BarangController::class, 'cetak'])->name('barang.cetak');


//Data Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');  
Route::get('/peminjaman/cetak', [PeminjamanController::class, 'cetak'])->name('peminjaman.cetak');  
Route::get('/peminjaman/tambah/{kode_pinjam}', [PeminjamanController::class, 'create'])->name('peminjaman.create');  
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');  
Route::post('/peminjaman/barang/', [PeminjamanController::class, 'storebarang'])->name('peminjaman.storebarang');  
Route::get('/peminjaman/dataPeminjaman', [PeminjamanController::class, 'storeDataPeminjam'])->name('peminjaman.storeDataPeminjam');  
Route::delete('/peminjaman/{peminjaman}/hapus', [PeminjamanController::class, 'destroy'])->name('peminjaman.delete');
Route::get('/peminjaman/{kode_pinjam}/batalpinjam', [PeminjamanController::class, 'batalPinjam'])->name('peminjaman.batal');
Route::get('/peminjaman/{peminjaman}/hapus/barang/{kode_pinjam}', [PeminjamanController::class, 'destroybarangpinjam'])->name('peminjaman.deletebarangpinjam');
Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::patch('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::patch('/peminjaman/{kode_pinjam}/finalisasi', [PeminjamanController::class, 'finalisasi'])->name('peminjaman.finalisasi');

Route::get('/peminjaman/{id}/status', [PeminjamanController::class, 'statusUbah'])->name('peminjaman.statusUbah');

//ambil barang dari lokasi
Route::get('/getbarang', [PeminjamanController::class, 'getBarang']);
Route::get('/gettersedia', [PeminjamanController::class, 'getTersedia']);



//ganti pass
Route::get('/password', [UserController::class, 'passedit'])->name('pass.edit');
Route::patch('/password', [UserController::class, 'passupdate'])->name('pass.update');



//Manajer
Route::get('/manajer', [HomeManajerController::class, 'index'])->name('home.manajer');


//Data Lokasi
Route::get('/manajer/lokasi', [LokasiManajerController::class, 'index'])->name('lokasi.index.manajer');

//Data Barang
Route::get('/manajer/barang/{lokasi}/', [BarangManajerController::class, 'index'])->name('barang.index.manajer'); 
Route::get('/manajer/barang/{lokasi}/cetak', [BarangManajerController::class, 'cetak'])->name('barang.cetak.manajer');

Route::get('/manajer/peminjaman', [PeminjamanManajerController::class, 'index'])->name('peminjaman.index.manajer');  
Route::get('/manajer/peminjaman/cetak', [PeminjamanManajerController::class, 'cetak'])->name('peminjaman.cetak.manajer');  
Route::get('/manajer/peminjaman/tambah/{kode_pinjam}', [PeminjamanManajerController::class, 'create'])->name('peminjaman.create.manajer');  
Route::post('/manajer/peminjaman', [PeminjamanManajerController::class, 'store'])->name('peminjaman.store.manajer');  
Route::post('/manajer/peminjaman/barang/', [PeminjamanManajerController::class, 'storebarang'])->name('peminjaman.storebarang.manajer');  
Route::get('/manajer/peminjaman/dataPeminjaman', [PeminjamanManajerController::class, 'storeDataPeminjam'])->name('peminjaman.storeDataPeminjam.manajer');  
Route::get('/manajer/peminjaman/{kode_pinjam}/batalpinjam', [PeminjamanManajerController::class, 'batalPinjam'])->name('peminjaman.batal.manajer');
Route::get('/manajer/peminjaman/{peminjaman}/hapus/barang/{kode_pinjam}', [PeminjamanManajerController::class, 'destroybarangpinjam'])->name('peminjaman.deletebarangpinjam.manajer');
Route::patch('/manajer/peminjaman/{kode_pinjam}/finalisasi', [PeminjamanManajerController::class, 'finalisasi'])->name('peminjaman.finalisasi.manajer');

Route::get('/manajer/getbarang', [PeminjamanManajerController::class, 'getBarang']);
Route::get('/manajer/gettersedia', [PeminjamanManajerController::class, 'getTersedia']);
Route::get('/manajer/peminjaman/{id}/status', [PeminjamanManajerController::class, 'statusUbah'])->name('peminjaman.statusUbah.manajer');