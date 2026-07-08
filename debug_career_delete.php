<?php

/**
 * Debug script to test career delete functionality
 * Run this to diagnose delete issues
 * Then delete this file for security.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Career Delete Debug ===\n\n";

try {
    // Test 1: Check if we can fetch a job for deletion
    echo "Test 1: Fetch Job for Deletion\n";
    $job = \DB::table('career_opportunities')->find(2);
    if ($job) {
        echo "✓ Found job: " . $job->title . " (ID: " . $job->id . ")\n";
    } else {
        echo "✗ Job ID 2 not found, trying another job\n";
        $job = \DB::table('career_opportunities')->first();
        if ($job) {
            echo "✓ Found job: " . $job->title . " (ID: " . $job->id . ")\n";
        } else {
            echo "✗ No jobs found in database\n";
            exit;
        }
    }

    // Test 2: Check destroy route exists
    echo "\nTest 2: Route Configuration\n";
    $destroyRoute = Route::getRoutes()->getByAction('App\Http\Controllers\Admin\CareersController@destroy');
    if ($destroyRoute) {
        echo "✓ Destroy route exists\n";
        echo "✓ Route URI: " . $destroyRoute->uri . "\n";
        echo "✓ Route methods: " . implode(', ', $destroyRoute->methods) . "\n";
        echo "✓ Expected URL: /admin/careers/" . $job->id . "\n";
    } else {
        echo "✗ Destroy route not found\n";
    }

    // Test 3: Check Model with soft deletes
    echo "\nTest 3: Model Test\n";
    try {
        $careerModel = \App\Models\CareerOpportunitie::withTrashed()->find($job->id);
        if ($careerModel) {
            echo "✓ Model found withTrashed: " . $careerModel->title . "\n";
            echo "✓ Soft deletes enabled: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($careerModel)) ? 'Yes' : 'No') . "\n";
            echo "✓ Current deleted_at: " . ($careerModel->deleted_at ?? 'NULL') . "\n";

            // Test soft delete
            $careerModel->delete();
            echo "✓ Model deleted (soft delete)\n";

            // Verify soft deletion
            $deletedModel = \App\Models\CareerOpportunitie::withTrashed()->find($job->id);
            if ($deletedModel && $deletedModel->deleted_at) {
                echo "✓ Soft delete verified: deleted_at = " . $deletedModel->deleted_at . "\n";

                // Restore the job for testing
                $deletedModel->restore();
                echo "✓ Model restored for further testing\n";
            } else {
                echo "✗ Soft delete verification failed\n";
            }
        } else {
            echo "✗ Model not found\n";
        }
    } catch (\Exception $e) {
        echo "✗ Model error: " . $e->getMessage() . "\n";
    }

    // Test 4: Test DB delete
    echo "\nTest 4: Database Delete Test\n";
    try {
        // Find a different job ID for testing (not the main one)
        $testJob = \DB::table('career_opportunities')->where('id', '!=', $job->id)->first();
        if ($testJob) {
            echo "✓ Using test job: " . $testJob->title . " (ID: " . $testJob->id . ")\n";

            // Soft delete using DB
            $testJob->deleted_at = now();
            \DB::table('career_opportunities')->where('id', $testJob->id)->update(['deleted_at' => now()]);
            echo "✓ Database soft delete executed\n";

            // Verify deletion
            $checkDeleted = \DB::table('career_opportunities')->where('id', $testJob->id)->whereNotNull('deleted_at')->first();
            if ($checkDeleted) {
                echo "✓ Database deletion verified\n";

                // Restore
                \DB::table('career_opportunities')->where('id', $testJob->id)->update(['deleted_at' => null]);
                echo "✓ Test job restored\n";
            } else {
                echo "✗ Database deletion verification failed\n";
            }
        } else {
            echo "! No additional test job found\n";
        }
    } catch (\Exception $e) {
        echo "✗ Database error: " . $e->getMessage() . "\n";
    }

    // Test 5: Check form route generation
    echo "\nTest 5: Form Route Generation\n";
    try {
        $destroyUrl = route('admin.careers.destroy', $job->id);
        echo "✓ Destroy URL: " . $destroyUrl . "\n";

        // Check if URL matches expected pattern
        $expectedPattern = '/admin/careers/' . $job->id;
        if (strpos($destroyUrl, $expectedPattern) !== false) {
            echo "✓ URL pattern correct\n";
        } else {
            echo "✗ URL pattern mismatch. Expected: " . $expectedPattern . "\n";
        }
    } catch (\Exception $e) {
        echo "✗ Route generation error: " . $e->getMessage() . "\n";
    }

    // Test 6: Check resource controller parameters
    echo "\nTest 6: Resource Controller Parameters\n";
    $routes = Route::getRoutes()->getByAction('App\Http\Controllers\Admin\CareersController@destroy');
    if ($routes) {
        echo "✓ Route parameters: " . print_r($routes->parameters, true) . "\n";
    }

    echo "\n=== Debug Summary ===\n";
    echo "If all tests pass, the issue might be:\n";
    echo "1. JavaScript preventing form submission\n";
    echo "2. CSRF token issues\n";
    echo "3. Browser console errors\n";
    echo "4. Form not inside table structure properly\n";
    echo "5. Confirmation dialog blocking submission\n\n";

    echo "Manual test steps:\n";
    echo "1. Go to /admin/careers\n";
    echo "2. Open browser console (F12)\n";
    echo "3. Click delete button on a job\n";
    echo "4. Accept confirmation dialog\n";
    echo "5. Check console for errors\n";
    echo "6. Check network tab for DELETE request\n";
    echo "7. Check for redirect response\n\n";

    echo "⚠️  Please delete this file (debug_career_delete.php) for security.\n";

} catch (Exception $e) {
    echo "\n✗ Debug Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
