<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EvaluationController;
use App\Models\Evaluation;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
// Aquí irán las rutas protegidas (cursos, categorías, etc.)
});

// Register
Route::middleware(['auth:sanctum', 'role:admin'])->post('/register', [AuthController::class, 'register']);

// Courses
Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
    Route::apiResource('courses', CategoryController::class);
});

// Lo protegemos para que solo usuarios con rol admin puedan gestionarlas.
Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
    Route::apiResource('categories', CategoryController::class);
});


// Enrollments
// EL estuduante sólo puede ver sus incripciones y hacer nuevas incripciones.
Route::middleware(['auth:sanctum', 'role:student'])->group(function ()
{
    Route::apiResource('enrollments', CategoryController::class)->only('index', 'store');
});


// Evaluation
Route::middleware(['auth:sanctum', 'role:student'])->group(function ()
{
    Route::apiResource('evaluations', EvaluationController::class)->only( 'store', 'update', 'destroy');
});

// Para ver evaluaciones de un estuduante:
Route::middleware(['auth:sanctum',''])->get('/evaluations/student/{id}', [EvaluationController::class, 'byStudent']);



