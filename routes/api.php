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
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//
Route::group(['prefix' => 'v1'], function () {

    Route::apiResource('sliders', SliderController::class);

    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('verify', [JWTAuthController::class, 'verify']);
    Route::post('resend', [JWTAuthController::class, 'resendVerifyCode']);
    Route::middleware(['throttle:login'])->post('login', [JWTAuthController::class, 'login']);
    Route::post('refresh', [JWTAuthController::class, 'refresh']);

    Route::middleware(['throttle:api'])->get('/images', [ImageController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/images/{filename}', [ImageController::class, 'show']);
    Route::middleware(['throttle:api'])->post('/upload-image', [ImageController::class, 'upload']);
    Route::middleware(['throttle:api'])->delete('/delete-image/{filename}', [ImageController::class, 'delete']);
    Route::middleware(['throttle:api'])->delete('/delete-all-images', [ImageController::class, 'deleteAll']);

    Route::middleware(['throttle:api'])->get('/brands', [BrandController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/brands/{id}', [BrandController::class, 'show']);

    Route::middleware(['throttle:api'])->get('/categories', [CategoryController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/categories/{id}', [CategoryController::class, 'show']);

    Route::middleware(['throttle:api'])->get('/products', [ProductController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/products/{id}', [ProductController::class, 'show']);
});

Route::middleware([JwtMiddleware::class, RoleMiddleware::class . ':USER'])->prefix('v1')->group(function () {

    Route::middleware(['throttle:api'])->get('user', [JWTAuthController::class, 'getUser']);
    Route::middleware(['throttle:api'])->post('logout', [JWTAuthController::class, 'logout']);

    Route::middleware(['throttle:api'])->post('/orders', [OrderController::class, 'store']);

    Route::middleware(['throttle:api'])->get('order-details/order/{order_id}', [OrderDetailController::class, 'findByOrderId']);
    Route::middleware(['throttle:api'])->get('order-details/total-amount/{order_id}', [OrderDetailController::class, 'getTotalAmount']);
    Route::middleware(['throttle:api'])->post('order-details', [OrderDetailController::class, 'store']);

    Route::middleware(['throttle:api'])->get('/payment_methods', [PaymentMethodController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/payment_methods/{name}', [PaymentMethodControlller::class, 'show']);

    Route::middleware(['throttle:api'])->get('/shipment_methods', [ShipmentMethodController::class, 'index']);
    Route::middleware(['throttle:api'])->get('/shipment_methods/{name}', [ShipmentMethodController::class, 'show']);

    Route::middleware(['throttle:api'])->post('payments', [PaymentController::class, 'store']);

    Route::middleware(['throttle:api'])->post('shipments', [ShipmentController::class, 'store']);

    Route::middleware([RoleMiddleware::class . ':ADMIN'])->group(function () {

        Route::middleware(['throttle:api'])->post('/brands', [BrandController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/brands/{id}', [BrandController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/brands/{id}', [BrandController::class, 'destroy']);

        Route::middleware(['throttle:api'])->post('/categories', [CategoryController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/categories/{id}', [CategoryController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::middleware(['throttle:api'])->post('/products', [ProductController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/products/{id}', [ProductController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/products/{id}', [ProductController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('/users', [UserController::class, 'index']);
        Route::middleware(['throttle:api'])->get('/users/{username}', [UserController::class, 'show']);
        Route::middleware(['throttle:api'])->post('/users', [UserController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/users/{username}', [UserController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/users/{username}', [UserController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('/roles', [RoleController::class, 'index']);
        Route::middleware(['throttle:api'])->get('/roles/{role}', [RoleController::class, 'show']);
        Route::middleware(['throttle:api'])->post('/roles', [RoleController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/roles/{role}', [RoleController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/roles/{role}', [RoleController::class, 'destroy']);

//        Route::get('/payment_methods', [PaymentMethodController::class, 'index']);
//        Route::get('/payment_methods/{name}', [PaymentMethodController::class, 'show']);
        Route::middleware(['throttle:api'])->post('/payment_methods', [PaymentMethodController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/payment_methods/{name}', [PaymentMethodController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/payment_methods/{name}', [PaymentMethodController::class, 'destroy']);

        Route::middleware(['throttle:api'])->post('/shipment_methods', [ShipmentMethodController::class, 'store']);
        Route::middleware(['throttle:api'])->put('/shipment_methods/{name}', [ShipmentMethodController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/shipment_methods/{name}', [ShipmentMethodController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('/orders', [OrderController::class, 'index']);
        Route::middleware(['throttle:api'])->get('/orders/{id}', [OrderController::class, 'show']);
        Route::middleware(['throttle:api'])->put('/orders/{id}', [OrderController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('/orders/{id}', [OrderController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('order-details', [OrderDetailController::class, 'index']);
        Route::middleware(['throttle:api'])->get('order-details/{order_detail_id}', [OrderDetailController::class, 'show']);
        Route::middleware(['throttle:api'])->put('order-details/{order_detail_id}', [OrderDetailController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('order-details/{order_detail_id}', [OrderDetailController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('payments', [PaymentController::class, 'index']);
        Route::middleware(['throttle:api'])->get('payments/{payment_id}', [PaymentController::class, 'show']);
        Route::middleware(['throttle:api'])->put('payments/{payment_id}', [PaymentController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('payments/{payment_id}', [PaymentController::class, 'destroy']);

        Route::middleware(['throttle:api'])->get('shipments', [ShipmentController::class, 'index']);
        Route::middleware(['throttle:api'])->get('shipments/{shipment_id}', [ShipmentController::class, 'show']);
        Route::middleware(['throttle:api'])->put('shipments/{shipment_id}', [ShipmentController::class, 'update']);
        Route::middleware(['throttle:api'])->delete('shipments/{shipment_id}', [ShipmentController::class, 'destroy']);
    });

});

//Route::prefix('v1')->group(function () {
//
//    Route::post('register', [JWTAuthController::class, 'register']);
//    Route::post('verify', [JWTAuthController::class, 'verify']);
//    Route::post('resend', [JWTAuthController::class, 'resendVerifyCode']);
//    Route::post('login', [JWTAuthController::class, 'login']);
//    Route::post('refresh', [JWTAuthController::class, 'refresh']);
//
//    Route::get('/images', [ImageController::class, 'index']);
//    Route::get('/images/{filename}', [ImageController::class, 'show']);
//    Route::post('/upload-image', [ImageController::class, 'upload']);
//    Route::delete('/delete-image/{filename}', [ImageController::class, 'delete']);
//    Route::delete('/delete-all-images', [ImageController::class, 'deleteAll']);
//
//
//    Route::get('user', [JWTAuthController::class, 'getUser']);
//    Route::post('logout', [JWTAuthController::class, 'logout']);
//
//        Route::post('/brands', [BrandController::class, 'store']);
//        Route::put('/brands/{id}', [BrandController::class, 'update']);
//        Route::delete('/brands/{id}', [BrandController::class, 'destroy']);
//
//        Route::post('/categories', [CategoryController::class, 'store']);
//        Route::put('/categories/{category_id}', [CategoryController::class, 'update']);
//        Route::delete('/categories/{category_id}', [CategoryController::class, 'destroy']);
//
//        Route::post('/products', [ProductController::class, 'store']);
//        Route::put('/products/{product_id}', [ProductController::class, 'update']);
//        Route::delete('/products/{product_id}', [ProductController::class, 'destroy']);
//
//        Route::get('/users', [UserController::class, 'index']);
//        Route::get('/users/{username}', [UserController::class, 'show']);
//        Route::post('/users', [UserController::class, 'store']);
//        Route::put('/users/{username}', [UserController::class, 'update']);
//        Route::delete('/users/{username}', [UserController::class, 'destroy']);
//
//        Route::get('/roles', [RoleController::class, 'index']);
//        Route::get('/roles/{role}', [RoleController::class, 'show']);
//        Route::post('/roles', [RoleController::class, 'store']);
//        Route::put('/roles/{role}', [RoleController::class, 'update']);
//        Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
//
//        Route::get('/payment_methods', [PaymentMethodController::class, 'index']);
//        Route::get('/payment_methods/{name}', [PaymentMethodController::class, 'show']);
//        Route::post('/payment_methods', [PaymentMethodController::class, 'store']);
//        Route::put('/payment_methods/{name}', [PaymentMethodController::class, 'update']);
//        Route::delete('/payment_methods/{name}', [PaymentMethodController::class, 'destroy']);
//
//        Route::get('/shipment_methods', [ShipmentMethodController::class, 'index']);
//        Route::get('/shipment_methods/id/{shipmentMethodId}', [ShipmentMethodController::class, 'getById']);
//        Route::get('/shipment_methods/{name}', [ShipmentMethodController::class, 'show']);
//        Route::post('/shipment_methods', [ShipmentMethodController::class, 'store']);
//        Route::put('/shipment_methods/{name}', [ShipmentMethodController::class, 'update']);
//        Route::delete('/shipment_methods/{name}', [ShipmentMethodController::class, 'destroy']);
//
//        Route::get('/orders', [OrderController::class, 'index']);
//        Route::get('/orders/{id}', [OrderController::class, 'show']);
//        Route::get('/orders/last/id', [OrderController::class, 'getLastOrderId']);
//        Route::post('/orders', [OrderController::class, 'store']);
//        Route::put('/orders/{id}', [OrderController::class, 'update']);
//        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
//
//        Route::get('order-details', [OrderDetailController::class, 'index']);
//        Route::get('order-details/{order_detail_id}', [OrderDetailController::class, 'show']);
//        Route::get('order-details/order/{order_id}', [OrderDetailController::class, 'findByOrderId']);
//        Route::get('order-details/total-amount/{order_id}', [OrderDetailController::class, 'getTotalAmount']);
//        Route::post('order-details', [OrderDetailController::class, 'store']);
//        Route::put('order-details/{order_detail_id}', [OrderDetailController::class, 'update']);
//        Route::delete('order-details/{order_detail_id}', [OrderDetailController::class, 'destroy']);
//
//        Route::get('payments', [PaymentController::class, 'index']);
//        Route::get('payments/{payment_id}', [PaymentController::class, 'show']);
//        Route::post('payments', [PaymentController::class, 'store']);
//        Route::put('payments/{payment_id}', [PaymentController::class, 'update']);
//        Route::delete('payments/{payment_id}', [PaymentController::class, 'destroy']);
//
//        Route::get('shipments', [ShipmentController::class, 'index']);
//        Route::get('shipments/{shipment_id}', [ShipmentController::class, 'show']);
//        Route::post('shipments', [ShipmentController::class, 'store']);
//        Route::put('shipments/{shipment_id}', [ShipmentController::class, 'update']);
//        Route::delete('shipments/{shipment_id}', [ShipmentController::class, 'destroy']);
//
//    Route::get('/brands', [BrandController::class, 'index']);
//    Route::get('/brands/{id}', [BrandController::class, 'show']);
//
//    Route::get('/categories', [CategoryController::class, 'index']);
//    Route::get('/categories/{category_id}', [CategoryController::class, 'show']);
//
//    Route::get('/products', [ProductController::class, 'index']);
//    Route::get('/products/{product_id}', [ProductController::class, 'show']);
//
//});
