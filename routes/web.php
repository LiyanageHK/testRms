<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ItemCategoryController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductCategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // 🔸 Category CRUD
    Route::get('categories', [ItemCategoryController::class, 'index']);
    Route::get('categories/create', [ItemCategoryController::class, 'create']);
    Route::post('categories/store', [ItemCategoryController::class, 'store']);
    Route::get('categories/edit/{id}', [ItemCategoryController::class, 'edit']);
    Route::post('categories/update/{id}', [ItemCategoryController::class, 'update']);
    Route::get('categories/delete/{id}', [ItemCategoryController::class, 'destroy']);

    // 🔸 Item CRUD
    Route::get('items', [ItemController::class, 'index']);
    Route::get('items/create', [ItemController::class, 'create']);
    Route::post('items/store', [ItemController::class, 'store']);
    Route::get('items/edit/{id}', [ItemController::class, 'edit']);
    Route::post('items/update/{id}', [ItemController::class, 'update']);
    Route::get('items/delete/{id}', [ItemController::class, 'destroy']);


    Route::get('production', [ProductionController::class, 'index']);
    Route::get('production/create', [ProductionController::class, 'create']);
    Route::post('production/store', [ProductionController::class, 'store']);
    Route::get('production/edit/{id}', [ProductionController::class, 'edit']);
    Route::post('production/update/{id}', [ProductionController::class, 'update']);
    Route::get('production/delete/{id}', [ProductionController::class, 'destroy']);
    Route::delete('production/image/delete/{id}', [ProductionController::class, 'deleteImage']);


    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/create', [RoleController::class, 'create']);
    Route::post('role/store', [RoleController::class, 'store']);
    Route::get('role/edit/{id}', [RoleController::class, 'edit']);
    Route::post('role/update/{id}', [RoleController::class, 'update']);
    Route::get('role/delete/{id}', [RoleController::class, 'destroy']);


    Route::prefix('productcategories')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index']);
        Route::get('/create', [ProductCategoryController::class, 'create']);
        Route::post('/store', [ProductCategoryController::class, 'store']);
        Route::get('/edit/{id}', [ProductCategoryController::class, 'edit']);
        Route::post('/update/{id}', [ProductCategoryController::class, 'update']);
        Route::get('/delete/{id}', [ProductCategoryController::class, 'destroy']);
    });
});