<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiWargaController;
use App\Http\Controllers\ClusteringController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('warga', WargaController::class);
    Route::resource('kriteria', KriteriaController::class)->only(['index', 'edit', 'update']);

    Route::get('nilai', [NilaiWargaController::class, 'index'])->name('nilai.index');
    Route::get('nilai/{warga}/edit', [NilaiWargaController::class, 'edit'])->name('nilai.edit');
    Route::put('nilai/{warga}', [NilaiWargaController::class, 'update'])->name('nilai.update');

    Route::get('clustering', [ClusteringController::class, 'index'])->name('clustering.index');
    Route::post('clustering/run', [ClusteringController::class, 'run'])->name('clustering.run');
    Route::get('clustering/history', [ClusteringController::class, 'history'])->name('clustering.history');
    Route::get('clustering/history/{run}', [ClusteringController::class, 'showRun'])->name('clustering.show');
    Route::get('clustering/silhouette', [ClusteringController::class, 'silhouetteComparison'])->name('clustering.silhouette');
    Route::post('clustering/silhouette/process', [ClusteringController::class, 'processSilhouetteComparison'])->name('clustering.silhouette.process');

    // User Management
    Route::resource('user', UserController::class);

    // Profile Management
    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil', [ProfileController::class, 'update'])->name('profile.update');
});
