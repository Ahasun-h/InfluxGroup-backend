<?php

namespace Database\Seeders;

use App\Models\ContentManagement;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create testimonials section content
        ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_subtitle'
            ],
            [
                'section_content' => 'Testimonials',
                'attributes' => null,
                'media_files' => null
            ]
        );

        ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_title'
            ],
            [
                'section_content' => 'What Our Clients Say',
                'attributes' => null,
                'media_files' => null
            ]
        );

        ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_description'
            ],
            [
                'section_content' => 'Trusted by leading organizations across Bangladesh and beyond',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Create sample testimonials
        $testimonials = [
            [
                'name' => 'Rahman Ali',
                'position' => 'Chief Engineer',
                'company' => 'Bangladesh Power Development Board',
                'content' => 'Influx Group has been our trusted partner for over 15 years. Their commitment to quality and timely delivery is unmatched in the industry.',
                'rating' => 5
            ],
            [
                'name' => 'Sarah Chen',
                'position' => 'Project Director',
                'company' => 'Asian Development Bank',
                'content' => 'The level of technical expertise and project management capability demonstrated by Influx Group is world-class. Highly recommended.',
                'rating' => 5
            ],
            [
                'name' => 'Mohammad Hassan',
                'position' => 'Managing Director',
                'company' => 'Pran-RFL Group',
                'content' => 'Their maintenance services have significantly improved our operational efficiency. A reliable partner for industrial power solutions.',
                'rating' => 5
            ]
        ];

        foreach ($testimonials as $testimonial) {
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'testimonials',
                    'section_item_name' => 'testimonial_' . strtolower(str_replace(' ', '', $testimonial['name'])) . time()
                ],
                [
                    'section_content' => json_encode($testimonial),
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }
    }
}