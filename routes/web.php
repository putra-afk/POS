<?php

use App\Http\Controllers\LevelController;
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

Route::get('/', [WelcomeController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index'); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list'])->name('user.list'); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create'])->name('user.create'); // menampilkan halaman form tambah user
    Route::post('/create', [UserController::class, 'store'])->name('user.store'); // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show'])->name('user.detail'); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // menampilkan halaman form edit user
    Route::put('/{id}/edit', [UserController::class, 'update'])->name('user.update'); // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // menghapus data user
});

Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::post('/list', [LevelController::class, 'list'])->name('level.list'); // ✅ Ensure this route exists
    Route::get('/create', [LevelController::class, 'create'])->name('level.create');
    Route::post('/create', [LevelController::class, 'store'])->name('level.store');
    Route::get('/{id}', [LevelController::class, 'show'])->name('level.detail');
    Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
    Route::put('/{id}/edit', [LevelController::class, 'update'])->name('level.update');
    Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
});
