<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\ApiTokenMiddleware;
use App\Http\Controllers\Api\HPQController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PartnerController;

Route::post('/auth/token', [AuthController::class, 'issueToken']);
Route::post('/auth/refresh', [AuthController::class, 'refreshToken']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware([ApiTokenMiddleware::class])->group(function () {
    //Articles
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{slug}', [ArticleController::class, 'show']);
    //Events
    Route::get('/events', [EventController::class, 'index']);
    //Hpq
    Route::get('/hpqs', [HPQController::class, 'index']);
    Route::get('/hpqs/{code_hpq}', [HPQController::class, 'show']);
    Route::post('/hpqs/insert', [HPQController::class, 'store']);
    //Partners
    Route::get('/partners', [PartnerController::class, 'index']);
});
