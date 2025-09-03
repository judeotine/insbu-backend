<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatsController;

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

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::put('/password', [AuthController::class, 'changePassword']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });

    // News routes
    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index']);
        Route::post('/', [NewsController::class, 'store']);
        Route::get('/latest', [NewsController::class, 'latest']);
        Route::get('/categories', [NewsController::class, 'categories']);
        Route::get('/statistics', [NewsController::class, 'statistics']);
        Route::get('/{news}', [NewsController::class, 'show']);
        Route::put('/{news}', [NewsController::class, 'update']);
        Route::delete('/{news}', [NewsController::class, 'destroy']);
    });

    // Document routes
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'index']);
        Route::post('/', [DocumentController::class, 'store']);
        Route::get('/recent', [DocumentController::class, 'recent']);
        Route::get('/popular', [DocumentController::class, 'popular']);
        Route::get('/categories', [DocumentController::class, 'categories']);
        Route::get('/statistics', [DocumentController::class, 'statistics']);
        Route::get('/{document}', [DocumentController::class, 'show']);
        Route::put('/{document}', [DocumentController::class, 'update']);
        Route::delete('/{document}', [DocumentController::class, 'destroy']);
        Route::get('/{document}/download', [DocumentController::class, 'download']);
    });

    // Statistics routes
    Route::prefix('stats')->group(function () {
        Route::get('/dashboard', [StatsController::class, 'dashboard']);
        Route::get('/users', [StatsController::class, 'users']);
        Route::get('/news', [StatsController::class, 'news']);
        Route::get('/documents', [StatsController::class, 'documents']);
        Route::get('/monthly-activity', [StatsController::class, 'monthlyActivity']);
        Route::get('/role-distribution', [StatsController::class, 'roleDistribution']);
    });

    // Admin routes (admin access only)
    Route::prefix('admin')->group(function () {
        // User management
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::get('/users/{user}', [AdminController::class, 'getUser']);
        Route::put('/users/{user}', [AdminController::class, 'updateUser']);
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole']);
        Route::put('/users/{user}/status', [AdminController::class, 'toggleUserStatus']);
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
        
        // System management
        Route::get('/roles', [AdminController::class, 'getRoles']);
        Route::get('/statistics', [AdminController::class, 'getStatistics']);
        Route::get('/logs', [AdminController::class, 'getSystemLogs']);
        Route::get('/user-activity', [AdminController::class, 'getUserActivity']);
    });
});

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0',
    ]);
});
