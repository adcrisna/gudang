<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GudangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/', [LoginController::class, 'index'])->name('index');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('login');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('home.admin');
        Route::any('/profile', [AdminController::class, 'profile'])->name('profile.admin');
        Route::any('/edit', [AdminController::class, 'edit'])->name('edit.admin');

        Route::any('/gudang', [AdminController::class, 'dataUsers'])->name('admin.gudang');
        Route::any('/add', [AdminController::class, 'addUsers'])->name('add.gudang');
        Route::any('/delete{id}', [AdminController::class, 'deleteUsers'])->name('delete.gudang');
        Route::any('/update', [AdminController::class, 'updateUsers'])->name('update.gudang');

        Route::any('/product', [AdminController::class, 'dataProduct'])->name('admin.product');
        Route::any('/tambahProduct', [AdminController::class, 'addProduct'])->name('add.product');
        Route::any('/hapusProduct{id}', [AdminController::class, 'deleteProduct'])->name('delete.product');
        Route::any('/ubahProduct', [AdminController::class, 'updateProduct'])->name('update.product');
        Route::any('/productTransaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');

        Route::any('/lokasi', [AdminController::class, 'dataLokasi'])->name('admin.lokasi');
        Route::any('/lokasiAdd', [AdminController::class, 'addLokasi'])->name('add.lokasi');
        Route::any('/lokasiUpdate', [AdminController::class, 'updateLokasi'])->name('update.lokasi');
        Route::any('/lokasiDelete{id}', [AdminController::class, 'deleteLokasi'])->name('delete.lokasi');

        Route::any('/history', [AdminController::class, 'dataHistory'])->name('admin.history');
        Route::any('/print', [AdminController::class, 'printHistory'])->name('admin.print');
        Route::any('/cetak', [AdminController::class, 'printProduct'])->name('admin.cetak');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('gudang')->middleware(['gudang'])->group(function () {
        Route::any('/home', [GudangController::class, 'index'])->name('home.gudang');

        Route::any('/barang', [GudangController::class, 'dataProduct'])->name('gudang.product');
        Route::any('/tambahBarang', [GudangController::class, 'addProduct'])->name('tambah.product');
        Route::any('/hapusBarang{id}', [GudangController::class, 'deleteProduct'])->name('hapus.product');
        Route::any('/ubahBarang', [GudangController::class, 'updateProduct'])->name('ubah.product');

        Route::any('/transaksi', [GudangController::class, 'transaksi'])->name('gudang.transaksi');
        Route::any('/riwayat', [GudangController::class, 'dataHistory'])->name('gudang.history');
    });
});