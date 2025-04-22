<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;

// Route::prefix('user')->group(function () {
//     Route::get('/', [UserController::class, 'index'])->name('user'); // Halaman User
//     Route::get('/tambah', [UserController::class, 'tambah'])->name('user_create'); // Halaman Tambah User
//     Route::post('/tambah', [UserController::class, 'tambah_simpan'])->name('user_save'); // Proses Tambah User
//     Route::get('/ubah/{id}', [UserController::class, 'ubah'])->name('user_ubah'); // Halaman edit User
//     Route::put('/ubah/{id}', [UserController::class, 'ubah_simpan'])->name('user_update'); // Proses ubah user
//     Route::get('/hapus/{id}', [UserController::class, 'hapus'])->name('user_delete'); // Proses hapus user
// });

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('auth.postlogin');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

Route::middleware('authorize:CV')->group(function () {

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::pattern('id', '[0-9]+');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list'])->name('user.list'); // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create'])->name('user.create'); // menampilkan halaman form tambah user
        Route::post('/create', [UserController::class, 'store'])->name('user.store'); // menyimpan data user baru
        Route::get('/ajax', [UserController::class, 'create_ajax'])->name('user.create_ajax'); // Menampilkan halaman form tambah user Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax'); // Menyimpan data user baru Ajax
        Route::get('/{id}', [UserController::class, 'show'])->name('user.detail'); // menampilkan detail user
        Route::get('/{id}/show_ajax', [UserController::class, 'show_detail_ajax'])->name('user.show_ajax'); // Menampilkan detail user via modal ajax
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // menampilkan halaman form edit user
        Route::put('/{id}/edit', [UserController::class, 'update'])->name('user.update'); // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('user.edit_ajax'); // Menampilkan form edit user via modal ajax
        Route::put('/update_ajax', [UserController::class, 'update_ajax'])->name('user.update_ajax'); // Menyimpan perubahan data user ajax
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_delete_ajax'])->name('user.confirm_ajax'); // Menampilkan konfirmasi hapus user via modal ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('user.delete_ajax'); // Menghapus data user ajax
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // menghapus data user
    });

    Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index'])->name('level.index');
        Route::post('/list', [LevelController::class, 'list'])->name('level.list');
        Route::get('/create', [LevelController::class, 'create'])->name('level.create');
        Route::post('/create', [LevelController::class, 'store'])->name('level.store');
        Route::get('/ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
        Route::post('/ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
        Route::get('/{id}', [LevelController::class, 'show'])->name('level.detail');
        Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
        Route::put('/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
        Route::put('/{id}/edit', [LevelController::class, 'update'])->name('level.update');
        Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
    });

    Route::prefix('kategory')->group(function () {
        Route::get('/', [KategoryController::class, 'index'])->name('kategory.index');
        Route::post('/list', [KategoryController::class, 'list'])->name('kategory.list');
        Route::get('/create', [KategoryController::class, 'create'])->name('kategory.create');
        Route::post('/create', [KategoryController::class, 'store'])->name('kategory.store');
        Route::get('/{id}', [KategoryController::class, 'show'])->name('kategory.detail');
        Route::get('/{id}/edit', [KategoryController::class, 'edit'])->name('kategory.edit');
        Route::put('/{id}/edit', [KategoryController::class, 'update'])->name('kategory.update');
        Route::delete('/{id}', [KategoryController::class, 'destroy'])->name('kategory.destroy');
    });

    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/create', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/{id}/edit', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    Route::prefix('stok')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('stok.index');
        Route::get('/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/create', [StokController::class, 'store'])->name('stok.store');
        Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');
        Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
        Route::put('/{id}/edit', [StokController::class, 'update'])->name('stok.update');
        Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
    });
});
