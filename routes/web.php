<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/update-order', [\App\Http\Controllers\Admin\CategoryController::class, 'updateOrder'])->name('categories.update-order');

    // Legacy redirects for backward compatibility
    Route::redirect('product-categories', 'categories?area=product');
    Route::redirect('project-categories', 'categories?area=project');

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/{product}/remove-gallery-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
    Route::post('products/{product}/remove-brochure', [\App\Http\Controllers\Admin\ProductController::class, 'removeBrochure'])->name('products.remove-brochure');
    Route::post('products/{product}/remove-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('products.remove-image');
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('services-and-solutions', \App\Http\Controllers\Admin\ServiceAndSolutionController::class)->parameters(['services-and-solutions' => 'item']);
    Route::post('services-and-solutions/{item}/remove-gallery-image', [\App\Http\Controllers\Admin\ServiceAndSolutionController::class, 'removeGalleryImage'])->name('services-and-solutions.remove-gallery-image');
    Route::post('services-and-solutions/{item}/remove-image', [\App\Http\Controllers\Admin\ServiceAndSolutionController::class, 'removeImage'])->name('services-and-solutions.remove-image');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::post('news/{news}/remove-gallery-image', [\App\Http\Controllers\Admin\NewsController::class, 'removeGalleryImage'])->name('news.remove-gallery-image');
    Route::post('news/{news}/remove-image', [\App\Http\Controllers\Admin\NewsController::class, 'removeImage'])->name('news.remove-image');
    Route::post('news/upload-trix-image', [\App\Http\Controllers\Admin\NewsController::class, 'uploadTrixImage'])->name('news.upload-trix-image');
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Quotations management
    Route::resource('quotations', \App\Http\Controllers\Admin\QuotationController::class);
    Route::post('quotations/{quotation}/status', [\App\Http\Controllers\Admin\QuotationController::class, 'updateStatus'])->name('quotations.update-status');
    Route::get('quotations/{quotation}/pdf', [\App\Http\Controllers\Admin\QuotationController::class, 'generatePDF'])->name('quotations.pdf');
    Route::post('quotations/{quotation}/duplicate', [\App\Http\Controllers\Admin\QuotationController::class, 'duplicate'])->name('quotations.duplicate');

    // Quote Requests management
    Route::resource('quote-requests', \App\Http\Controllers\Admin\QuoteRequestController::class)->only(['index', 'show', 'destroy']);
    Route::get('quote-requests/{quoteRequest}/convert', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'convert'])->name('quote-requests.convert');
    Route::post('quote-requests/{quoteRequest}/convert', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'storeQuotation'])->name('quote-requests.store-quotation');
    Route::put('quote-requests/{quoteRequest}/status', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'updateStatus'])->name('quote-requests.update-status');

    // Settings management
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/delete-logo', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::post('settings/delete-favicon', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteFavicon'])->name('settings.delete-favicon');

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

    // Testimonials Routes
    Route::get('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::put('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('testimonials.update');
    Route::post('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{id}', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateTestimonial'])->name('testimonials.update-testimonial');
    Route::delete('/testimonials/{id}', [\App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('testimonials.destroy');

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
