<?php
// Simple test to trigger analytics middleware
// This file simulates a real page visit

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create a real HTTP request
$request = \Illuminate\Http\Request::create('/test-page', 'GET');

// Handle the request through the kernel (this will trigger middleware)
try {
    $response = $kernel->handle($request);
    $kernel->terminate($request, $response);

    echo "Analytics Middleware Test Results:\n";
    echo "=====================================\n\n";

    echo "Request was processed through the full Laravel stack.\n";
    echo "If analytics tracking is working, a visitor and page view should be recorded.\n\n";

    // Check database counts
    $visitorCount = \App\Models\Visitor::count();
    $pageViewCount = \App\Models\PageView::count();

    echo "Current Database Counts:\n";
    echo "  - Visitors: " . $visitorCount . "\n";
    echo "  - Page Views: " . $pageViewCount . "\n\n";

    if ($visitorCount > 0) {
        echo "✓ SUCCESS: Analytics tracking is working!\n";
        echo "  Visit /admin/analytics/website to see the data.\n";
    } else {
        echo "✗ FAILED: No data was recorded.\n";
        echo "  Check if sessions are working properly.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}