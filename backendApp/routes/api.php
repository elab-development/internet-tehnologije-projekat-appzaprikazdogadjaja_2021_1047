<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReferenceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{id}', [EventController::class, 'show']);

Route::post('/categories', [CategoryController::class, 'store']);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/locations', [LocationController::class, 'index']);

Route::get('/locations/{id}', [LocationController::class, 'show']);

Route::post('/locations', [LocationController::class, 'store']);

Route::put('/locations/{id}', [LocationController::class, 'update']);

Route::delete('/locations/{id}', [LocationController::class, 'destroy']);

Route::get('/roles', [RoleController::class, 'index']);

Route::get('/roles/{id}', [RoleController::class, 'show']);

Route::post('/roles', [RoleController::class, 'store']);

Route::put('/roles/{id}', [RoleController::class, 'update']);

Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

Route::get('/events', [EventController::class, 'index']);

Route::get('/events/search', [EventController::class, 'search']); 

Route::post('/events', [EventController::class, 'store']);

Route::put('/events/{id}', [EventController::class, 'update']);

Route::delete('/events/{id}', [EventController::class, 'destroy']);

Route::get('/events/{id}', [EventController::class, 'show']);





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


