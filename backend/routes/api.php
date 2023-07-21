<?php

use App\Controllers\V1\BookmarkController;
use App\Controllers\V1\TagController;
use Illuminate\Support\Facades\Route;

Route::controller(BookmarkController::class)->middleware('auth:sanctum')->prefix('/v1')
    ->group(function () {
        Route::get('/bookmarks', 'index');
        Route::get('/bookmarks/{id}', 'show');
        Route::post('/bookmarks/{id}', 'update');
        Route::post('/bookmarks', 'store');
        Route::delete('/bookmarks/{id}', 'destroy');
        Route::patch('/bookmarks/{id}/visited', 'visited');
    });

Route::controller(TagController::class)->middleware('auth:sanctum')->prefix('/v1')
    ->group(function () {
//        Route::get('/bookmarks', 'index');
    });
