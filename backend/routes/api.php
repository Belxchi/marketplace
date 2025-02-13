<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UnitsSoldController;

Route::apiResource('products', ProductController::class);
Route::apiResource('offers', OfferController::class);
Route::apiResource('sales', SaleController::class);
Route::get('/units-sold', [UnitsSoldController::class, 'index']);
