<?php

namespace App\Console\Commands;

use App\Models\ContentManagement;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('journey:migrate-to-json')]
#[Description('Migrate journey data from old format (Journey_X_year/title/description) to new JSON format (Journey_X)')]
class MigrateJourneyDataToJson extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting journey data migration to JSON format...');

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get all old format journey items
            $oldJourneyItems = ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'regexp', '^Journey_[0-9]+_')
                ->get();

            if ($oldJourneyItems->isEmpty()) {
                $this->warn('No old format journey items found. Migration not needed.');
                return self::SUCCESS;
            }

            $this->info("Found {$oldJourneyItems->count()} old format items.");

            // Group items by journey number
            $journeyData = [];
            foreach ($oldJourneyItems as $item) {
                if (preg_match('/Journey_(\d+)_(year|title|description)$/', $item->section_item_name, $matches)) {
                    $journeyNum = $matches[1];
                    $field = $matches[2];

                    if (!isset($journeyData[$journeyNum])) {
                        $journeyData[$journeyNum] = [
                            'year' => '',
                            'title' => '',
                            'description' => ''
                        ];
                    }

                    $journeyData[$journeyNum][$field] = $item->section_content;
                }
            }

            $this->info("Found " . count($journeyData) . " journey milestones to migrate.");

            // Create new JSON format items
            $createdCount = 0;
            foreach ($journeyData as $journeyNum => $data) {
                // Check if journey has any content
                if (empty($data['year']) && empty($data['title']) && empty($data['description'])) {
                    $this->warn("Skipping journey {$journeyNum} - no content found.");
                    continue;
                }

                // Create new JSON format item
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'journey',
                        'section_item_name' => "Journey_{$journeyNum}"
                    ],
                    [
                        'section_content' => json_encode([
                            'year' => $data['year'],
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'order' => (int)$journeyNum
                        ]),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );

                $createdCount++;
                $this->info("✓ Migrated Journey_{$journeyNum}: {$data['title']} ({$data['year']})");
            }

            // Delete old format items
            $deletedCount = $oldJourneyItems->count();
            ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'regexp', '^Journey_[0-9]+_')
                ->delete();

            $this->info("Deleted {$deletedCount} old format items.");

            // Commit the transaction
            DB::commit();

            $this->info('✓ Migration completed successfully!');
            $this->info("  - Migrated: {$createdCount} journey milestones");
            $this->info("  - Deleted: {$deletedCount} old format rows");

            return self::SUCCESS;

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            $this->error('✗ Migration failed: ' . $e->getMessage());
            $this->error('Changes have been rolled back.');

            return self::FAILURE;
        }
    }
}
