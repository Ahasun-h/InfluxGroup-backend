<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('jobs', \App\Http\Controllers\Admin\JobOpeningController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Hero section management (now using content_management system)
    Route::get('hero', [\App\Http\Controllers\Admin\HeroController::class, 'index'])->name('hero.index');
    Route::put('hero', [\App\Http\Controllers\Admin\HeroController::class, 'update'])->name('hero.update');

    // Brand statements management (now using content_management system)
    Route::get('brand-statements', [\App\Http\Controllers\Admin\BrandStatementController::class, 'index'])->name('brand-statements.index');
    Route::put('brand-statements', [\App\Http\Controllers\Admin\BrandStatementController::class, 'update'])->name('brand-statements.update');

    // Journey timeline management (now using content_management system)
    Route::get('journey', [\App\Http\Controllers\Admin\JourneyController::class, 'index'])->name('journey.index');
    Route::put('journey', [\App\Http\Controllers\Admin\JourneyController::class, 'update'])->name('journey.update');

    // New Site Sections Management (Content Management Table)
    Route::prefix('site-sections')->name('site-sections.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SiteSectionController::class, 'index'])->name('index');
        Route::get('/{sectionKey}/edit', [\App\Http\Controllers\Admin\SiteSectionController::class, 'edit'])->name('edit');
        Route::put('/{sectionKey}', [\App\Http\Controllers\Admin\SiteSectionController::class, 'update'])->name('update');
        Route::post('/{sectionKey}/toggle', [\App\Http\Controllers\Admin\SiteSectionController::class, 'toggleStatus'])->name('toggle');
    });

    // Homepage content management
    Route::get('homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'index'])->name('homepage.index');
    Route::post('homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('homepage.update');
    Route::get('homepage/preview', [\App\Http\Controllers\Admin\HomepageController::class, 'preview'])->name('homepage.preview');

    // Homepage items management
    Route::prefix('homepage')->name('homepage.')->group(function () {
        // Services
        Route::get('services', [\App\Http\Controllers\Admin\HomepageController::class, 'getServices'])->name('services');
        Route::post('services', [\App\Http\Controllers\Admin\HomepageController::class, 'storeService'])->name('services.store');
        Route::delete('services/{id}', [\App\Http\Controllers\Admin\HomepageController::class, 'deleteService'])->name('services.delete');

        // Projects
        Route::get('projects', [\App\Http\Controllers\Admin\HomepageController::class, 'getProjects'])->name('projects');
        Route::post('projects', [\App\Http\Controllers\Admin\HomepageController::class, 'storeProject'])->name('projects.store');
        Route::delete('projects/{id}', [\App\Http\Controllers\Admin\HomepageController::class, 'deleteProject'])->name('projects.delete');
        Route::post('projects/{id}/toggle-featured', [\App\Http\Controllers\Admin\HomepageController::class, 'toggleProjectFeatured'])->name('projects.toggle-featured');

        // Testimonials
        Route::get('testimonials', [\App\Http\Controllers\Admin\HomepageController::class, 'getTestimonials'])->name('testimonials');
        Route::post('testimonials', [\App\Http\Controllers\Admin\HomepageController::class, 'storeTestimonial'])->name('testimonials.store');
        Route::delete('testimonials/{id}', [\App\Http\Controllers\Admin\HomepageController::class, 'deleteTestimonial'])->name('testimonials.delete');
        Route::post('testimonials/{id}/toggle-featured', [\App\Http\Controllers\Admin\HomepageController::class, 'toggleTestimonialFeatured'])->name('testimonials.toggle-featured');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
