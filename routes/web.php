<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\AuthController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::post('/checkout', [HomeController::class, 'processCheckout'])->name('checkout.process');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes (Any User)
Route::middleware(['auth'])->group(function () {
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// Admin & Super Admin Routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    // CMS settings route
    Route::post('/cms/settings', [CmsController::class, 'updateSettings'])->name('cms.settings.update');

    // CMS products CRUD routes
    Route::post('/cms/products', [CmsController::class, 'storeProduct'])->name('cms.products.store');
    Route::post('/cms/products/{id}', [CmsController::class, 'updateProduct'])->name('cms.products.update');
    Route::delete('/cms/products/{id}', [CmsController::class, 'destroyProduct'])->name('cms.products.destroy');

    // CMS categories CRUD routes
    Route::post('/cms/categories', [CmsController::class, 'storeCategory'])->name('cms.categories.store');
    Route::delete('/cms/categories/{id}', [CmsController::class, 'destroyCategory'])->name('cms.categories.destroy');

    // CMS orders
    Route::post('/cms/orders/{id}/status', [CmsController::class, 'updateOrderStatus'])->name('cms.orders.updateStatus');

    // Manage Users (Admin can manage Users, Super Admin can manage Admins and Users)
    Route::post('/cms/users', [CmsController::class, 'storeUser'])->name('cms.users.store');
    Route::post('/cms/users/{id}', [CmsController::class, 'updateUser'])->name('cms.users.update');
    Route::post('/cms/users/{id}/role', [CmsController::class, 'updateUserRole'])->name('cms.users.updateRole');
    Route::delete('/cms/users/{id}', [CmsController::class, 'destroyUser'])->name('cms.users.destroy');
});

// Super Admin Only Routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // CMS contact messages
    Route::delete('/cms/messages/{id}', [CmsController::class, 'destroyMessage'])->name('cms.messages.destroy');
});
