<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentMethodController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('verify', [JWTAuthController::class, 'verify']);
Route::post('login', [JWTAuthController::class, 'login']);
Route::post('refresh', [JWTAuthController::class, 'refresh']);

Route::middleware([JwtMiddleware::class, RoleMiddleware::class . ':USER'])->prefix('v1')->group(function () {

    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);

    Route::get('/images', [ImageController::class, 'index']);
    Route::get('/images/{filename}', [ImageController::class, 'show']);
    Route::post('/upload-image', [ImageController::class, 'upload']);
    Route::delete('/delete-image/{filename}', [ImageController::class, 'delete']);
    Route::delete('/delete-all-images', [ImageController::class, 'deleteAll']);

    Route::middleware([RoleMiddleware::class . ':ADMIN'])->group(function () {

        Route::post('/brands', [BrandController::class, 'store']);
        Route::put('/brands/{id}', [BrandController::class, 'update']);
        Route::delete('/brands/{id}', [BrandController::class, 'destroy']);

        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{username}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{username}', [UserController::class, 'update']);
        Route::delete('/users/{username}', [UserController::class, 'destroy']);

        Route::get('/roles', [RoleController::class, 'index']);
        Route::get('/roles/{role}', [RoleController::class, 'show']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::put('/roles/{role}', [RoleController::class, 'update']);
        Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

        Route::get('/payment_methods', [PaymentMethodController::class, 'index']);
        Route::get('/payment_methods/{name}', [PaymentMethodController::class, 'show']);
        Route::post('/payment_methods', [PaymentMethodController::class, 'store']);
        Route::put('/payment_methods/{name}', [PaymentMethodController::class, 'update']);
        Route::delete('/payment_methods/{name}', [PaymentMethodController::class, 'destroy']);

        Route::get('/shipment_methods', [ShipmentMethodController::class, 'index']);
        Route::get('/shipment_methods/{name}', [ShipmentMethodController::class, 'show']);
        Route::post('/shipment_methods', [ShipmentMethodController::class, 'store']);
        Route::put('/shipment_methods/{name}', [ShipmentMethodController::class, 'update']);
        Route::delete('/shipment_methods/{name}', [ShipmentMethodController::class, 'destroy']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

        Route::get('order-details', [OrderDetailController::class, 'index']);
        Route::get('order-details/{order_detail_id}', [OrderDetailController::class, 'show']);
        Route::get('order-details/order/{order_id}', [OrderDetailController::class, 'findByOrderId']);
        Route::get('order-details/total-amounct/{order_id}', [OrderDetailController::class, 'getTotalAmount']);
        Route::post('order-details', [OrderDetailController::class, 'store']);
        Route::put('order-details/{order_detail_id}', [OrderDetailController::class, 'update']);
        Route::delete('order-details/{order_detail_id}', [OrderDetailController::class, 'destroy']);

        Route::get('payments', [PaymentController::class, 'index']);
        Route::get('payments/{payment_id}', [PaymentController::class, 'show']);
        Route::post('payments', [PaymentController::class, 'store']);
        Route::put('payments/{payment_id}', [PaymentController::class, 'update']);
        Route::delete('payments/{payment_id}', [PaymentController::class, 'destroy']);

        Route::get('shipments', [ShipmentController::class, 'index']);
        Route::get('shipments/{shipment_id}', [ShipmentController::class, 'show']);
        Route::post('shipments', [ShipmentController::class, 'store']);
        Route::put('shipments/{shipment_id}', [ShipmentController::class, 'update']);
        Route::delete('shipments/{shipment_id}', [ShipmentController::class, 'destroy']);
    });

    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{id}', [BrandController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

});
