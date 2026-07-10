<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Create a test request
$request = \Illuminate\Http\Request::create('/test-page', 'GET');

// Start session
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$app->instance('request', $request);

// Bootstrap the application
$kernel->bootstrap();

echo "=== Testing Middleware & Session ===\n\n";

try {
    // Start session
    $session = $app->make('session');
    $session->start();

    echo "1. Session Information:\n";
    echo "   - Session ID: " . $session->getId() . "\n";
    echo "   - Session started: YES\n";

    echo "\n2. Testing Analytics Middleware:\n";

    // Create a manual test request to trigger middleware
    $testRequest = \Illuminate\Http\Request::create('/', 'GET');
    $testRequest->setSession($session);

    echo "   - Created test request\n";
    echo "   - Session ID in request: " . $testRequest->session()->getId() . "\n";

    // Try to manually trigger the analytics tracking
    $visitor = \App\Models\Visitor::where('session_id', $session->getId())->first();

    if ($visitor) {
        echo "   - Found existing visitor: ID {$visitor->id}\n";
    } else {
        echo "   - No existing visitor found for this session\n";
    }

    echo "\n3. Current Database Counts:\n";
    echo "   - Visitors: " . \App\Models\Visitor::count() . "\n";
    echo "   - Page Views: " . \App\Models\PageView::count() . "\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";