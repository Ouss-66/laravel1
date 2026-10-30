<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/geheim', function () {
        return view('geheim');
    });
});

// Zowel ingelogde klanten als admins mogen de overzichtspagina en details bekijken
Route::middleware(['auth'])->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/show/{id}', [GameController::class, 'show'])->name('games.show');
});

// ALLEEN ingelogde ADMINS mogen games toevoegen, bewerken en verwijderen
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games/store', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/edit/{id}', [GameController::class, 'edit'])->name('games.edit');
    Route::post('/games/update/{id}', [GameController::class, 'update'])->name('games.update');
    Route::post('/games/destroy/{id}', [GameController::class, 'destroy'])->name('games.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
    Route::put('roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');
    Route::get('user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');
    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
});

require __DIR__.'/auth.php';
