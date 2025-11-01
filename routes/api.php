<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\OrderReportController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\PurchaseDetailController;
use App\Http\Controllers\Api\PurchaseReportController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\SupplierController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Category
    Route::apiResource('categories', CategoryController::class);

    // Product
    Route::apiResource('products', ProductController::class);
    Route::get('/dropCategory', [ProductController::class, 'dropCategory']);

    // Customer
    Route::apiResource('customers', CustomerController::class);

    // Supplier
    Route::apiResource('suppliers', SupplierController::class);

    // Order
    Route::get('allOrderindex', [OrderController::class, 'allOrderindex']);
    Route::get('order/data', [OrderController::class, 'index']);
    Route::post('order/processOrder', [OrderController::class, 'process']);
    Route::get('vueorder/show/{id}', [OrderController::class, 'show']);

    // Order Detail
    Route::apiResource('orderDetail', OrderDetailController::class);

    // Purchase
    Route::get('allPurchaseindex', [PurchaseController::class, 'allPurchaseIndex']);
    Route::get('purchases/data', [PurchaseController::class, 'index']);
    Route::post('purchase/processPurchase', [PurchaseController::class, 'process']);
    Route::get('vuepurchase/show/{id}', [PurchaseController::class, 'show']);

    // Purchase Detail
    Route::apiResource('purchaseDetail', PurchaseDetailController::class);

    // Stocks
    Route::get('/stocks', [StockController::class, 'index']);

    // Dashboard
    Route::get('/dashboardData', [DashboardController::class, 'getDashboardData']);

    // Reports
    Route::get('orderReport/data', [OrderReportController::class, 'index']);
    Route::post('orderReport', [OrderReportController::class, 'orderReport']);

    Route::get('/purchaseReport/data', [PurchaseReportController::class, 'index']);
    Route::post('/purchaseReport', [PurchaseReportController::class, 'purchaseReport']);
});
