<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentManagement;
use Illuminate\Support\Facades\DB;

class FooterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all expected footer item names
        $expectedItemNames = [
            'footer_company_description',
            'footer_company_logo',
            'footer_social_media_1',
            'footer_social_media_2',
            'footer_social_media_3',
            'footer_copyright_text',
            'footer_iso_certification',
            'footer_show_iso_badge',
        ];

        // Check which items already exist
        $existingItems = ContentManagement::where('section_name', 'footer_section')
            ->whereIn('section_item_name', $expectedItemNames)
            ->pluck('section_item_name')
            ->toArray();

        $missingItems = array_diff($expectedItemNames, $existingItems);

        if (empty($missingItems)) {
            $this->command->info('All footer data already exists. Skipping seeder.');
            return;
        }

        $this->command->info('Found ' . count($existingItems) . ' existing footer items.');
        $this->command->info('Creating ' . count($missingItems) . ' missing footer items.');

        $footerSection = 'footer_section';

        $footerData = [
            // Company Description
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_company_description',
                'section_content' => 'Bangladesh\'s premier engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems since 1980.',
                'attributes' => json_encode(['label' => 'Company Description']),
            ],

            // Company Logo (optional - can be added later)
            // [
            //     'section_name' => $footerSection,
            //     'section_item_name' => 'footer_company_logo',
            //     'section_content' => '',
            //     'media_files' => json_encode(['source_file' => '/path/to/logo.png']),
            // ],

            // Social Media Links
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_social_media_1',
                'section_content' => json_encode([
                    'platform' => 'facebook',
                    'url' => 'https://www.facebook.com/influxgroup',
                    'label' => 'Facebook'
                ]),
            ],
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_social_media_2',
                'section_content' => json_encode([
                    'platform' => 'linkedin',
                    'url' => 'https://www.linkedin.com/company/influxgroup',
                    'label' => 'LinkedIn'
                ]),
            ],
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_social_media_3',
                'section_content' => json_encode([
                    'platform' => 'youtube',
                    'url' => 'https://www.youtube.com/@influxgroup',
                    'label' => 'YouTube'
                ]),
            ],

            // Bottom Bar
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_copyright_text',
                'section_content' => '© 2026 INFLUX GROUP ENGINEERING. All Rights Reserved.',
                'attributes' => json_encode(['label' => 'Copyright Text']),
            ],
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_iso_certification',
                'section_content' => 'ISO 9001:2015',
                'attributes' => json_encode(['label' => 'ISO Certification']),
            ],
            [
                'section_name' => $footerSection,
                'section_item_name' => 'footer_show_iso_badge',
                'section_content' => 'true',
                'attributes' => json_encode(['label' => 'Show ISO Badge', 'type' => 'boolean']),
            ],
        ];

        foreach ($footerData as $data) {
            // Only create if this specific item doesn't exist
            if (!in_array($data['section_item_name'], $existingItems)) {
                ContentManagement::create($data);
            }
        }

        $this->command->info('Footer data seeded successfully!');
        $this->command->newLine();
        $this->command->info('Footer section items created:');
        $this->command->info('- Company Description');
        $this->command->info('- Social Media Links (Facebook, LinkedIn, YouTube)');
        $this->command->info('- Bottom Bar (Copyright, ISO Certification)');
        $this->command->newLine();
        $this->command->info('You can now edit these in the admin dashboard!');
    }
}
