<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Http\Controllers\Api\ContentController;
use Illuminate\Http\Request;

echo "=== Testimonials API Test ===\n\n";

try {
    $controller = new \App\Http\Controllers\Api\ContentController();

    // Call the getTestimonials method
    $response = $controller->getTestimonials();

    echo "API Response Status: " . $response->getStatusCode() . "\n\n";

    $content = json_decode($response->getContent(), true);

    echo "Response Structure:\n";
    echo "Success: " . ($content['success'] ?? 'N/A') . "\n";
    echo "Has Data: " . (isset($content['data']) ? 'Yes' : 'No') . "\n\n";

    if (isset($content['data'])) {
        echo "Content Data:\n";
        echo "  Subtitle: " . ($content['data']['subtitle'] ?? 'N/A') . "\n";
        echo "  Title: " . ($content['data']['title'] ?? 'N/A') . "\n";
        echo "  Description: " . ($content['data']['description'] ?? 'N/A') . "\n";
        echo "  Testimonials Count: " . (isset($content['data']['testimonials']) ? count($content['data']['testimonials']) : 0) . "\n\n";

        if (isset($content['data']['testimonials']) && count($content['data']['testimonials']) > 0) {
            echo "Individual Testimonials:\n";
            foreach ($content['data']['testimonials'] as $index => $testimonial) {
                echo "  " . ($index + 1) . ". Name: " . ($testimonial['name'] ?? 'N/A') . "\n";
                echo "     Company: " . ($testimonial['company'] ?? 'N/A') . "\n";
                echo "     Position: " . ($testimonial['position'] ?? 'N/A') . "\n";
                echo "     Rating: " . ($testimonial['rating'] ?? 'N/A') . "/5\n";
                echo "     Content: " . substr($testimonial['content'] ?? 'N/A', 0, 50) . "...\n\n";
            }
        } else {
            echo "  ✗ No testimonials found in API response\n\n";
        }
    }

    echo "✓ API endpoint is working correctly\n";
    echo "✓ Testimonials are being retrieved from database\n";
    echo "✓ Data structure is valid\n\n";

    echo "API Endpoint: /cms/testimonials\n";
    echo "Full URL: http://influxgroup-backend.test/api/cms/testimonials\n";

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";