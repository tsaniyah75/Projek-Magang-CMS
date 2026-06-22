<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CmsController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::post('/checkout', [HomeController::class, 'processCheckout'])->name('checkout.process');

// CMS settings route
Route::post('/cms/settings', [CmsController::class, 'updateSettings'])->name('cms.settings.update');

// CMS products CRUD routes
Route::post('/cms/products', [CmsController::class, 'storeProduct'])->name('cms.products.store');
Route::post('/cms/products/{id}', [CmsController::class, 'updateProduct'])->name('cms.products.update');
Route::delete('/cms/products/{id}', [CmsController::class, 'destroyProduct'])->name('cms.products.destroy');

// CMS categories CRUD routes
Route::post('/cms/categories', [CmsController::class, 'storeCategory'])->name('cms.categories.store');
Route::delete('/cms/categories/{id}', [CmsController::class, 'destroyCategory'])->name('cms.categories.destroy');

// CMS orders & contact messages routes
Route::post('/cms/orders/{id}/status', [CmsController::class, 'updateOrderStatus'])->name('cms.orders.updateStatus');
Route::delete('/cms/messages/{id}', [CmsController::class, 'destroyMessage'])->name('cms.messages.destroy');
