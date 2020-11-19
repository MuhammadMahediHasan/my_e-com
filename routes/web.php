<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () { return view('welcome'); });
Route::get('/backend', [App\Http\Controllers\HomeController::class, 'index']);

Route::prefix('api/')->group(function () {
    Route::resource('/category', App\Http\Controllers\CategoryController::class);
    Route::resource('/sub_category', App\Http\Controllers\SubCategoryController::class);
    Route::resource('/child_category', App\Http\Controllers\ChildCategoryController::class);
    Route::resource('/vendor', App\Http\Controllers\VendorController::class);
    Route::resource('/user', App\Http\Controllers\UserController::class);
    Route::resource('/role', App\Http\Controllers\RoleController::class);
    Route::resource('/size', App\Http\Controllers\SizeController::class);
    Route::resource('/color', App\Http\Controllers\ColorController::class);
    Route::resource('/unit', App\Http\Controllers\UnitController::class);
    Route::resource('/material', App\Http\Controllers\MaterialController::class);
    Route::resource('/product', App\Http\Controllers\ProductController::class);
    Route::resource('/product_stock', App\Http\Controllers\ProductStockController::class);
    Route::get('/product_stock_summary', [App\Http\Controllers\ProductStockController::class, 'productStockSummary']);
    Route::post('/upload_image', [App\Http\Controllers\ProductController::class, 'uploadImage']);
    Route::get('/product_multiple_image/{id}', [App\Http\Controllers\ProductController::class, 'productMultipleImage']);
    Route::get('/product_image_delete/{image_id}/{product_id}', [App\Http\Controllers\ProductController::class, 'productImageDelete']);
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
