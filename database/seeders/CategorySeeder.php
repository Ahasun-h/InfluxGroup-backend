<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data from each content type
        $productCategories = \DB::table('products')->whereNotNull('category')->pluck('category')->unique();
        $projectCategories = \DB::table('projects')->whereNotNull('category')->pluck('category')->unique();
        $newsCategories = \DB::table('news')->whereNotNull('category')->pluck('category')->unique();

        // Create product categories
        foreach ($productCategories as $categoryName) {
            \App\Models\Category::firstOrCreate(
                [
                    'slug' => \Str::slug($categoryName),
                    'service_area' => 'product'
                ],
                [
                    'name' => $categoryName,
                    'is_active' => true,
                    'order' => 0
                ]
            );
        }

        // Create project categories
        foreach ($projectCategories as $categoryName) {
            \App\Models\Category::firstOrCreate(
                [
                    'slug' => \Str::slug($categoryName),
                    'service_area' => 'project'
                ],
                [
                    'name' => ucfirst($categoryName), // Capitalize first letter
                    'is_active' => true,
                    'order' => 0
                ]
            );
        }

        // Create news categories
        foreach ($newsCategories as $categoryName) {
            \App\Models\Category::firstOrCreate(
                [
                    'slug' => \Str::slug($categoryName),
                    'service_area' => 'news'
                ],
                [
                    'name' => ucfirst(str_replace('-', ' ', $categoryName)), // Format category name
                    'is_active' => true,
                    'order' => 0
                ]
            );
        }

        // Create some default service categories
        $defaultServiceCategories = [
            'Engineering Services',
            'Consulting Services',
            'Maintenance Services',
            'Project Management'
        ];

        foreach ($defaultServiceCategories as $categoryName) {
            \App\Models\Category::firstOrCreate(
                [
                    'slug' => \Str::slug($categoryName),
                    'service_area' => 'service'
                ],
                [
                    'name' => $categoryName,
                    'is_active' => true,
                    'order' => 0
                ]
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
