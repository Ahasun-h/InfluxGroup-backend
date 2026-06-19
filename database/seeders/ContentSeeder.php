<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Project;
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

        // Journey Section in content_management table
        $journeyData = [
            'journey_title' => 'Our Journey',
            'journey_description' => 'Four decades of excellence in powering Bangladesh\'s development',
            'Journey_1_year' => '1980',
            'Journey_1_title' => 'Foundation',
            'Journey_1_description' => 'Influx Group established as a small electrical contractor',
            'Journey_2_year' => '1995',
            'Journey_2_title' => 'Expansion',
            'Journey_2_description' => 'Entered power transmission and distribution sector',
            'Journey_3_year' => '2005',
            'Journey_3_title' => 'Manufacturing',
            'Journey_3_description' => 'Started manufacturing transformers and switchgear',
            'Journey_4_year' => '2015',
            'Journey_4_title' => 'Renewables',
            'Journey_4_description' => 'Diversified into solar and wind energy solutions',
            'Journey_5_year' => '2026',
            'Journey_5_title' => 'Regional Hub',
            'Journey_5_description' => 'Expanded operations across South Asia',
        ];

        foreach ($journeyData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'journey', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Mission & Vision Section
        $mvData = [
            'mission_title' => 'Our Mission',
            'mission_description' => 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
            'mission_points' => json_encode([
                'Powering Bangladesh\'s development through innovative energy solutions',
                'Ensuring energy security for future generations',
                'Building sustainable infrastructure nationwide'
            ]),
            'vision_title' => 'Our Vision',
            'vision_description' => 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
            'vision_points' => json_encode([
                'Regional leadership in sustainable infrastructure development',
                'Global recognition for engineering excellence',
                'Pioneering renewable energy adoption'
            ]),
        ];

        foreach ($mvData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Hero Section
        $heroData = [
            'hero_section_badge_text' => 'Leaders in Energy & Infrastructure',
            'hero_section_title' => 'POWERING BANGLADESH SINCE 1980',
            'hero_section_description' => 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
            'hero_section_primary_cta_text' => 'EXPLORE CATALOG',
            'hero_section_primary_cta_link' => '/projects',
            'hero_section_secondary_cta_text' => 'OUR CAPABILITIES',
            'hero_section_secondary_cta_link' => '/services',
            'hero_section_Background' => null,
        ];

        foreach ($heroData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'hero_section', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Brand Statements Section
        $brandData = [
            'brand_statements_title' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
            'brand_statements_description' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
            'brand_statements_image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
            'brand_statements_overlay_title' => 'Core Reliability',
            'brand_statements_overlay_text' => 'Zero Downtime Operation Protocols',
            'brand_statements_stat1' => json_encode(['value' => '45+', 'label' => 'Years Experience', 'order' => 1]),
            'brand_statements_stat2' => json_encode(['value' => '15GW', 'label' => 'Power Generated', 'order' => 2]),
            'brand_statements_stat3' => json_encode(['value' => '500+', 'label' => 'Global Projects', 'order' => 3]),
        ];

        foreach ($brandData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'brand_statements_section', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Homepage Stats
        $statsData = [
            'stats_projects_completed' => '500+',
            'stats_years_experience' => '45+',
            'stats_happy_clients' => '150+',
            'stats_awards_won' => '25+',
        ];

        foreach ($statsData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'homepage_stats', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // CTA Section
        $ctaData = [
            'cta_title' => 'Ready to Start Your Project?',
            'cta_description' => 'Contact us today to discuss how we can help bring your vision to life.',
            'cta_button_text' => 'Get in Touch',
            'cta_button_link' => '/contact',
        ];

        foreach ($ctaData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'cta_section', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Section Titles & Headings
        $headingsData = [
            'services_title' => 'Our Services',
            'services_subtitle' => 'Comprehensive construction and engineering solutions',
            'projects_title' => 'Featured Projects',
            'projects_subtitle' => 'Discover our portfolio of successful projects',
            'testimonials_title' => 'What Our Clients Say',
            'testimonials_subtitle' => 'Trusted by leading organizations across Bangladesh',
        ];

        foreach ($headingsData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'homepage_headings', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }

        // Core Values Section
        $coreValuesData = [
            'core_values_title' => 'Core Values',
            'core_values_subtitle' => 'The principles that guide everything we do',
            'core_value_1_title' => 'Safety First',
            'core_value_1_description' => 'Zero-compromise approach to workplace and operational safety',
            'core_value_1_icon' => 'ShieldCheck',
            'core_value_2_title' => 'Quality Excellence',
            'core_value_2_description' => 'ISO 9001:2015 certified processes and international standards',
            'core_value_2_icon' => 'Award',
            'core_value_3_title' => 'Customer Focus',
            'core_value_3_description' => 'Dedicated to delivering beyond client expectations',
            'core_value_3_icon' => 'Users',
            'core_value_4_title' => 'Innovation Driven',
            'core_value_4_description' => 'Continuous investment in R&D and cutting-edge technology',
            'core_value_4_icon' => 'TrendingUp',
        ];

        foreach ($coreValuesData as $key => $value) {
            \App\Models\ContentManagement::updateOrCreate(
                ['section_name' => 'core_values', 'section_item_name' => $key],
                ['section_content' => $value]
            );
        }
    }
}

