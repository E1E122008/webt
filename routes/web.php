<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PertanianController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\OrganizationalStructureController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PopulationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =================== Public Routes ===================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Profile Desa
Route::prefix('profile')->group(function () {
    Route::get('/visi-misi', [ProfileController::class, 'visiMisi'])->name('profile.visi-misi');
    Route::get('/struktur', [ProfileController::class, 'struktur'])->name('profile.struktur');
    Route::get('/demografi', [ProfileController::class, 'demografi'])->name('profile.demografi');
});

// Pertanian
Route::prefix('pertanian')->group(function () {
    Route::get('/komoditas', [PertanianController::class, 'komoditas'])->name('pertanian.komoditas');
});

// Lain-lain
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/potensi', [HomeController::class, 'potensi'])->name('potensi');
Route::get('/program', [HomeController::class, 'program'])->name('program');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('statistik');

// =================== Admin Routes ===================
Route::prefix('admin')->group(function () {
    // Login tetap tanpa middleware
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Semua route admin lain lewat middleware admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // News Management
        Route::get('/news', [NewsController::class, 'index'])->name('admin.news');
        Route::get('/news/create', [NewsController::class, 'create'])->name('admin.news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('/news/edit/{news}', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::put('/news/{news}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
        Route::post('/news/{news}/toggle-status', [NewsController::class, 'toggleStatus'])->name('admin.news.toggle-status');
        Route::get('/news/show/{news}', [NewsController::class, 'show'])->name('admin.news.show');


         // Population Data
         Route::get('/population', [PopulationController::class, 'index'])->name('admin.population.index');
         Route::post('/population', [PopulationController::class, 'update'])->name('admin.population.update');
         Route::post('population/import', [PopulationController::class, 'importExcel'])->name('admin.population.import');
 

        // Agricultural Data
        Route::get('/agricultural', [AdminController::class, 'agricultural'])->name('admin.agricultural');
        Route::post('/agricultural', [AdminController::class, 'updateAgricultural'])->name('admin.agricultural.update');

        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

        // Gallery
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('admin.gallery');
        Route::post('/gallery/upload', [AdminController::class, 'uploadGallery'])->name('admin.gallery.upload');
        Route::put('/gallery/{filename}/edit', [AdminController::class, 'editGalleryImage'])->name('admin.gallery.edit');
        Route::delete('/gallery/{filename}', [AdminController::class, 'deleteGalleryImage'])->name('admin.gallery.delete');

        // Enhanced Gallery (DB-backed)
        Route::resource('gallery-db', GalleryController::class, ['as' => 'admin']);
        Route::post('gallery-db/{id}/toggle-featured', [GalleryController::class, 'toggleFeatured'])->name('admin.gallery-db.toggle-featured');
        Route::post('gallery-db/{id}/toggle-published', [GalleryController::class, 'togglePublished'])->name('admin.gallery-db.toggle-published');

        // Struktur Organisasi lama
        Route::get('/structure', [AdminController::class, 'structure'])->name('admin.structure');
        Route::post('/structure', [AdminController::class, 'updateStructure'])->name('admin.structure.update');
        Route::post('/structure/kades', [AdminController::class, 'updateKades'])->name('admin.structure.kades.update');
        Route::post('/structure/entry', [AdminController::class, 'storeStructureEntry'])->name('admin.structure.entry.store');
        Route::post('/structure/entry/{id}', [AdminController::class, 'updateStructureEntry'])->name('admin.structure.entry.update');
        Route::delete('/structure/entry/{id}', [AdminController::class, 'deleteStructureEntry'])->name('admin.structure.entry.delete');

        // Struktur Organisasi (DB-backed)
        Route::resource('organizational-structure', OrganizationalStructureController::class, ['as' => 'admin']);
        Route::post('organizational-structure/{id}/toggle-status', [OrganizationalStructureController::class, 'toggleStatus'])->name('admin.organizational-structure.toggle-status');
        Route::post('organizational-structure/reorder', [OrganizationalStructureController::class, 'reorder'])->name('admin.organizational-structure.reorder');
    });
});