<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\PostController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthUserController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\OrderHistoryController;
use App\Http\Controllers\Frontend\BlogController;
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
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.loginPost');

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        //Brand
        Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/brand/create', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand/edit/{brand}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/brand/edit/{brand}', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/delete/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');

        //Post Type
        Route::get('/post_type', [PostTypeController::class, 'index'])->name('post_type.index');
        Route::get('/post_type/create', [PostTypeController::class, 'create'])->name('post_type.create');
        Route::post('/post_type/create', [PostTypeController::class, 'store'])->name('post_type.store');
        Route::get('/post_type/edit/{post_type}', [PostTypeController::class, 'edit'])->name('post_type.edit');
        Route::post('/post_type/edit/{post_type}', [PostTypeController::class, 'update'])->name('post_type.update');
        Route::delete('/post_type/delete/{post_type}', [PostTypeController::class, 'destroy'])->name('post_type.destroy');

        //Post
        Route::get('/post', [PostController::class, 'index'])->name('post.index');
        Route::post('/post', [PostController::class, 'index'])->name('post.search');
        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post/create', [PostController::class, 'store'])->name('post.store');
        Route::get('/post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/post/edit/{post}', [PostController::class, 'update'])->name('post.update');
        Route::get('/post/show/{post}', [PostController::class, 'show'])->name('post.show');
        Route::delete('/post/delete/{post}', [PostController::class, 'destroy'])->name('post.destroy');

        //Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/edit/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

        //Order
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/show/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/order/confirm/{order}', [OrderController::class, 'confirm'])->name('order.confirm');

        //User
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/user/{user}', [UserController::class, 'handleStatus'])->name('user.status');
        
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
});

//Frontend router
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/contact', [ShopController::class, 'contact'])->name('contact');
Route::get('/category/{id}', [ShopController::class, 'getProductByCategory'])->name('category');
Route::get('/product/{product}', [ShopController::class, 'product'])->name('product');
Route::get('/brand/{brand}', [ShopController::class, 'brand'])->name('brand');
Route::get('/get-quantity', [ShopController::class, 'getQuantity']);

//Blog
Route::get('/blog', [BlogController::class, 'blog'])->name('blog');
Route::get('/blog/{post}', [BlogController::class, 'blogDetail'])->name('blog.detail');

//Cart
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/increase/{product_id}/{size}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{product_id}/{size}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/delete/{product_id}/{size}', [CartController::class, 'delete'])->name('cart.delete');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthUserController::class, 'login'])->name('login');
    Route::post('/login', [AuthUserController::class, 'loginPost'])->name('loginPost');
    Route::get('/register', [AuthUserController::class, 'register'])->name('register');
    Route::post('/register', [AuthUserController::class, 'registerPost'])->name('registerPost');

    Route::get('/forgot-password', [AuthUserController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthUserController::class, 'forgotPasswordPost'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthUserController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthUserController::class, 'resetPasswordPost'])->name('password.update');
});

Route::middleware(['auth:web'])->group(function () {
    Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkoutPost');
    Route::get('/checkout/vnPayCheck', [CheckoutController::class, 'vnPayCheck'])->name('checkout.vnpay');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/change-password', [ProfileController::class, 'changePasswordPost'])->name('profile.update-password');

    Route::get('/order-history', [OrderHistoryController::class, 'index'])->name('order-history');
    Route::get('/order-history/{order}', [OrderHistoryController::class, 'orderDetail'])->name('order.detail');
    Route::post('/order-history/cancel/{order}', [OrderHistoryController::class, 'cancel'])->name('order.cancel');
    Route::post('/order-history/receive/{order}', [OrderHistoryController::class, 'receive'])->name('order.receive');
    Route::post('/order-history/return/{order}', [OrderHistoryController::class, 'return'])->name('order.return');


});