<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Visitor;
use App\Models\PageView;

echo "=== Analytics Integration Test ===\n\n";

// Test 1: API Endpoint
echo "Test 1: API Endpoint\n";
echo "====================\n";

$testData = [
    'session_id' => 'vue_integration_test_' . time(),
    'url' => '/products/transformers',
    'title' => 'Power Transformers - Products',
    'referer' => 'https://google.com',
    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
];

try {
    $request = \Illuminate\Http\Request::create('/api/analytics/track', 'POST', [], [], [], [], json_encode($testData));
    $request->headers->set('Content-Type', 'application/json');
    $request->headers->set('Accept', 'application/json');

    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
    $response = $kernel->handle($request);

    if ($response->getStatusCode() === 200) {
        echo "✓ API endpoint working correctly\n";
        $responseData = json_decode($response->getContent(), true);
        echo "  - Visitor ID: " . $responseData['data']['visitor_id'] . "\n";
        echo "  - Page View ID: " . $responseData['data']['page_view_id'] . "\n";
    } else {
        echo "✗ API endpoint failed: " . $response->getStatusCode() . "\n";
    }
} catch (\Exception $e) {
    echo "✗ API test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Database Storage
echo "Test 2: Database Storage\n";
echo "=======================\n";

$visitorCount = Visitor::count();
$pageViewCount = PageView::count();

echo "Total Visitors: " . $visitorCount . "\n";
echo "Total Page Views: " . $pageViewCount . "\n";

if ($visitorCount > 0 && $pageViewCount > 0) {
    echo "✓ Database storage working\n";
} else {
    echo "✗ No data found in database\n";
}

echo "\n";

// Test 3: Recent Data
echo "Test 3: Recent Analytics Data\n";
echo "==============================\n";

$recentVisitors = Visitor::latest()->take(3)->get();
$recentPageViews = PageView::latest()->take(5)->get();

echo "Recent Visitors:\n";
foreach ($recentVisitors as $visitor) {
    echo "  - Session: " . $visitor->session_id . "\n";
    echo "    Device: " . $visitor->device_type . " | Browser: " . $visitor->browser . "\n";
    echo "    First Visit: " . $visitor->first_visit . "\n";
    echo "    Visit Count: " . $visitor->visit_count . "\n";
}

echo "\nRecent Page Views:\n";
foreach ($recentPageViews as $pageView) {
    echo "  - URL: " . $pageView->url . "\n";
    echo "    Title: " . ($pageView->title ?: 'No title') . "\n";
    echo "    Created: " . $pageView->created_at . "\n";
}

echo "\n";

// Test 4: Analytics Queries
echo "Test 4: Analytics Queries (30 days)\n";
echo "=====================================\n";

$period = 30;
$startDate = now()->subDays($period)->startOfDay();
$endDate = now()->endOfDay();

$uniqueVisitors = Visitor::whereBetween('first_visit', [$startDate, $endDate])->count();
$totalPageViews = PageView::whereBetween('created_at', [$startDate, $endDate])->count();
$returningVisitors = Visitor::where('visit_count', '>', 1)
    ->whereBetween('first_visit', [$startDate, $endDate])
    ->count();

echo "Period: Last " . $period . " days\n";
echo "Unique Visitors: " . $uniqueVisitors . "\n";
echo "Total Page Views: " . $totalPageViews . "\n";
echo "Returning Visitors: " . $returningVisitors . "\n";

$topPages = PageView::select('url', \Illuminate\Support\Facades\DB::raw('COUNT(*) as views'))
    ->whereBetween('created_at', [$startDate, $endDate])
    ->groupBy('url')
    ->orderBy('views', 'desc')
    ->take(3)
    ->get();

echo "\nTop Pages:\n";
foreach ($topPages as $page) {
    echo "  " . $page->url . ": " . $page->views . " views\n";
}

echo "\n";

// Test 5: Vue Frontend Files
echo "Test 5: Vue Frontend Files\n";
echo "==========================\n";

$vueFiles = [
    'D:/Herd/InfluxGroup-backend/InfluxGroup/src/services/analyticsTracking.js',
    'D:/Herd/InfluxGroup-backend/InfluxGroup/src/composables/useAnalytics.js',
    'D:/Herd/InfluxGroup-backend/InfluxGroup/src/App.vue',
];

$allFilesExist = true;
foreach ($vueFiles as $file) {
    if (file_exists($file)) {
        echo "✓ " . basename($file) . " exists\n";
    } else {
        echo "✗ " . basename($file) . " missing\n";
        $allFilesExist = false;
    }
}

echo "\n";

// Final Status
echo "=== Integration Status ===\n\n";

$allTests = [
    'API Endpoint' => $response->getStatusCode() === 200 ?? false,
    'Database Storage' => $visitorCount > 0 && $pageViewCount > 0,
    'Analytics Queries' => $uniqueVisitors > 0,
    'Vue Files' => $allFilesExist,
];

$passedTests = count(array_filter($allTests));
$totalTests = count($allTests);

foreach ($allTests as $test => $passed) {
    $status = $passed ? '✓' : '✗';
    echo "{$status} {$test}\n";
}

echo "\n";

if ($passedTests === $totalTests) {
    echo "🎉 ALL TESTS PASSED!\n\n";
    echo "Your Vue analytics tracking is fully integrated!\n\n";
    echo "Next Steps:\n";
    echo "1. Start your Vue development server: cd InfluxGroup && npm run dev\n";
    echo "2. Visit pages in your Vue application\n";
    echo "3. Check /admin/analytics/website for collected data\n";
    echo "4. Test the tracking at: http://influxgroup-backend.test/test-vue-analytics.html\n";
} else {
    echo "⚠️  SOME TESTS FAILED\n";
    echo "Please check the failed tests above.\n";
}

echo "\nFor detailed documentation, see: VUE_ANALYTICS_SETUP.md\n";