<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::apiResources([
    'products' => ProductController::class,
]);
Route::post('products', [ProductController::class, 'store'])->can('create', Product::class);
Route::put('products/{product}', [ProductController::class, 'update'])->can('update', 'product');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->can('delete', 'product');
