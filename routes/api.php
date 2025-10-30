<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\PurchaseDetailController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\api\vue\DashboardController;

// Current logged-in user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('suppliers', SupplierController::class);

Route::get('/dropCategory', [ProductController::class, 'dropCategory']);
Route::get('/dashboardData', [DashboardController::class, 'getDashboardData']);


// Order
Route::get('allOrderindex', [OrderController::class, 'allOrderindex']);
Route::get('order/data', [OrderController::class, 'index']);
Route::post('order/processOrder', [OrderController::class, 'process']);
Route::get('vueorder/show/{id}', [OrderController::class, 'show']);

// Order Detail
Route::apiResource('orderDetail', OrderDetailController::class);

// // Purchase
// Route::get('allPurchaseindex', [PurchaseController::class, 'allPurchaseindex']);
// Route::get('purchase/data', [PurchaseController::class, 'index']);
// Route::post('purchase/processPurchase', [PurchaseController::class, 'process']);
// Route::get('vuepurchase/show/{id}', [PurchaseController::class, 'show']);

// // Purchase Detail
// Route::apiResource('purchaseDetail', PurchaseDetailController::class);



// Purchase
Route::get('allPurchaseindex', [PurchaseController::class, 'allPurchaseIndex']);
Route::get('purchases/data', [PurchaseController::class, 'index']);
Route::post('purchase/processPurchase', [PurchaseController::class, 'process']);
Route::get('vuepurchase/show/{id}', [PurchaseController::class, 'show']);

// Purchase Detail
Route::apiResource('purchaseDetail', PurchaseDetailController::class);








// Route::apiResource('purchases', PurchaseController::class);

// Purchase
Route::get('allPurchaseindex', [PurchaseController::class, 'allPurchaseindex']);
Route::get('purchase/data', [PurchaseController::class, 'index']);
Route::post('purchase/processOrder', [PurchaseController::class, 'process']);
Route::get('vuePurchase/show/{id}', [PurchaseController::class, 'show']);


Route::apiResource('purchaseDetail', PurchaseDetailController::class);



// Stocks
// Route::get('/stocks', [StockController::class, 'apiIndex']);
Route::get('/stocks', [StockController::class, 'index']);
