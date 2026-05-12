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
    Route::get('/featured', [ContentController::class, 'getFeaturedProjects']);
    Route::get('/{project:slug}', [ContentController::class, 'getProject']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [ContentController::class, 'getNews']);
    Route::get('/featured', [ContentController::class, 'getFeaturedNews']);
    Route::get('/categories', [ContentController::class, 'getNewsCategories']);
    Route::get('/{news:slug}', [ContentController::class, 'getArticle']);
});

Route::prefix('gallery')->group(function () {
    Route::get('/', [ContentController::class, 'getGallery']);
    Route::get('/categories', [ContentController::class, 'getGalleryCategories']);
});

Route::get('/services', [ContentController::class, 'getServices']);
Route::get('/solutions', [ContentController::class, 'getSolutions']);
Route::get('/testimonials', [ContentController::class, 'getTestimonials']);
Route::get('/partners', [ContentController::class, 'getPartners']);
Route::get('/careers/jobs', [ContentController::class, 'getJobs']);
Route::get('/content/company-info', [ContentController::class, 'getCompanyInfo']);

// Admin-only content management endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/content/homepage', [ContentController::class, 'updateHomepageContent']);
});

Route::prefix('pages')->group(function () {
    Route::get('/', [ContentController::class, 'getPages']);
    Route::get('/{slug}', [ContentController::class, 'getPageBySlug']);
});
