<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index']);

// User
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('user.index');
    Route::post('/list', [UserController::class, 'list'])
        ->name('user.list');
    Route::get('/create', [UserController::class, 'create'])
        ->name('user.create');
    Route::get('/create_ajax', [UserController::class, 'createAjax'])
        ->name('user.create-ajax');
    Route::post('/ajax', [UserController::class, 'storeAjax'])
        ->name('user.store-ajax');
    Route::post('/', [UserController::class, 'store'])
        ->name('user.store');
    Route::get('/{id}', [UserController::class, 'show'])
        ->name('user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])
        ->name('user.edit');
    Route::put('/{id}', [UserController::class, 'update'])
        ->name('user.update');
    Route::get('/{id}/edit_ajax', [UserController::class, 'editAjax'])
        ->name('user.edit-ajax');
    Route::put('/{id}/update_ajax', [UserController::class, 'updateAjax'])
        ->name('user.update-ajax');
    Route::delete('/{id}', [UserController::class, 'destroy'])
        ->name('user.destroy');
    Route::get('/{id}/delete-ajax', [UserController::class, 'confirmDeleteAjax'])
        ->name('user.confirm-delete-ajax');
    Route::delete('/{id}/delete-ajax', [UserController::class, 'deleteAjax'])
        ->name('user.delete-ajax');
});

// Level
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index'])
        ->name('level.index');
    Route::post('/list', [LevelController::class, 'list'])
        ->name('level.list');
    Route::get('/create', [LevelController::class, 'create'])
        ->name('level.create');
    Route::post('/', [LevelController::class, 'store'])
        ->name('level.store');
    Route::get('/{id}', [LevelController::class, 'show'])
        ->name('level.show');
    Route::get('/{id}/edit', [LevelController::class, 'edit'])
        ->name('level.edit');
    Route::put('/{id}', [LevelController::class, 'update'])
        ->name('level.update');
    Route::delete('/{id}', [LevelController::class, 'destroy'])
        ->name('level.destroy');
});

// Kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index'])
        ->name('kategori.index');
    Route::post('/list', [KategoriController::class, 'list'])
        ->name('kategori.list');
    Route::get('/create', [KategoriController::class, 'create'])
        ->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])
        ->name('kategori.store');
    Route::get('/{id}', [KategoriController::class, 'show'])
        ->name('kategori.show');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])
        ->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])
        ->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])
        ->name('kategori.destroy');
});

// Barang
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index'])
        ->name('barang.index');
    Route::post('/list', [BarangController::class, 'list'])
        ->name('barang.list');
    Route::get('/create', [BarangController::class, 'create'])
        ->name('barang.create');
    Route::post('/', [BarangController::class, 'store'])
        ->name('barang.store');
    Route::get('/{id}', [BarangController::class, 'show'])
        ->name('barang.show');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])
        ->name('barang.edit');
    Route::put('/{id}', [BarangController::class, 'update'])
        ->name('barang.update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])
        ->name('barang.destroy');
});

// Supplier
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index'])
        ->name('supplier.index');
    Route::post('/list', [SupplierController::class, 'list'])
        ->name('supplier.list');
    Route::get('/create', [SupplierController::class, 'create'])
        ->name('supplier.create');
    Route::post('/', [SupplierController::class, 'store'])
        ->name('supplier.store');
    Route::get('/{id}', [SupplierController::class, 'show'])
        ->name('supplier.show');
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])
        ->name('supplier.edit');
    Route::put('/{id}', [SupplierController::class, 'update'])
        ->name('supplier.update');
    Route::delete('/{id}', [SupplierController::class, 'destroy'])
        ->name('supplier.destroy');
});
