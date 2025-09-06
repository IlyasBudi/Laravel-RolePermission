<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\UserRoleController;

// ========== AUTH ==========
Route::post('/register', [AuthController::class, 'register']);     // publik
Route::post('/login', [AuthController::class, 'login']);           // publik

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ========== ADMIN PANEL (JSON) ==========
    // Batasi akses dengan role/permission:
    Route::middleware(['role:superadmin|admin'])->group(function () {
        // Roles
        Route::get('/admin/roles', [RoleController::class, 'index']);
        Route::post('/admin/roles', [RoleController::class, 'store']);
        Route::put('/admin/roles/{role}', [RoleController::class, 'update']);
        Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy']);
        Route::post('/admin/roles/{role}/sync-permissions', [RoleController::class, 'syncPermissions']);

        // Permissions
        Route::get('/admin/permissions', [PermissionController::class, 'index']);
        Route::post('/admin/permissions', [PermissionController::class, 'store']);
        Route::put('/admin/permissions/{permission}', [PermissionController::class, 'update']);
        Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy']);

        // User <-> Role/Permission
        Route::get('/admin/users/{user}/roles', [UserRoleController::class, 'getUserRoles']);
        Route::post('/admin/users/{user}/sync-roles', [UserRoleController::class, 'syncRoles']);
        Route::post('/admin/users/{user}/give-permissions', [UserRoleController::class, 'givePermissions']);
        Route::post('/admin/users/{user}/revoke-permissions', [UserRoleController::class, 'revokePermissions']);
    });
});
