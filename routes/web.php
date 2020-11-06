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
});
Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
