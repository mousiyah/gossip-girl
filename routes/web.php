<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;
use App\Livewire\UserProfile;
use App\Livewire\Users;

Route::get('/', Dashboard::class)->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:manage-users')->group(function () {
        Route::get('/users', Users::class)->name('users');
    });
});

require __DIR__.'/auth.php';
