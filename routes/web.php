<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceAndSolutionController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CareersController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SubscriptionSectionController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductsPageController;
use App\Http\Controllers\Admin\ProjectsPageController;
use App\Http\Controllers\Admin\ServicesPageController;
use App\Http\Controllers\Admin\NewsPageController;
use App\Http\Controllers\Admin\CareerPageController;

Route::get('/', function () {
    return view('welcome');
}); 

// Storage link creation routes - runs php artisan storage:link command
Route::get('/storage-files', [StorageController::class, 'createLink'])->name('storage.link');
Route::get('/storage-link', [StorageController::class, 'createLink'])->name('storage.create');

// Storage file serving route - serves files when nginx doesn't follow symlinks
Route::get('/storage-files/{folder}/{filename}', [StorageController::class, 'serve'])
    ->where('filename', '.*')
    ->name('storage.serve');

// Admin route for storage link creation
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('storage-link', [StorageController::class, 'createLink'])->name('storage.link.run');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Analytics management
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/website', [AnalyticsController::class, 'website'])->name('analytics.website');
    Route::get('analytics/business', [AnalyticsController::class, 'business'])->name('analytics.business');
    Route::get('analytics/content', [AnalyticsController::class, 'content'])->name('analytics.content');
    Route::get('analytics/api/chart-data', [AnalyticsController::class, 'apiChartData'])->name('analytics.api.chart-data');

    Route::resource('categories', CategoryController::class);
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');

    // Legacy redirects for backward compatibility
    Route::redirect('product-categories', 'categories?area=product');
    Route::redirect('project-categories', 'categories?area=project');

    Route::resource('products', ProductController::class);
    Route::post('products/{product}/remove-gallery-image', [ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
    Route::post('products/{product}/remove-brochure', [ProductController::class, 'removeBrochure'])->name('products.remove-brochure');
    Route::post('products/{product}/remove-image', [ProductController::class, 'removeImage'])->name('products.remove-image');
    Route::resource('projects', ProjectController::class);
    Route::resource('services-and-solutions', ServiceAndSolutionController::class)->parameters(['services-and-solutions' => 'item']);
    Route::post('services-and-solutions/{item}/remove-gallery-image', [ServiceAndSolutionController::class, 'removeGalleryImage'])->name('services-and-solutions.remove-gallery-image');
    Route::post('services-and-solutions/{item}/remove-image', [ServiceAndSolutionController::class, 'removeImage'])->name('services-and-solutions.remove-image');
    Route::resource('news', NewsController::class);
    Route::post('news/{news}/remove-gallery-image', [NewsController::class, 'removeGalleryImage'])->name('news.remove-gallery-image');
    Route::post('news/{news}/remove-image', [NewsController::class, 'removeImage'])->name('news.remove-image');
    Route::post('news/upload-trix-image', [NewsController::class, 'uploadTrixImage'])->name('news.upload-trix-image');
    Route::resource('pages', PageController::class);

    // Career Opportunities management (user-friendly URL)
    Route::resource('careers', CareersController::class)->parameters([
        'careers' => 'career'
    ]);
    Route::post('careers/update-order', [CareersController::class, 'updateOrder'])->name('careers.update-order');
    Route::post('careers/{career}/toggle-status', [CareersController::class, 'toggleStatus'])->name('careers.toggle-status');
    Route::post('careers/{career}/restore', [CareersController::class, 'restore'])->name('careers.restore');
    Route::get('careers-debug', [CareersController::class, 'debug'])->name('careers.debug');

    // Test routes for debugging (remove after fixing)
    Route::get('test-career-update/{id?}', function($id = 2) {
        $job = \App\Models\CareerOpportunitie::find($id);
        if (!$job) {
            return redirect('/admin/careers')->with('error', 'Job not found');
        }
        return view('simple_test_update', ['job' => $job]);
    })->name('test.career.update');

    // Quotations management
    Route::resource('quotations', QuotationController::class);
    Route::post('quotations/{quotation}/status', [QuotationController::class, 'updateStatus'])->name('quotations.update-status');
    Route::get('quotations/{quotation}/pdf', [QuotationController::class, 'generatePDF'])->name('quotations.pdf');
    Route::post('quotations/{quotation}/duplicate', [QuotationController::class, 'duplicate'])->name('quotations.duplicate');

    // Quote Requests management
    Route::resource('quote-requests', QuoteRequestController::class)->only(['index', 'show', 'destroy']);
    Route::get('quote-requests/{quoteRequest}/convert', [QuoteRequestController::class, 'convert'])->name('quote-requests.convert');
    Route::post('quote-requests/{quoteRequest}/convert', [QuoteRequestController::class, 'storeQuotation'])->name('quote-requests.store-quotation');
    Route::put('quote-requests/{quoteRequest}/status', [QuoteRequestController::class, 'updateStatus'])->name('quote-requests.update-status');

    // Leads management
    Route::resource('leads', LeadsController::class)->only(['index', 'show', 'update', 'destroy']);

    // Customers management (CRM)
    Route::resource('customers', CustomersController::class);
    Route::post('customers/{customer}/interactions', [CustomersController::class, 'addInteraction'])->name('customers.add-interaction');
    Route::post('leads/{lead}/convert-to-customer', [CustomersController::class, 'convertLead'])->name('leads.convert-to-customer');

    // Settings management
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/delete-logo', [SettingsController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::post('settings/delete-logo-dark', [SettingsController::class, 'deleteLogoDark'])->name('settings.delete-logo-dark');
    Route::post('settings/delete-favicon', [SettingsController::class, 'deleteFavicon'])->name('settings.delete-favicon');

    // Testimonials Routes
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::put('/testimonials', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{id}', [TestimonialController::class, 'updateTestimonial'])->name('testimonials.update-testimonial');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Footer Routes - Redirect to settings (merged functionality)
    Route::redirect('/footer', '/settings', 301)->name('footer.index');

    // CMS Section Routes
    Route::prefix('cms-section')->name('cms-section.')->group(function () {
        Route::get('/home-page', [HomePageController::class, 'index'])->name('home-page');
        Route::put('/home-page/{section}', [HomePageController::class, 'update'])->name('home-page.update');
        Route::get('/about-page', [AboutPageController::class, 'index'])->name('about-page');
        Route::put('/about-page/{section}', [AboutPageController::class, 'update'])->name('about-page.update');
        Route::get('/contact-section', [ContactController::class, 'index'])->name('contact-section');
        Route::put('/contact-section', [ContactController::class, 'update'])->name('contact-section.update');
        Route::post('/contact-section/{section}', [ContactController::class, 'updateSection'])->name('contact-section.update-section');
        Route::put('/contact-section/{section}', [ContactController::class, 'updateSection'])->name('contact-section.update-section-put');
        Route::get('/products-page', [ProductsPageController::class, 'index'])->name('products-page');
        Route::post('/products-page/{section}', [ProductsPageController::class, 'update'])->name('products-page.update');
        Route::get('/projects-page', [ProjectsPageController::class, 'index'])->name('projects-page');
        Route::post('/projects-page/{section}', [ProjectsPageController::class, 'update'])->name('projects-page.update');
        Route::get('/services-page', [ServicesPageController::class, 'index'])->name('services-page');
        Route::post('/services-page/{section}', [ServicesPageController::class, 'update'])->name('services-page.update');
        Route::get('/news-page', [NewsPageController::class, 'index'])->name('news-page');
        Route::post('/news-page/{section}', [NewsPageController::class, 'update'])->name('news-page.update');
        Route::get('/career-page', [CareerPageController::class, 'index'])->name('career-page');
        Route::post('/career-page/{section}', [CareerPageController::class, 'update'])->name('career-page.update');
    });


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
