<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\ContentManagement;
use Illuminate\Support\Facades\DB;

echo "=== Testimonials Data Check ===\n\n";

// Check if content_management table exists
$tableExists = DB::select("SHOW TABLES LIKE 'content_management'");

if (empty($tableExists)) {
    echo "✗ content_management table does not exist!\n";
    echo "Please run the migration first.\n";
    exit;
} else {
    echo "✓ content_management table exists\n\n";
}

// Check table structure
echo "Table Structure:\n";
$columns = DB::select("DESCRIBE content_management");
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}

echo "\n";

// Check for testimonials section items
echo "Testimonials Section Items:\n";
$sectionItems = ContentManagement::where('section_name', 'testimonials_section')
    ->orderBy('id')
    ->get();

foreach ($sectionItems as $item) {
    echo "  ✓ {$item->section_item_name}: ";
    echo substr($item->section_content, 0, 50) . "...\n";
}

echo "\n";

// Check for testimonials (actual testimonial entries)
echo "Individual Testimonials:\n";
$testimonials = ContentManagement::where('section_name', 'testimonials')
    ->orderBy('id')
    ->get();

if ($testimonials->count() > 0) {
    echo "Found {$testimonials->count()} testimonial(s):\n";
    foreach ($testimonials as $testimonial) {
        echo "  - ID: {$testimonial->id}\n";
        echo "    Section Item Name: {$testimonial->section_item_name}\n";
        echo "    Section Content: " . substr($testimonial->section_content, 0, 100) . "...\n";

        // Try to decode JSON
        $data = json_decode($testimonial->section_content, true);
        if ($data) {
            echo "    ✓ JSON is valid\n";
            echo "    Name: " . ($data['name'] ?? 'N/A') . "\n";
            echo "    Company: " . ($data['company'] ?? 'N/A') . "\n";
        } else {
            echo "    ✗ JSON is invalid or not JSON\n";
        }
        echo "\n";
    }
} else {
    echo "  ✗ No testimonials found in database\n";
}

echo "\n";

// Check for any other testimonials-related data
echo "All Testimonials-Related Records:\n";
$allTestimonials = ContentManagement::where('section_name', 'like', '%testimonial%')
    ->orWhere('section_item_name', 'like', '%testimonial%')
    ->orderBy('id')
    ->get();

echo "Total records found: " . $allTestimonials->count() . "\n";

foreach ($allTestimonials as $record) {
    echo "  - Section: {$record->section_name} | Item: {$record->section_item_name}\n";
}

echo "\n=== End Check ===\n";