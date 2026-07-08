<?php

/**
 * Test view rendering for deleted items
 * This simulates the controller and view rendering
 * Then delete this file for security.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VIEW RENDERING TEST ===\n\n";

try {
    // Simulate controller query
    $jobs = DB::table('career_opportunities')
        ->orderBy('order')
        ->orderBy('created_at', 'desc')
        ->get();

    echo "Controller simulation:\n";
    echo "Total jobs: " . $jobs->count() . "\n";
    echo "Deleted jobs: " . $jobs->whereNotNull('deleted_at')->count() . "\n\n";

    // Check each job
    echo "Job Details:\n";
    foreach ($jobs as $job) {
        $isDeleted = !is_null($job->deleted_at);
        $status = $isDeleted ? 'DELETED' : ($job->is_active ? 'Active' : 'Inactive');

        echo "ID: {$job->id}\n";
        echo "Title: {$job->title}\n";
        echo "Status: {$status}\n";
        echo "Is Active: " . ($job->is_active ? 'Yes' : 'No') . "\n";
        echo "Deleted At: " . ($job->deleted_at ?? 'NULL') . "\n";
        echo "---\n";
    }

    // Test view rendering logic
    echo "\n=== VIEW RENDERING LOGIC ===\n\n";

    echo "Expected HTML output:\n";
    foreach ($jobs as $job) {
        $isDeleted = !is_null($job->deleted_at);
        $rowClass = $isDeleted ? 'bg-red-50 dark:bg-red-500/10' : '';
        $dataStatus = $isDeleted ? 'deleted' : ($job->is_active ? 'active' : 'inactive');
        $dataDeleted = $isDeleted ? 'true' : 'false';

        echo "Job ID {$job->id}: {$job->title}\n";
        echo "  <tr class=\"job-row {$rowClass}\" \n";
        echo "    data-status=\"{$dataStatus}\" \n";
        echo "    data-deleted=\"{$dataDeleted}\">\n";
        echo "  ...\n";
        echo "  Status badge: " . ($isDeleted ? 'Deleted' : ($job->is_active ? 'Active' : 'Inactive')) . "\n";
        echo "---\n";
    }

    // JavaScript filtering test
    echo "\n=== JAVASCRIPT FILTERING TEST ===\n\n";

    echo "filterByStatus function logic:\n";
    $testFilters = ['all', 'active', 'inactive', 'deleted'];

    foreach ($testFilters as $filter) {
        echo "Filter: {$filter}\n";
        echo "  Jobs that would be visible:\n";

        foreach ($jobs as $job) {
            $isDeleted = !is_null($job->deleted_at);
            $jobStatus = $isDeleted ? 'deleted' : ($job->is_active ? 'active' : 'inactive');

            $visible = ($filter === 'all' || $jobStatus === $filter);

            if ($visible) {
                echo "    - ID {$job->id}: {$job->title} ({$jobStatus})\n";
            }
        }
        echo "---\n";
    }

    // Check for potential issues
    echo "\n=== POTENTIAL ISSUES ===\n\n";

    if ($jobs->whereNotNull('deleted_at')->count() > 0) {
        echo "✓ Deleted items exist in database\n";
        echo "✓ Controller is retrieving deleted items\n";
        echo "✓ View should render deleted items\n\n";

        echo "If deleted items are not visible in browser:\n";
        echo "1. Check browser console (F12) for JavaScript errors\n";
        echo "2. Check yellow debug box on /admin/careers page\n";
        echo "3. Check HTML source for deleted item rows\n";
        echo "4. Try changing filter to 'Deleted Only'\n";
        echo "5. Clear browser cache (Ctrl+F5)\n";
    } else {
        echo "⚠️  No deleted items found in database\n";
        echo "⚠️  Delete a job first to test visibility\n";
    }

    echo "\n⚠️  Please delete this file (test_view_rendering.php) for security.\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
