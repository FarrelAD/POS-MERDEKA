<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::pattern('id', '[0-9]+');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'postLogin')->name('login.post');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth'])
->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    
    // User
    Route::prefix('user')
        ->controller(UserController::class)
        ->group( function () {
        Route::get('/', 'index')->name('user.index');
        Route::post('/list', 'list')->name('user.list');
        Route::get('/create', 'create')->name('user.create');
        Route::get('/create-ajax', 'createAjax')->name('user.create-ajax');
        Route::post('/', 'storeAjax')->name('user.store-ajax');
        Route::post('/store-ajax', 'store')->name('user.store');
        Route::get('/{id}', 'show')->name('user.show');
        Route::get('/{id}/edit', 'edit')->name('user.edit');
        Route::put('/{id}', 'update')->name('user.update');
        Route::get('/{id}/edit-ajax', 'editAjax')->name('user.edit-ajax');
        Route::put('/{id}/update-ajax', 'updateAjax')->name('user.update-ajax');
        Route::delete('/{id}', 'destroy')->name('user.destroy');
        Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('user.confirm-delete-ajax');
        Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('user.delete-ajax');
    });
    
    // Level
    Route::prefix('level')
        ->middleware(['authorize:ADM,MNG'])
        ->controller(LevelController::class)
        ->group(function () {
        Route::get('/', 'index')->name('level.index');
        Route::post('/list',  'list')->name('level.list');
        Route::get('/create', 'create')->name('level.create');
        Route::get('/create-ajax', 'createAjax')->name('level.create-ajax');
        Route::post('/',  'store')->name('level.store');
        Route::post('/store-ajax', 'storeAjax')->name('level.store-ajax');
        Route::get('/{id}', 'show')->name('level.show');
        Route::get('/{id}/edit', 'edit')->name('level.edit');
        Route::get('/{id}/edit-ajax', 'editAjax')->name('level.edit-ajax');
        Route::put('/{id}', 'update')->name('level.update');
        Route::put('/{id}/update-ajax', 'updateAjax')->name('level.update-ajax');
        Route::delete('/{id}', 'destroy')->name('level.destroy');
        Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('level.confirm-delete-ajax');
        Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('level.delete-ajax');
    });
    
    // Kategori
    Route::prefix( 'kategori')
        ->controller(KategoriController::class)
        ->group(function () {
        Route::get('/', 'index')->name('kategori.index');
        Route::post('/list',  'list')->name('kategori.list');
        Route::get('/create', 'create')->name('kategori.create');
        Route::get('/create-ajax', 'createAjax')->name('kategori.create-ajax');
        Route::post('/', 'store')->name('kategori.store');
        Route::post('/store-ajax', 'storeAjax')->name('kategori.store-ajax');
        Route::get('/{id}', 'show')->name('kategori.show');
        Route::get('/{id}/edit', 'edit')->name('kategori.edit');
        Route::get('/{id}/edit-ajax', 'editAjax')->name('kategori.edit-ajax');
        Route::put('/{id}', 'update')->name('kategori.update');
        Route::put('/{id}/update-ajax', 'updateAjax')->name('kategori.update-ajax');
        Route::delete('/{id}', 'destroy')->name('kategori.destroy');
        Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('kategori.confirm-delete-ajax');
        Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('kategori.delete-ajax');
    });
    
    // Barang
    Route::prefix('barang')
        ->controller(BarangController::class)
        ->group( function () {
        Route::get('/', 'index')->name('barang.index');
        Route::post('/list', 'list')->name('barang.list');
        Route::get('/create', 'create')->name('barang.create');
        Route::get('/create-ajax', 'createAjax')->name('barang.create-ajax');
        Route::post('/', 'store')->name('barang.store');
        Route::post('/store-ajax', 'storeAjax')->name('barang.store-ajax');
        Route::get('/{id}', 'show')->name('barang.show');
        Route::get('/{id}/edit', 'edit')->name('barang.edit');
        Route::get('/{id}/edit-ajax', 'editAjax')->name('barang.edit-ajax');
        Route::put('/{id}', 'update')->name('barang.update');
        Route::put('/{id}/update-ajax', 'updateAjax')->name('barang.update-ajax');
        Route::delete('/{id}', 'destroy')->name('barang.destroy');
        Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('barang.confirm-delete-ajax');
        Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('barang.delete-ajax');
    });
    
    // Supplier
    Route::prefix( 'supplier')
        ->controller(SupplierController::class)
        ->group( function () {
        Route::get('/', 'index')->name('supplier.index');
        Route::post('/list', 'list')->name('supplier.list');
        Route::get('/create', 'create')->name('supplier.create');
        Route::get('/create-ajax', 'createAjax')->name('supplier.create-ajax');
        Route::post('/', 'store')->name('supplier.store');
        Route::post('/store-ajax', 'storeAjax')->name('supplier.store-ajax');
        Route::get('/{id}', 'show')->name('supplier.show');
        Route::get('/{id}/edit', 'edit')->name('supplier.edit');
        Route::get('/{id}/edit-ajax', 'editAjax')->name('supplier.edit-ajax');;
        Route::put('/{id}', 'update')->name('supplier.update');
        Route::put('/{id}/update-ajax', 'updateAjax')->name('supplier.update-ajax');
        Route::delete('/{id}', 'destroy')->name('supplier.destroy');
        Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('supplier.confirm-delete-ajax');
        Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('supplier.delete-ajax');
    });
});
