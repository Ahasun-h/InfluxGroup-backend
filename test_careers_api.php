<?php

/**
 * Test careers API endpoint
 * Run this to verify the API is working correctly
 * Then delete this file for security.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CAREERS API TEST ===\n\n";

try {
    // Test 1: Check database connection and table
    echo "TEST 1: Database Check\n";
    echo "====================================\n";
    $tableExists = \Schema::hasTable('career_opportunities');
    echo ($tableExists ? "✓ career_opportunities table exists\n" : "✗ career_opportunities table missing\n");

    if ($tableExists) {
        $columns = \Schema::getColumnListing('career_opportunities');
        echo "✓ Columns: " . implode(', ', $columns) . "\n";
    }
    echo "\n";

    // Test 2: Check active careers count
    echo "TEST 2: Active Careers Count\n";
    echo "====================================\n";

    $activeCareers = \App\Models\CareerOpportunitie::where('is_active', true)
        ->whereNull('deleted_at')
        ->count();

    $totalCareers = \App\Models\CareerOpportunitie::count();
    $deletedCareers = \App\Models\CareerOpportunitie::whereNotNull('deleted_at')->count();

    echo "Total careers in database: $totalCareers\n";
    echo "Active careers: $activeCareers\n";
    echo "Deleted careers: $deletedCareers\n\n";

    // Test 3: Simulate API response
    echo "TEST 3: API Response Simulation\n";
    echo "====================================\n";

    $careers = \App\Models\CareerOpportunitie::where('is_active', true)
        ->whereNull('deleted_at')
        ->orderBy('order', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

    echo " careers found: " . $careers->count() . "\n\n";

    if ($careers->count() > 0) {
        foreach ($careers as $career) {
            echo "Career ID: {$career->id}\n";
            echo "Title: {$career->title}\n";
            echo "Department: {$career->department}\n";
            echo "Location: {$career->location}\n";
            echo "Type: {$career->type}\n";
            echo "Posted Date: " . ($career->posted_date ?? 'Recently posted') . "\n";
            echo "Experience: {$career->experience}\n";
            echo "Salary: {$career->salary}\n";
            echo "Description: " . substr($career->description, 0, 100) . "...\n";
            echo "Requirements: " . (is_array($career->requirements) ? count($career->requirements) . ' items' : 'N/A') . "\n";
            echo "Responsibilities: " . (is_array($career->responsibilities) ? count($career->responsibilities) . ' items' : 'N/A') . "\n";
            echo "Benefits: " . (is_array($career->benefits) ? count($career->benefits) . ' items' : 'N/A') . "\n";
            echo "---\n";
        }
    } else {
        echo "⚠️  No active careers found!\n";
        echo "To create active careers:\n";
        echo "1. Go to /admin/careers\n";
        echo "2. Create some job listings\n";
        echo "3. Make sure they are set to 'Active' status\n";
        echo "4. This API will return those active jobs\n\n";
    }

    // Test 4: Simulate JSON response
    echo "TEST 4: Simulated JSON Response\n";
    echo "====================================\n";

    $apiResponse = $careers->map(function ($career) {
        return [
            'id' => $career->id,
            'title' => $career->title,
            'department' => $career->department,
            'location' => $career->location,
            'type' => $career->type,
            'posted_date' => $career->posted_date ?? 'Recently posted',
            'expiry_date' => $career->expiry_date ? \Carbon\Carbon::parse($career->expiry_date)->format('Y-m-d') : null,
            'experience' => $career->experience,
            'salary' => $career->salary,
            'description' => $career->description,
            'requirements' => is_array($career->requirements) ? $career->requirements : [],
            'responsibilities' => is_array($career->responsibilities) ? $career->responsibilities : [],
            'benefits' => is_array($career->benefits) ? $career->benefits : [],
        ];
    });

    echo "API would return this JSON structure:\n";
    echo json_encode([
        'success' => true,
        'data' => $apiResponse->toArray()
    ], JSON_PRETTY_PRINT);

    echo "\n\n";

    // Test 5: Check API route
    echo "TEST 5: API Route Check\n";
    echo "====================================\n";

    $apiRoute = \Route::getRoutes()->getByAction('App\Http\Controllers\Api\ContentController@getCareers');
    if ($apiRoute) {
        echo "✓ API route exists\n";
        echo "✓ Route URI: " . $apiRoute->uri . "\n";
        echo "✓ Full URL: /api" . $apiRoute->uri . "\n";
    } else {
        echo "✗ API route not found - check routes/api.php\n";
    }

    echo "\n=== TEST COMPLETE ===\n";
    echo "Expected frontend behavior:\n";
    echo "1. Vue component calls: GET /api/careers/jobs\n";
    echo "2. API returns JSON with 'success' and 'data' keys\n";
    echo "3. Vue renders job cards dynamically\n";
    echo "4. Jobs show title, department, location, type, etc.\n";
    echo "5. Clicking 'View Details' shows full job modal\n\n";

    echo "⚠️  Please delete this file (test_careers_api.php) for security.\n";

} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
