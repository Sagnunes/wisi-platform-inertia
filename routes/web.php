<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('statuses', StatusController::class)->middleware(['auth', 'verified'])->except('edit');
Route::get('statuses/{status:slug}/edit', [StatusController::class, 'edit'])->middleware(['auth', 'verified'])->name('statuses.edit');

Route::resource('roles', RoleController::class)->middleware(['auth', 'verified'])->except('edit');
Route::get('roles/{role:slug}/edit', [RoleController::class, 'edit'])->middleware(['auth', 'verified'])->name('roles.edit');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
