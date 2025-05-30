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

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'postregister'])->name('auth.postregister');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::pattern('id', '[0-9]+');

    Route::middleware(['authorize:CV,ADMIN'])->group(function () {
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
    });

    Route::middleware(['authorize:ADMIN'])->group(function () {
        Route::prefix('level')->group(function () {
            Route::get('/', [LevelController::class, 'index'])->name('level.index');
            Route::post('/list', [LevelController::class, 'list'])->name('level.list');
            Route::get('/create', [LevelController::class, 'create'])->name('level.create');
            Route::post('/create', [LevelController::class, 'store'])->name('level.store');
            Route::get('/ajax', [LevelController::class, 'create_ajax'])->name('level.create_ajax');
            Route::post('/ajax', [LevelController::class, 'store_ajax'])->name('level.store_ajax');
            Route::get('/{id}', [LevelController::class, 'show'])->name('level.detail');
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_detail_ajax'])->name('level.show_ajax');
            Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax'])->name('level.edit_ajax');
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax'])->name('level.update_ajax');
            Route::put('/{id}/edit', [LevelController::class, 'update'])->name('level.update');
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_delete_ajax'])->name('level.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax'])->name('level.delete_ajax');
            Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
        });
    });

    Route::middleware(['authorize:ADMIN,STF'])->group(function () {
        Route::prefix('kategory')->group(function () {
            Route::get('/', [KategoryController::class, 'index'])->name('kategory.index');
            Route::post('/list', [KategoryController::class, 'list'])->name('kategory.list');
            Route::get('/create', [KategoryController::class, 'create'])->name('kategory.create');
            Route::get('/ajax', [KategoryController::class, 'create_ajax'])->name('kategory.create_ajax');
            Route::post('/ajax', [KategoryController::class, 'store_ajax'])->name('kategory.store_ajax');
            Route::post('/create', [KategoryController::class, 'store'])->name('kategory.store');
            Route::get('/{id}', [KategoryController::class, 'show'])->name('kategory.detail');
            Route::get('/{id}/show_ajax', [KategoryController::class, 'show_detail_ajax'])->name('kategory.show_ajax');
            Route::get('/{id}/edit', [KategoryController::class, 'edit'])->name('kategory.edit');
            Route::get('/{id}/edit_ajax', [KategoryController::class, 'edit_ajax'])->name('kategory.edit_ajax');
            Route::put('/{id}/update_ajax', [KategoryController::class, 'update_ajax'])->name('kategory.update_ajax');
            Route::put('/{id}/edit', [KategoryController::class, 'update'])->name('kategory.update');
            Route::get('/{id}/delete_ajax', [KategoryController::class, 'confirm_delete_ajax'])->name('kategory.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [KategoryController::class, 'delete_ajax'])->name('kategory.delete_ajax');
            Route::delete('/{id}', [KategoryController::class, 'destroy'])->name('kategory.destroy');
        });

        Route::prefix('barang')->group(function () {
            Route::get('/', [BarangController::class, 'index'])->name('barang.index');
            Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
            Route::post('/list', [BarangController::class, 'list'])->name('barang.list');
            Route::get('/ajax', [BarangController::class, 'create_ajax'])->name('barang.create_ajax');
            Route::post('/ajax', [BarangController::class, 'store_ajax'])->name('barang.store_ajax');
            Route::post('/create', [BarangController::class, 'store'])->name('barang.store');
            Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_detail_ajax'])->name('barang.show_ajax');
            Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax'])->name('barang.edit_ajax');
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax'])->name('barang.update_ajax');
            Route::put('/{id}/edit', [BarangController::class, 'update'])->name('barang.update');
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_delete_ajax'])->name('barang.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax'])->name('barang.delete_ajax');
            Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
            Route::get('/import', [BarangController::class, 'import'])->name('barang.import');
            Route::post('/import_ajax', [BarangController::class, 'import_ajax'])->name('barang.import_ajax');
            Route::get('export_excel', [BarangController::class, 'export_excel'])->name('barang.export_excel');
            Route::get('export_pdf', [BarangController::class, 'export_pdf'])->name('barang.export_pdf');
        });

        Route::prefix('stok')->group(function () {
            Route::get('/', [StokController::class, 'index'])->name('stok.index');
            Route::post('/list', [StokController::class, 'list'])->name('stok.list');
            Route::get('/create', [StokController::class, 'create'])->name('stok.create');
            Route::get('/ajax', [StokController::class, 'create_ajax'])->name('stok.create_ajax');
            Route::post('/ajax', [StokController::class, 'store_ajax'])->name('stok.store_ajax');
            Route::post('/create', [StokController::class, 'store'])->name('stok.store');
            Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');
            Route::get('/{id}/show_ajax', [StokController::class, 'show_detail_ajax'])->name('stok.show_ajax');
            Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax'])->name('stok.edit_ajax');
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax'])->name('stok.update_ajax');
            Route::put('/{id}/edit', [StokController::class, 'update'])->name('stok.update');
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_delete_ajax'])->name('stok.confirm_ajax');
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax'])->name('stok.delete_ajax');
            Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
        });
    });
});
