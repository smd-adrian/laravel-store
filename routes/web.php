<?php

use Illuminate\Support\Facades\Auth;
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

// Auth routes
Auth::routes(['register' => false]);

// Front public routes
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('front.index');
Route::get('/productos', [App\Http\Controllers\Front\ProductController::class, 'index'])->name('front.products.index');

// Admin routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
