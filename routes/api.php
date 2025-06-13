<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
// Aquí irán las rutas protegidas (cursos, categorías, etc.)

// Lo protegemos para que solo usuarios con rol admin puedan gestionarlas.
Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
    Route::apiResource('categories', CategoryController::class);
});
