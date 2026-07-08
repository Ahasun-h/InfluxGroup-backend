<?php

/**
 * Check for deleted career items in database
 * Run this to debug why deleted items aren't showing
 * Then delete this file for security.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Deleted Careers Check ===\n\n";

try {
    // Check database connection
    echo "Database: " . DB::connection()->getDatabaseName() . "\n\n";

    // Check if deleted_at column exists
    $columns = Schema::getColumnListing('career_opportunities');
    echo "✓ Table columns: " . implode(', ', $columns) . "\n";

    if (in_array('deleted_at', $columns)) {
        echo "✓ deleted_at column exists\n\n";
    } else {
        echo "✗ deleted_at column MISSING - soft deletes not working!\n\n";
    }

    // Count all jobs
    $allJobs = DB::table('career_opportunities')->count();
    echo "Total jobs in database: $allJobs\n";

    // Count deleted jobs
    $deletedJobs = DB::table('career_opportunities')->whereNotNull('deleted_at')->count();
    echo "Deleted jobs (deleted_at IS NOT NULL): $deletedJobs\n";

    // Count active jobs
    $activeJobs = DB::table('career_opportunities')->whereNull('deleted_at')->count();
    echo "Active jobs (deleted_at IS NULL): $activeJobs\n\n";

    // Show all jobs with deleted status
    $jobs = DB::table('career_opportunities')
        ->orderBy('created_at', 'desc')
        ->get();

    echo "=== All Jobs ===\n";
    foreach ($jobs as $job) {
        $status = $job->deleted_at ? 'DELETED' : ($job->is_active ? 'Active' : 'Inactive');
        $deletedInfo = $job->deleted_at ? " (deleted at: $job->deleted_at)" : '';
        echo "ID {$job->id}: {$job->title} - {$status}{$deletedInfo}\n";
    }

    // Check specific deleted items
    echo "\n=== Deleted Items Detail ===\n";
    $deletedItems = DB::table('career_opportunities')->whereNotNull('deleted_at')->get();
    foreach ($deletedItems as $item) {
        echo "ID: {$item->id}\n";
        echo "Title: {$item->title}\n";
        echo "Deleted at: {$item->deleted_at}\n";
        echo "Is active: " . ($item->is_active ? 'Yes' : 'No') . "\n";
        echo "---\n";
    }

    if ($deletedJobs === 0) {
        echo "\n⚠️  No deleted items found in database.\n";
        echo "To test deleted items visibility:\n";
        echo "1. Delete a job using the delete button\n";
        echo "2. Refresh the careers page\n";
        echo "3. The deleted item should appear with red background\n\n";
    } else {
        echo "\n✓ Found $deletedJobs deleted item(s)\n";
        echo "These should be visible on the /admin/careers page with red background\n\n";
    }

    // Test soft delete functionality
    echo "=== Testing Soft Delete ===\n";
    $testJob = DB::table('career_opportunities')->whereNull('deleted_at')->first();
    if ($testJob) {
        echo "Testing with job: {$testJob->title} (ID: {$testJob->id})\n";

        // Test soft delete using model
        try {
            $model = \App\Models\CareerOpportunitie::find($testJob->id);
            if ($model) {
                echo "✓ Model found\n";

                // Test soft delete
                $model->delete();
                echo "✓ Model soft deleted\n";

                // Check if deleted
                $checkDeleted = DB::table('career_opportunities')->where('id', $testJob->id)->whereNotNull('deleted_at')->first();
                if ($checkDeleted) {
                    echo "✓ Soft delete verified in database (deleted_at: {$checkDeleted->deleted_at})\n";

                    // Restore
                    $model->restore();
                    echo "✓ Model restored\n";

                    // Verify restore
                    $checkRestored = DB::table('career_opportunities')->where('id', $testJob->id)->whereNull('deleted_at')->first();
                    if ($checkRestored) {
                        echo "✓ Restore verified in database\n";
                    }
                } else {
                    echo "✗ Soft delete NOT found in database\n";
                }
            }
        } catch (\Exception $e) {
            echo "✗ Error testing soft delete: " . $e->getMessage() . "\n";
        }
    } else {
        echo "! No active jobs found to test soft delete\n";
    }

    echo "\n⚠️  Please delete this file (check_deleted_items.php) for security.\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
