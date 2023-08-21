<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin Router

Route::prefix('admin')->group(function () {

    //Brand
    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand/create', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/edit/{brand}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brand/edit/{brand}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brand/delete/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');

    //Category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/edit/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product', [ProductController::class, 'index'])->name('product.search');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/edit/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/show/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::delete('/product/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

//Frontend router
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/category/{id}', [ShopController::class, 'getProductByCategory'])->name('category');
Route::get('/product/{product}', [ShopController::class, 'product'])->name('product');
Route::get('/get-quantity', [ShopController::class, 'getQuantity']);

Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/delete/{product}/{size}', [CartController::class, 'delete'])->name('cart.delete');

Route::get('/login', [AuthUserController::class, 'login'])->name('login');
Route::post('/login', [AuthUserController::class, 'loginPost'])->name('loginPost');
Route::get('/register', [AuthUserController::class, 'register'])->name('register');
Route::post('/register', [AuthUserController::class, 'registerPost'])->name('registerPost');
Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');