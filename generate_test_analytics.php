<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Visitor;
use App\Models\PageView;

echo "=== Generating Test Analytics Data ===\n\n";

// Define some sample URLs to simulate visits
$urls = [
    '/',
    '/about',
    '/products',
    '/products/transformers',
    '/projects',
    '/projects/solar-installation',
    '/services-and-solutions',
    '/news',
    '/contact',
];

echo "Simulating visits to public pages...\n";

foreach ($urls as $url) {
    try {
        // Create a request
        $request = \Illuminate\Http\Request::create($url, 'GET');

        // Create a new session for each visit to simulate different users
        $sessionId = 'test_session_' . md5($url . time() . rand());

        // Create visitor record
        $visitor = Visitor::create([
            'session_id' => $sessionId,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'first_visit' => now()->subDays(rand(0, 30)), // Random date within 30 days
            'last_visit' => now()->subHours(rand(0, 48)), // Recent visit
            'visit_count' => rand(1, 10),
            'device_type' => ['desktop', 'mobile', 'tablet'][rand(0, 2)],
            'browser' => ['Chrome', 'Firefox', 'Safari', 'Edge'][rand(0, 3)],
            'platform' => ['Windows', 'Mac', 'Linux', 'Android', 'iOS'][rand(0, 4)],
        ]);

        // Create page view record
        $pageView = PageView::create([
            'session_id' => $sessionId,
            'url' => $url,
            'title' => 'Page: ' . $url,
            'referer' => rand(0, 1) ? 'https://google.com' : null, // 50% chance of having a referer
            'method' => 'GET',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        echo "  ✓ Created visitor & page view for: {$url}\n";

    } catch (\Exception $e) {
        echo "  ✗ Error for {$url}: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Generate some additional page views for existing visitors to simulate returning visitors
echo "Simulating returning visitors...\n";

$existingVisitors = Visitor::take(3)->get();
foreach ($existingVisitors as $visitor) {
    try {
        $randomUrl = $urls[rand(0, count($urls) - 1)];

        PageView::create([
            'session_id' => $visitor->session_id,
            'url' => $randomUrl,
            'title' => 'Page: ' . $randomUrl,
            'referer' => null,
            'method' => 'GET',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        ]);

        // Update visitor stats
        $visitor->update([
            'last_visit' => now()->subHours(rand(0, 24)),
            'visit_count' => $visitor->visit_count + 1,
        ]);

        echo "  ✓ Returning visitor viewed: {$randomUrl}\n";

    } catch (\Exception $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Show final counts
$totalVisitors = Visitor::count();
$totalPageViews = PageView::count();
$uniqueVisitors = Visitor::whereBetween('first_visit', [now()->subDays(30), now()])->count();
$pageViewsLast30Days = PageView::whereBetween('created_at', [now()->subDays(30), now()])->count();

echo "=== Results ===\n";
echo "Total Visitors: {$totalVisitors}\n";
echo "Total Page Views: {$totalPageViews}\n";
echo "Unique Visitors (last 30 days): {$uniqueVisitors}\n";
echo "Page Views (last 30 days): {$pageViewsLast30Days}\n\n";

echo "✓ Test analytics data generated successfully!\n";
echo "Now visit /admin/analytics/website to see the analytics dashboard.\n\n";

echo "NOTE: To generate real analytics data:\n";
echo "1. Visit public pages on your website (NOT admin pages)\n";
echo "2. Admin routes are excluded from analytics tracking\n";
echo "3. Visit pages like /, /about, /products, /projects, etc.\n";
echo "4. Then check /admin/analytics/website to see the collected data\n";