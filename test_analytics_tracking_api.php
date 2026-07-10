<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== Testing Analytics API Tracking ===\n\n";

// Simulate a POST request to the analytics tracking endpoint
$testData = [
    'session_id' => 'vue_test_' . time(),
    'url' => '/test-page',
    'title' => 'Test Page',
    'referer' => 'https://google.com',
    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
];

echo "Sending test tracking request...\n";
echo "Session ID: " . $testData['session_id'] . "\n";
echo "URL: " . $testData['url'] . "\n";
echo "Title: " . $testData['title'] . "\n\n";

try {
    // Create a mock request
    $request = \Illuminate\Http\Request::create('/api/analytics/track', 'POST', [], [], [], [], json_encode($testData));
    $request->headers->set('Content-Type', 'application/json');
    $request->headers->set('Accept', 'application/json');

    // Handle through the kernel
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    $response = $kernel->handle($request);

    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content: " . $response->getContent() . "\n\n";

    // Check if data was recorded
    $visitorCount = \App\Models\Visitor::count();
    $pageViewCount = \App\Models\PageView::count();

    echo "Database Counts:\n";
    echo "  Total Visitors: " . $visitorCount . "\n";
    echo "  Total Page Views: " . $pageViewCount . "\n\n";

    if ($response->getStatusCode() === 200) {
        echo "✓ SUCCESS: Analytics API tracking is working!\n";
        echo "  The Vue frontend can now send tracking data to Laravel.\n";
    } else {
        echo "✗ FAILED: Analytics API returned non-200 status.\n";
    }

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "\nNext steps:\n";
echo "1. Start your Vue frontend development server\n";
echo "2. Visit pages in the Vue application\n";
echo "3. Check /admin/analytics/website to see collected data\n";