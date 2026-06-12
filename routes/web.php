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
    Route::resource('product-categories', \App\Http\Controllers\Admin\ProductCategoryController::class);
    Route::post('products/{product}/remove-gallery-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
    Route::post('product-categories/update-order', [\App\Http\Controllers\Admin\ProductCategoryController::class, 'updateOrder'])->name('product-categories.update-order');
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

    // Mission & Vision management (now using content_management system)
    Route::get('/mission-vision', [\App\Http\Controllers\Admin\MissionVisionController::class, 'index'])->name('mission-vision.index');
    Route::put('/mission-vision', [\App\Http\Controllers\Admin\MissionVisionController::class, 'update'])->name('mission-vision.update');

    // Core Values Routes
    Route::get('/core-values', [\App\Http\Controllers\Admin\CoreValuesController::class, 'index'])->name('core-values.index');
    Route::put('/core-values', [\App\Http\Controllers\Admin\CoreValuesController::class, 'update'])->name('core-values.update');

    // Partners Routes
    Route::get('/partners', [\App\Http\Controllers\Admin\PartnersController::class, 'index'])->name('partners.index');
    Route::put('/partners', [\App\Http\Controllers\Admin\PartnersController::class, 'update'])->name('partners.update');

    // Contact CTA Routes
    Route::get('/contact-cta', [\App\Http\Controllers\Admin\ContactCtaController::class, 'index'])->name('contact-cta.index');
    Route::put('/contact-cta', [\App\Http\Controllers\Admin\ContactCtaController::class, 'update'])->name('contact-cta.update');

    // Career CTA Routes
    Route::get('/career-cta', [\App\Http\Controllers\Admin\CareerCtaController::class, 'index'])->name('career-cta-section.index');
    Route::put('/career-cta', [\App\Http\Controllers\Admin\CareerCtaController::class, 'update'])->name('career-cta-section.update');

    // CMS Section Routes
    Route::prefix('cms-section')->name('cms-section.')->group(function () {
        Route::get('/home-hero-section', [\App\Http\Controllers\Admin\HeroController::class, 'index'])->name('home-hero-section');
        Route::put('/home-hero-section', [\App\Http\Controllers\Admin\HeroController::class, 'update'])->name('home-hero-section.update');
        Route::get('/contact-section', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact-section');
        Route::put('/contact-section', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contact-section.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
