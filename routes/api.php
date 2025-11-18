<?php

use App\Http\Controllers\CarreirasController;
use App\Http\Controllers\CartasController;
use App\Http\Controllers\HistoricosController;
use App\Http\Controllers\SituacoesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


// Public read-only endpoints
Route::apiResource('cartas',    CartasController::class)->only(['index','show']);
Route::apiResource('carreiras', CarreirasController::class)->only(['index','show']);
Route::apiResource('historicos', HistoricosController::class)->only(['index','show']);
Route::apiResource('situacoes', SituacoesController::class)->only(['index','show']);

// Authentication endpoints for SPA (sanctum cookie flow)
Route::post('login', [App\Http\Controllers\ApiAuthController::class, 'login']);
Route::post('logout', [App\Http\Controllers\ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [App\Http\Controllers\ApiAuthController::class, 'user'])->middleware('auth:sanctum');

// Protected write endpoints
Route::middleware('auth:sanctum')->group(function () {
	Route::apiResource('cartas',    CartasController::class)->only(['store','update','destroy']);
	Route::apiResource('carreiras', CarreirasController::class)->only(['store','update','destroy']);
	Route::apiResource('historicos', HistoricosController::class)->only(['store','update','destroy']);
	Route::apiResource('situacoes', SituacoesController::class)->only(['store','update','destroy']);
	Route::apiResource('users', UsersController::class)->only(['store','update','destroy']);
});