<?php

declare(strict_types=1);

use App\Http\Controllers\Api\IncomesController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\StocksController;
use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\EnsureApiKeyIsValid::class)->group(function (): void {
    Route::get('sales', SalesController::class)->name('api.sales');
    Route::get('orders', OrdersController::class)->name('api.orders');
    Route::get('stocks', StocksController::class)->name('api.stocks');
    Route::get('incomes', IncomesController::class)->name('api.incomes');
});
