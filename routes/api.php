<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * AuthController
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


    
Route::middleware('auth:sanctum')->group(function() {
    
    /**
     * VisitController
     */
    Route::get('/visits', [VisitController::class, 'index']);
    Route::post('/visits', [VisitController::class, 'create']);
    Route::put('/visits/{id}', [VisitController::class, 'update']);
    Route::get('/visits/{id}', [VisitController::class, 'get']);
    Route::delete('/visits/{id}', [VisitController::class, 'destroy']);
    Route::post('/visits/{id}/visitors', [VisitController::class, 'createVisitor']);
    
});
