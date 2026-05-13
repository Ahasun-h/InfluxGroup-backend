<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Project;
use App\Models\News;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Products
        Product::updateOrCreate(
            ['slug' => 'power-transformer-250-mva'],
            [
                'name' => 'Power Transformer 250 MVA',
                'category' => 'transformers',
                'description' => 'High-efficiency power transformer for industrial applications.',
                'specifications' => ['capacity' => '250 MVA', 'voltage' => '230/66 kV'],
                'features' => ['Low losses design', 'Advanced protection systems'],
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'gis-switchgear-132kv'],
            [
                'name' => 'GIS Switchgear 132kV',
                'category' => 'switchgear',
                'description' => 'Gas Insulated Switchgear for compact urban substations.',
                'specifications' => ['voltage' => '132 kV', 'type' => 'GIS'],
                'features' => ['Compact footprint', 'High reliability'],
            ]
        );

        // Sample Projects
        Project::updateOrCreate(
            ['slug' => 'matarbari-ultra-mega-power-project'],
            [
                'title' => 'Matarbari Ultra Mega Power Project',
                'location' => 'Cox\'s Bazar, Bangladesh',
                'category' => 'power',
                'status' => 'ongoing',
                'client' => 'BPDB',
                'highlights' => ['Largest power project in BD', 'Supercritical technology'],
                'featured' => true,
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'mongla-50mw-solar-park'],
            [
                'title' => 'Mongla 50MW Solar Park',
                'location' => 'Mongla, Bagerhat',
                'category' => 'renewable',
                'status' => 'completed',
                'client' => 'Sustainable Energy Ltd',
                'featured' => true,
            ]
        );

        // Sample News
        News::updateOrCreate(
            ['slug' => 'influx-group-wins-infrastructure-award-2026'],
            [
                'title' => 'Influx Group Wins Infrastructure Award 2026',
                'category' => 'company-updates',
                'excerpt' => 'Recognized for excellence in power infrastructure development.',
                'content' => '<p>Influx Group has been honored with the Infrastructure Excellence Award 2026...</p>',
                'published_at' => now(),
                'featured' => true,
            ]
        );

        // Sample Services
        Service::updateOrCreate(
            ['slug' => 'power-generation-solutions'],
            [
                'title' => 'Power Generation Solutions',
                'description' => 'Comprehensive power generation services from design to commissioning.',
                'features' => ['Custom engineering', 'Turnkey solutions', 'Maintenance support'],
                'order' => 1,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'transmission-distribution'],
            [
                'title' => 'Transmission & Distribution',
                'description' => 'High-voltage transmission line and substation construction.',
                'features' => ['EPC services', 'Substation automation', 'Grid integration'],
                'order' => 2,
            ]
        );

        // Sample Testimonials
        Testimonial::updateOrCreate(
            ['name' => 'John Doe'],
            [
                'position' => 'Chief Engineer',
                'company' => 'National Grid',
                'content' => 'Influx Group delivered exceptional results on our latest substation project.',
                'rating' => 5,
                'featured' => true,
                'order' => 1,
            ]
        );
    }
}
