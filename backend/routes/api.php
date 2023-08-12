<?php

use App\Controllers\V1\BookmarkController;
use App\Controllers\V1\TagController;
use App\Controllers\V1\TitleGeneratorController;
use Illuminate\Support\Facades\Route;

Route::group([
    'controller' => BookmarkController::class,
    'middleware' => 'auth:sanctum',
    'prefix' => '/v1'
], function () {
    Route::get('/bookmarks', 'index');
    Route::get('/bookmarks/{id}', 'show');
    Route::post('/bookmarks/{id}', 'update');
    Route::post('/bookmarks', 'store');
    Route::delete('/bookmarks/{id}', 'destroy');
    Route::patch('/bookmarks/{id}/visited', 'visited');
});

Route::group([
    'controller' => TagController::class,
    'middleware' => 'auth:sanctum',
    'prefix' => '/v1'
], function () {
    Route::get('/tags', 'index');
    Route::post('/tags', 'store');
    Route::delete('/tags/{id}', 'destroy');
});

Route::get('/v1/title-generator', [TitleGeneratorController::class, 'generate'])
    ->middleware('auth:sanctum');
