<?php

use App\Http\Controllers\Api\V1\FirebaseToken\FirebaseTokenController;
use App\Http\Controllers\Api\V1\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/v1/auth/auth.php';         // Auth routes
require __DIR__ . '/v1/cms/cms.php';           // CMS routes
require __DIR__ . '/v1/settings/settings.php'; // Settings routes

//! V1 API Routes (Authenticated)
Route::middleware('auth:api')->prefix('v1')->group(function () {
    // ! Notifications API Endpoints
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'getNotification']);
        Route::post('/read', [NotificationController::class, 'markAsRead']);
        Route::post('/read-all', [NotificationController::class, 'AllNotificationMarkAsRead']);
        Route::post('/bulk-delete', [NotificationController::class, 'bulkDelete']);
        Route::delete('/delete-all', [NotificationController::class, 'deleteAll']);
        Route::delete('/{id}', [NotificationController::class, 'deleteNotification']);
    });
});

// ! Firebase Token
Route::prefix('v1/firebase-token')->middleware('auth:api')->group(function () {
    Route::post('add', [FirebaseTokenController::class, 'store']);
    Route::post('get', [FirebaseTokenController::class, 'getToken']);
    Route::post('delete', [FirebaseTokenController::class, 'deleteToken']);
});
