<?php

use App\Http\Controllers\CarreirasController;
use App\Http\Controllers\CartasController;
use App\Http\Controllers\HistoricosController;
use App\Http\Controllers\SituacoesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Route::apiResource('cartas',    CartasController::class);
Route::apiResource('carreiras', CarreirasController::class);
Route::apiResource('historicos', HistoricosController::class);
Route::apiResource('situacoes', SituacoesController::class);
Route::apiResource('users', UsersController::class);