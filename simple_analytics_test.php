<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== Simple Analytics Test ===" . PHP_EOL . PHP_EOL;

$period = 30;
$startDate = now()->subDays($period)->startOfDay();
$endDate = now()->endOfDay();

echo "Period: Last " . $period . " days" . PHP_EOL;
echo "Start: " . $startDate->toDateTimeString() . PHP_EOL;
echo "End: " . $endDate->toDateTimeString() . PHP_EOL . PHP_EOL;

echo "Test Results:" . PHP_EOL;
echo "-------------" . PHP_EOL;

// Unique Visitors
$uniqueVisitors = \App\Models\Visitor::whereBetween('first_visit', [$startDate, $endDate])->count();
echo "Unique Visitors: " . $uniqueVisitors . PHP_EOL;

// Total Page Views
$totalPageViews = \App\Models\PageView::whereBetween('created_at', [$startDate, $endDate])->count();
echo "Total Page Views: " . $totalPageViews . PHP_EOL;

// Returning Visitors
$returningVisitors = \App\Models\Visitor::where('visit_count', '>', 1)->whereBetween('first_visit', [$startDate, $endDate])->count();
echo "Returning Visitors: " . $returningVisitors . PHP_EOL;

// Average
$avg = $uniqueVisitors > 0 ? round($totalPageViews / $uniqueVisitors, 2) : 0;
echo "Avg Page Views/Visitor: " . $avg . PHP_EOL . PHP_EOL;

echo "Top Pages:" . PHP_EOL;
$topPages = \App\Models\PageView::select('url', \Illuminate\Support\Facades\DB::raw('COUNT(*) as views'))
    ->whereBetween('created_at', [$startDate, $endDate])
    ->groupBy('url')
    ->orderBy('views', 'desc')
    ->take(5)
    ->get();

foreach ($topPages as $page) {
    echo "  " . $page->url . ": " . $page->views . " views" . PHP_EOL;
}

echo PHP_EOL . "Test Complete!" . PHP_EOL;
echo "Visit /admin/analytics/website to see the dashboard." . PHP_EOL;