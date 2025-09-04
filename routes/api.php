<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ResourceController;

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
        Route::get('/latest', [NewsController::class, 'latest']);
        Route::get('/categories', [NewsController::class, 'categories']);
        Route::get('/statistics', [NewsController::class, 'statistics']);
        Route::get('/{news}', [NewsController::class, 'show']);
        
        // Editor and Admin can create, edit, delete
        Route::middleware('role:admin,editor')->group(function () {
            Route::post('/', [NewsController::class, 'store']);
            Route::put('/{news}', [NewsController::class, 'update']);
            Route::delete('/{news}', [NewsController::class, 'destroy']);
        });
    });

    // Document routes
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'index']);
        Route::get('/recent', [DocumentController::class, 'recent']);
        Route::get('/popular', [DocumentController::class, 'popular']);
        Route::get('/categories', [DocumentController::class, 'categories']);
        Route::get('/statistics', [DocumentController::class, 'statistics']);
        Route::get('/{document}', [DocumentController::class, 'show']);
        Route::get('/{document}/download', [DocumentController::class, 'download']);
        
        // Editor and Admin can upload, edit, delete documents
        Route::middleware('role:admin,editor')->group(function () {
            Route::post('/', [DocumentController::class, 'store']);
            Route::put('/{document}', [DocumentController::class, 'update']);
            Route::delete('/{document}', [DocumentController::class, 'destroy']);
        });
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

    // Resource routes
    Route::prefix('resources')->group(function () {
        Route::get('/', [ResourceController::class, 'index']);
        Route::get('/categories', [ResourceController::class, 'categories']);
        Route::get('/{resource}', [ResourceController::class, 'show']);
        
        // Admin only routes for resource management
        Route::middleware('role:admin')->group(function () {
            Route::post('/', [ResourceController::class, 'store']);
            Route::put('/{resource}', [ResourceController::class, 'update']);
            Route::delete('/{resource}', [ResourceController::class, 'destroy']);
        });
    });

    // Admin routes (admin access only)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // User management
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::get('/users/{user}', [AdminController::class, 'getUser']);
        Route::put('/users/{user}', [AdminController::class, 'updateUser']);
        Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole']);
        Route::put('/users/{user}/status', [AdminController::class, 'toggleUserStatus']);
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
        
        // Article management
        Route::get('/articles', [AdminController::class, 'getArticles']);
        Route::patch('/articles/{news}/approve', [AdminController::class, 'approveArticle']);
        Route::patch('/articles/{news}/reject', [AdminController::class, 'rejectArticle']);
        
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
