<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Product Categories Troubleshooting ===\n\n";

// Check if product_categories table exists
try {
    $tableExists = Schema::hasTable('product_categories');
    echo "product_categories table exists: " . ($tableExists ? 'YES' : 'NO') . "\n";

    if ($tableExists) {
        // Get table columns
        $columns = Schema::getColumnListing('product_categories');
        echo "Table columns: " . implode(', ', $columns) . "\n";

        // Count records
        $count = DB::table('product_categories')->count();
        echo "Total categories: " . $count . "\n";

        // List categories
        if ($count > 0) {
            $categories = DB::table('product_categories')->get();
            echo "\nExisting categories:\n";
            foreach ($categories as $category) {
                echo "- ID: {$category->id}, Name: {$category->name}, Slug: {$category->slug}, Order: {$category->order}, Active: {$category->is_active}\n";
            }
        }
    } else {
        echo "ERROR: product_categories table does not exist!\n";
        echo "Please run: php artisan migrate\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Troubleshooting Complete ===\n";