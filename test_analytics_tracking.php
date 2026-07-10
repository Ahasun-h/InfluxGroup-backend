<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Visitor;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;

echo "=== Testing Analytics Tracking ===\n\n";

// Test creating a visitor
echo "1. Creating test visitor...\n";
try {
    $visitor = Visitor::create([
        'session_id' => 'test_session_' . time(),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'first_visit' => now(),
        'last_visit' => now(),
        'visit_count' => 1,
        'device_type' => 'desktop',
        'browser' => 'Chrome',
        'platform' => 'Windows',
    ]);
    echo "   - Visitor created successfully! ID: {$visitor->id}\n";
} catch (\Exception $e) {
    echo "   - Error creating visitor: " . $e->getMessage() . "\n";
}

echo "\n";

// Test creating a page view
echo "2. Creating test page view...\n";
try {
    $pageView = PageView::create([
        'session_id' => $visitor->session_id,
        'url' => '/test-page',
        'title' => 'Test Page',
        'referer' => null,
        'method' => 'GET',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
    ]);
    echo "   - Page view created successfully! ID: {$pageView->id}\n";
} catch (\Exception $e) {
    echo "   - Error creating page view: " . $e->getMessage() . "\n";
}

echo "\n";

// Check current counts
echo "3. Current database counts:\n";
echo "   - Visitors: " . Visitor::count() . "\n";
echo "   - Page Views: " . PageView::count() . "\n";

echo "\n=== Test Complete ===\n";

echo "\nNOTE: If this test worked, then the database structure is correct.\n";
echo "The analytics tracking should now work when you visit actual pages.\n";
echo "Try visiting some pages on your website and check /admin/analytics/website\n";
