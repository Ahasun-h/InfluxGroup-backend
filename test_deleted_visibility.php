<?php

/**
 * Comprehensive debug for deleted careers visibility
 * Run this to identify why deleted items aren't showing
 * Then delete this file for security.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== COMPREHENSIVE DELETED CAREERS DEBUG ===\n\n";

try {
    // Test 1: Database check
    echo "TEST 1: Database Structure\n";
    echo "====================================\n";
    $columns = Schema::getColumnListing('career_opportunities');
    echo "Table columns: " . implode(', ', $columns) . "\n";
    echo "Has deleted_at column: " . (in_array('deleted_at', $columns) ? 'YES' : 'NO') . "\n\n";

    // Test 2: Check for deleted items
    echo "TEST 2: Deleted Items Count\n";
    echo "====================================\n";
    $allJobs = DB::table('career_opportunities')->count();
    $deletedJobs = DB::table('career_opportunities')->whereNotNull('deleted_at')->count();
    $activeJobs = DB::table('career_opportunities')->whereNull('deleted_at')->count();

    echo "Total jobs: $allJobs\n";
    echo "Deleted jobs (deleted_at IS NOT NULL): $deletedJobs\n";
    echo "Active jobs (deleted_at IS NULL): $activeJobs\n\n";

    // Test 3: Show all jobs with status
    echo "TEST 3: All Jobs with Status\n";
    echo "====================================\n";
    $jobs = DB::table('career_opportunities')
        ->orderBy('created_at', 'desc')
        ->get();

    foreach ($jobs as $job) {
        $deletedStatus = $job->deleted_at ? "DELETED ({$job->deleted_at})" : "ACTIVE";
        $activeStatus = $job->is_active ? "Active" : "Inactive";
        echo "ID {$job->id}: {$job->title}\n";
        echo "  - Soft delete status: $deletedStatus\n";
        echo "  - Active status: $activeStatus\n";
        echo "---\n";
    }

    // Test 4: Simulate controller query
    echo "TEST 4: Controller Query Simulation\n";
    echo "====================================\n";
    $controllerQuery = DB::table('career_opportunities')
        ->orderBy('order')
        ->orderBy('created_at', 'desc')
        ->get();

    echo "Controller query returns: " . $controllerQuery->count() . " jobs\n";
    $deletedInController = $controllerQuery->whereNotNull('deleted_at')->count();
    echo "Deleted items in controller query: $deletedInController\n\n";

    // Test 5: Model test
    echo "TEST 5: Model Soft Delete Test\n";
    echo "====================================\n";
    try {
        // Test withTrashed scope
        $allWithTrashed = \App\Models\CareerOpportunitie::withTrashed()->get();
        echo "Model withTrashed() count: " . $allWithTrashed->count() . "\n";

        $onlyDeleted = \App\Models\CareerOpportunitie::onlyTrashed()->get();
        echo "Model onlyTrashed() count: " . $onlyDeleted->count() . "\n";

        $normalQuery = \App\Models\CareerOpportunitie::all();
        echo "Model all() count (excludes deleted): " . $normalQuery->count() . "\n\n";

        if ($onlyDeleted->count() > 0) {
            echo "Deleted items found:\n";
            foreach ($onlyDeleted as $deleted) {
                echo "  - ID {$deleted->id}: {$deleted->title} (deleted: {$deleted->deleted_at})\n";
            }
        } else {
            echo "No deleted items found via model\n";
        }
    } catch (\Exception $e) {
        echo "Model test error: " . $e->getMessage() . "\n\n";
    }

    // Test 6: Create a test deleted item if none exist
    if ($deletedJobs === 0 && $allJobs > 0) {
        echo "\nTEST 6: Creating Test Deleted Item\n";
        echo "====================================\n";
        $testJob = DB::table('career_opportunities')->whereNull('deleted_at')->first();
        if ($testJob) {
            echo "Creating soft deleted test item...\n";
            DB::table('career_opportunities')
                ->where('id', $testJob->id)
                ->update(['deleted_at' => now()]);

            $verifyDeleted = DB::table('career_opportunities')->where('id', $testJob->id)->first();
            if ($verifyDeleted && $verifyDeleted->deleted_at) {
                echo "✓ Test deleted item created: Job ID {$testJob->id}\n";
                echo "✓ This should now appear on /admin/careers with red background\n";
                echo "✓ You can restore it using the restore button\n\n";

                // Restore it after test
                DB::table('career_opportunities')->where('id', $testJob->id)->update(['deleted_at' => null]);
                echo "✓ Test item restored automatically\n";
            }
        }
    } elseif ($deletedJobs === 0 && $allJobs === 0) {
        echo "\n⚠️  No jobs in database. Create some jobs first.\n\n";
    }

    // Test 7: Check view rendering
    echo "TEST 7: View Rendering Check\n";
    echo "====================================\n";
    echo "Expected behavior:\n";
    echo "- Deleted items should have red background class\n";
    echo "- Status should show 'Deleted' badge\n";
    echo "- Actions should show restore button\n\n";

    // Test 8: Route check
    echo "TEST 8: Routes Check\n";
    echo "====================================\n";
    $indexRoute = Route::getRoutes()->getByAction('App\Http\Controllers\Admin\CareersController@index');
    echo "Index route exists: " . ($indexRoute ? 'YES' : 'NO') . "\n";
    if ($indexRoute) {
        echo "Index route URI: " . $indexRoute->uri . "\n";
    }
    echo "Restore route exists: " . (Route::has('admin.careers.restore') ? 'YES' : 'NO') . "\n\n";

    // Final summary
    echo "=== SUMMARY ===\n";
    if ($deletedJobs > 0) {
        echo "✓ Found $deletedJobs deleted item(s)\n";
        echo "✓ These SHOULD be visible on /admin/careers\n";
        echo "✓ Check for:\n";
        echo "  1. Browser console errors (F12)\n";
        echo "  2. View rendering (check HTML source)\n";
        echo "  3. JavaScript filtering issues\n";
        echo "  4. Cache issues (try clearing browser cache)\n";
    } else {
        echo "⚠️  No deleted items found in database\n";
        echo "⚠️  Delete a job first to test deleted item visibility\n";
    }

    echo "\n⚠️  Please delete this file (test_deleted_visibility.php) for security.\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
