<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Analytics Tables Diagnostic ===\n\n";

// Check visitors table structure
echo "1. Checking 'visitors' table:\n";
if (Schema::hasTable('visitors')) {
    echo "   - Table exists: YES\n";
    echo "   - Columns: " . implode(', ', Schema::getColumnListing('visitors')) . "\n";
    echo "   - Has 'created_at': " . (Schema::hasColumn('visitors', 'created_at') ? 'YES' : 'NO') . "\n";
    echo "   - Has 'updated_at': " . (Schema::hasColumn('visitors', 'updated_at') ? 'YES' : 'NO') . "\n";
    echo "   - Record count: " . DB::table('visitors')->count() . "\n";
} else {
    echo "   - Table exists: NO\n";
}

echo "\n";

// Check page_views table structure
echo "2. Checking 'page_views' table:\n";
if (Schema::hasTable('page_views')) {
    echo "   - Table exists: YES\n";
    echo "   - Columns: " . implode(', ', Schema::getColumnListing('page_views')) . "\n";
    echo "   - Record count: " . DB::table('page_views')->count() . "\n";
} else {
    echo "   - Table exists: NO\n";
}

echo "\n";

// Check products table structure
echo "3. Checking 'products' table:\n";
if (Schema::hasTable('products')) {
    echo "   - Table exists: YES\n";
    echo "   - Has 'status': " . (Schema::hasColumn('products', 'status') ? 'YES' : 'NO') . "\n";
    echo "   - Columns: " . implode(', ', Schema::getColumnListing('products')) . "\n";
} else {
    echo "   - Table exists: NO\n";
}

echo "\n=== End Diagnostic ===\n";