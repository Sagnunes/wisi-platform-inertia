<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['can:manage,App\Models\Status'])->group(function () {
    Route::resource('statuses', StatusController::class)->middleware(['auth', 'verified'])->except(['edit', 'create']);
    Route::get('statuses/{status:slug}/edit', [StatusController::class, 'edit'])->middleware(['auth', 'verified'])->name('statuses.edit');
});

Route::resource('roles', RoleController::class)->middleware(['auth', 'verified'])->except(['edit', 'create']);
Route::get('roles/{role:slug}/edit', [RoleController::class, 'edit'])->middleware(['auth', 'verified'])->name('roles.edit');

Route::resource('permissions', PermissionController::class)->middleware(['auth', 'verified'])->except(['edit', 'create']);
Route::get('permissions/{permission:slug}/edit', [PermissionController::class, 'edit'])->middleware(['auth', 'verified'])->name('permission.edit');

Route::get('role/{role:slug}/permission/edit', [RolePermissionController::class, 'edit'])->middleware(['auth', 'verified'])->name('role_permission.edit');
Route::put('role/{role:id}/permission', [RolePermissionController::class, 'update'])->middleware(['auth', 'verified'])->name('role_permission.update');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
