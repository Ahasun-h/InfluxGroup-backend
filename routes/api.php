<?php

use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\PagesCmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Endpoints
Route::prefix('products')->group(function () {
    Route::get('/', [ContentController::class, 'getProducts']);
    Route::get('/featured', [ContentController::class, 'getFeaturedProducts']);
    Route::get('/categories', [ContentController::class, 'getProductCategories']);
    Route::get('/categories-list', [ContentController::class, 'getProductCategoriesForHomepage']);
    Route::get('/{product:slug}', [ContentController::class, 'getProduct']);
});

Route::prefix('projects')->group(function () {
    Route::get('/', [ContentController::class, 'getProjects']);
    Route::get('/categories', [ContentController::class, 'getProjectCategories']);
    Route::get('/featured', [ContentController::class, 'getFeaturedProjects']);
    Route::get('/{project:slug}', [ContentController::class, 'getProject']);
});

Route::prefix('services')->group(function () {
    Route::get('/', [ContentController::class, 'getServices']);
    Route::get('/latest', [ContentController::class, 'getLatestServices']);
    Route::get('/{service:slug}', [ContentController::class, 'getService']);
});

Route::prefix('solutions')->group(function () {
    Route::get('/', [ContentController::class, 'getSolutions']);
    Route::get('/latest', [ContentController::class, 'getLatestSolutions']);
    Route::get('/{solution:slug}', [ContentController::class, 'getSolution']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [ContentController::class, 'getNews']);
    Route::get('/categories', [ContentController::class, 'getNewsCategories']);
    Route::get('/featured', [ContentController::class, 'getFeaturedNews']);
    Route::get('/{news:slug}', [ContentController::class, 'getNewsArticle']);
});

Route::get('/content/company-info', [ContentController::class, 'getCompanyInfo']);

// Quote requests (public API)
Route::post('quote-requests/submit', [\App\Http\Controllers\Api\QuoteRequestController::class, 'submit']);

// Contact form (public API)
Route::post('contact/submit', [\App\Http\Controllers\Api\ContactController::class, 'submit']);

Route::prefix('pages')->group(function () {
    Route::get('/', [ContentController::class, 'getPages']);
    Route::get('/{slug}', [ContentController::class, 'getPageBySlug']);
});

// Careers API
Route::prefix('careers')->group(function () {
    Route::get('/jobs', [ContentController::class, 'getCareers']);
});

// CMS Section APIs
Route::prefix('cms')->group(function () {
    // Hero Section
    Route::get('/hero', [ContentController::class, 'getHeroSection']);

    // Brand Statements
    Route::get('/brand-statements', [ContentController::class, 'getBrandStatements']);

    // Journey Timeline
    Route::get('/journey', [ContentController::class, 'getJourneyTimeline']);

    // Mission & Vision
    Route::get('/mission-vision', [ContentController::class, 'getMissionVision']);

    // Core Values
    Route::get('/core-values', [ContentController::class, 'getCoreValues']);

    // Partners
    Route::get('/partners', [ContentController::class, 'getPartners']);

    // Home Page Certifications
    Route::get('/home-certifications', [ContentController::class, 'getHomeCertifications']);

    // Contact CTA
    Route::get('/contact-cta', [ContentController::class, 'getContactCTA']);

    // Career CTA
    Route::get('/career-cta', [ContentController::class, 'getCareerCTA']);

    // Subscription Section
    Route::get('/subscription-section', [ContentController::class, 'getSubscriptionSection']);

    // Contact Section
    Route::get('/contact', [ContentController::class, 'getContactSection']);

    // Website Settings
    Route::get('/settings', [ContentController::class, 'getWebsiteSettings']);

    // Testimonials
    Route::get('/testimonials', [ContentController::class, 'getTestimonials']);

    // Footer Section
    Route::get('/footer', [ContentController::class, 'getFooterSection']);

    // Homepage All Content
    Route::get('/homepage', [ContentController::class, 'getHomepageContent']);

    // Service Categories
    Route::get('/service-categories', [ContentController::class, 'getServiceCategories']);

    // About Page APIs
    Route::prefix('about')->group(function () {
        Route::get('/hero', [ContentController::class, 'getAboutHeroSection']);
        Route::get('/mission-vision', [ContentController::class, 'getAboutMissionVision']);
        Route::get('/journey', [ContentController::class, 'getAboutJourney']);
        Route::get('/core-values', [ContentController::class, 'getAboutCoreValues']);
        Route::get('/certifications', [ContentController::class, 'getAboutCertifications']);
        Route::get('/career-cta', [ContentController::class, 'getAboutCareerCta']);
    });

    // Products Page APIs
    Route::prefix('products')->group(function () {
        Route::get('/hero', [PagesCmsController::class, 'getProductsHeroSection']);
    });

    // Projects Page APIs
    Route::prefix('projects')->group(function () {
        Route::get('/hero', [PagesCmsController::class, 'getProjectsHeroSection']);
    });

    // Services & Solutions Page APIs
    Route::prefix('services')->group(function () {
        Route::get('/hero', [PagesCmsController::class, 'getServicesHeroSection']);
    });

    // News Page APIs
    Route::prefix('news')->group(function () {
        Route::get('/hero', [PagesCmsController::class, 'getNewsHeroSection']);
    });

    // Career Page APIs
    Route::prefix('career')->group(function () {
        Route::get('/hero', [PagesCmsController::class, 'getCareerHeroSection']);
        Route::get('/contact-cta', [PagesCmsController::class, 'getCareerContactCtaSection']);
    });
});

// Analytics API (Public tracking endpoint)
Route::prefix('analytics')->group(function () {
    Route::post('/track', [\App\Http\Controllers\Api\AnalyticsTrackingController::class, 'trackPageView']);
});
