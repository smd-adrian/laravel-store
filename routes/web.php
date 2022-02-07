<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;

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
Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/productos', [ProductController::class, 'index'])->name('front.products.index');
Route::get('/carrito', [CartController::class, 'index'])->name('front.cart.index');
Route::get('/carrito/agregar/{id}', [CartController::class, 'addToCart'])->name('front.cart.add');
Route::get('/carrito/remover/{id}', [CartController::class, 'removeItemCart'])->name('front.cart.remove');
Route::get('/carrito/pago', [CartController::class, 'checkout'])->name('front.cart.checkout');
// Admin routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
