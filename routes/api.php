<?php

use App\Http\Controllers\Api\ContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Endpoints
Route::prefix('products')->group(function () {
    Route::get('/', [ContentController::class, 'getProducts']);
    Route::get('/categories', [ContentController::class, 'getProductCategories']);
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
    Route::get('/{service:slug}', [ContentController::class, 'getService']);
});

Route::prefix('solutions')->group(function () {
    Route::get('/', [ContentController::class, 'getSolutions']);
    Route::get('/{solution:slug}', [ContentController::class, 'getSolution']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [ContentController::class, 'getNews']);
    Route::get('/categories', [ContentController::class, 'getNewsCategories']);
    Route::get('/featured', [ContentController::class, 'getFeaturedNews']);
    Route::get('/{news:slug}', [ContentController::class, 'getNewsArticle']);
});

Route::get('/content/company-info', [ContentController::class, 'getCompanyInfo']);

// Admin-only content management endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/content/homepage', [ContentController::class, 'updateHomepageContent']);
});

Route::prefix('pages')->group(function () {
    Route::get('/', [ContentController::class, 'getPages']);
    Route::get('/{slug}', [ContentController::class, 'getPageBySlug']);
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

    // Contact CTA
    Route::get('/contact-cta', [ContentController::class, 'getContactCTA']);

    // Career CTA
    Route::get('/career-cta', [ContentController::class, 'getCareerCTA']);

    // Contact Section
    Route::get('/contact', [ContentController::class, 'getContactSection']);

    // Homepage All Content
    Route::get('/homepage', [ContentController::class, 'getHomepageContent']);
});
