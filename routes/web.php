<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProfileController;

// ---------- Auth (web session) ----------
Route::get('/login',    [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login',   [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register',[AuthController::class, 'register'])->name('register.attempt')->middleware('guest');

Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---------- Profile ----------

// ---------- Dashboard ----------
Route::get('/', DashboardController::class)->name('dashboard')->middleware('auth');

// ---------- Admin Panel (web) ----------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Roles
    Route::get('/roles',                [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create',         [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles',               [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit',    [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}',         [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}',      [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::post('/roles/{role}/sync-permissions', [RoleController::class, 'syncPermissions'])->name('roles.sync-permissions');

    // Permissions
    Route::get('/permissions',                [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create',         [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions',               [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}',   [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}',[PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Users
    Route::get('/users',               [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit',   [UserManagementController::class, 'edit'])->name('users.edit');
    Route::post('/users/{user}/sync-roles',        [UserManagementController::class, 'syncRoles'])->name('users.sync-roles');
    Route::post('/users/{user}/sync-permissions',  [UserManagementController::class, 'syncPermissions'])->name('users.sync-permissions');
});
