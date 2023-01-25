<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BikeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\User\UserPageController;
use App\Http\Controllers\Vendor\VendorPageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// public route
Route::name('page.')->group(function () {
    Route::get('/', [PageController::class, 'welcome'])->name('welcome');
    Route::get('/user-register', [PageController::class, 'userRegister'])->name('user-register');
});

// user auth route
Route::middleware(['auth', 'role:admin|user|vendor'])->name('user.')->group(function () {
    Route::get('home', [PageController::class, 'welcome'])->name('home');
    Route::get('about', [UserPageController::class, 'about'])->name('about');
    Route::get('bikes', [UserPageController::class, 'bikes'])->name('bikes');
    Route::get('bikes/{id}', [UserPageController::class, 'bikeDetail'])->name('bike-detail');
    Route::get('cart', [UserPageController::class, 'cart'])->name('cart');
    Route::post('/order', [UserPageController::class, 'order'])->name('order');
    Route::get('/order-list', [UserPageController::class, 'orderList'])->name('order-list');
    Route::get('/order-list/{id}', [UserPageController::class, 'orderDetail'])->name('order-detail');
    Route::post('cancel-order', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/change-password', [UserPageController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('/change-password', [UserPageController::class, 'changePassword'])->name('change-password');
});


// admin auth route
Route::middleware(['auth', 'role:admin|vendor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminPageController::class, 'dashboard'])->name('dashboard');
    // users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::post('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // brands
    Route::get('/bikes', [BikeController::class, 'index'])->name('bikes.index');
    Route::get('/bikes/create', [BikeController::class, 'create'])->name('bikes.create');
    Route::post('/bikes/store', [BikeController::class, 'store'])->name('bikes.store');
    Route::get('/bikes/edit/{id}', [BikeController::class, 'edit'])->name('bikes.edit');
    Route::post('/bikes/update/{id}', [BikeController::class, 'update'])->name('bikes.update');
    Route::post('/bikes/delete/{id}', [BikeController::class, 'destroy'])->name('bikes.destroy');

    // orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('return', [OrderController::class, 'return'])->name('orders.return');
    Route::post('rent', [OrderController::class, 'rent'])->name('orders.rent');

    // auth
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('show-reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});