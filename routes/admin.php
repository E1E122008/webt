<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PopulationController;
use App\Http\Controllers\Admin\AgriculturalController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');

    // News Management
    Route::resource('news', NewsController::class);
    Route::patch('news/{news}/toggle-status', [NewsController::class, 'toggleStatus'])->name('news.toggle-status');

    // Population Data Management
    Route::resource('population', PopulationController::class);
    Route::post('population/import-excel', [PopulationController::class, 'importExcel'])->name('population.import-excel');
    Route::post('population/import-csv', [PopulationController::class, 'importCsv'])->name('population.import-csv');
    
    // Alternative route names for compatibility
    Route::post('population/import', [PopulationController::class, 'importExcel'])->name('population.import');

    // Agricultural Data Management
    Route::resource('agricultural', AgriculturalController::class);

    // User Management (Super Admin only)
    Route::middleware('super_admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
