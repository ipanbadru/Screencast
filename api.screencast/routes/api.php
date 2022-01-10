<?php

use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Order\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Screencast\MyPlaylistController;
use App\Http\Controllers\Screencast\PlaylistController;
use App\Http\Controllers\Screencast\VideoController;
use App\Http\Controllers\Screencast\CheckIfUserHasBoughtSeriesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', MeController::class);
    Route::get('/playlists/mine', MyPlaylistController::class);

    Route::get('carts', [CartController::class, 'index']);
    Route::post('add-to-cart/{playlist:slug}', [CartController::class, 'store']);
    Route::delete('remove-cart/{cart}', [CartController::class, 'destroy']);

    Route::post('orders/create', [OrderController::class, 'store']);

    Route::get('check-if-user-has-bought-the-series-{playlist:slug}', CheckIfUserHasBoughtSeriesController::class);
});

Route::post('notification-handler', [OrderController::class, 'notificationHandler']);

Route::prefix('playlists')->group(function() {
    Route::get('', [PlaylistController::class, 'index']);
    Route::get('{playlist:slug}', [PlaylistController::class, 'show']);

    Route::get('{playlist:slug}/videos', [VideoController::class, 'index']);
    Route::get('{playlist:slug}/{video:episode}', [VideoController::class, 'show'])->middleware('auth:sanctum');
});

