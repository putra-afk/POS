<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user'); // Halaman User
    Route::get('/tambah', [UserController::class, 'tambah'])->name('user_create'); // Halaman Tambah User
    Route::post('/tambah', [UserController::class, 'tambah_simpan'])->name('user_save'); // Proses Tambah User
    Route::get('/ubah/{id}', [UserController::class, 'ubah'])->name('user_ubah'); // Halaman edit User
    Route::put('/ubah/{id}', [UserController::class, 'ubah_simpan'])->name('user_update'); // Proses ubah user
    Route::get('/hapus/{id}', [UserController::class, 'hapus'])->name('user_delete'); // Proses hapus user
});
