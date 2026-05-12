<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Project;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Products
        Product::create([
            'name' => 'Power Transformer 250 MVA',
            'slug' => 'power-transformer-250-mva',
            'category' => 'transformers',
            'description' => 'High-efficiency power transformer for industrial applications.',
            'specifications' => ['capacity' => '250 MVA', 'voltage' => '230/66 kV'],
            'features' => ['Low losses design', 'Advanced protection systems'],
        ]);

        Product::create([
            'name' => 'GIS Switchgear 132kV',
            'slug' => 'gis-switchgear-132kv',
            'category' => 'switchgear',
            'description' => 'Gas Insulated Switchgear for compact urban substations.',
            'specifications' => ['voltage' => '132 kV', 'type' => 'GIS'],
            'features' => ['Compact footprint', 'High reliability'],
        ]);

        // Sample Projects
        Project::create([
            'title' => 'Matarbari Ultra Mega Power Project',
            'slug' => 'matarbari-ultra-mega-power-project',
            'location' => 'Cox\'s Bazar, Bangladesh',
            'category' => 'power',
            'status' => 'ongoing',
            'client' => 'BPDB',
            'highlights' => ['Largest power project in BD', 'Supercritical technology'],
            'featured' => true,
        ]);

        Project::create([
            'title' => 'Mongla 50MW Solar Park',
            'slug' => 'mongla-50mw-solar-park',
            'location' => 'Mongla, Bagerhat',
            'category' => 'renewable',
            'status' => 'completed',
            'client' => 'Sustainable Energy Ltd',
            'featured' => true,
        ]);

        // Sample News
        News::create([
            'title' => 'Influx Group Wins Infrastructure Award 2026',
            'slug' => 'influx-group-wins-infrastructure-award-2026',
            'category' => 'company-updates',
            'excerpt' => 'Recognized for excellence in power infrastructure development.',
            'content' => '<p>Influx Group has been honored with the Infrastructure Excellence Award 2026...</p>',
            'published_at' => now(),
            'featured' => true,
        ]);
    }
}
