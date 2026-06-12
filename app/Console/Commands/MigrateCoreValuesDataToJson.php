<?php

namespace App\Console\Commands;

use App\Models\ContentManagement;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('core-values:migrate-to-json')]
#[Description('Migrate core values data from old format (core_value_X_title/description/icon) to new JSON format (core_value_X)')]
class MigrateCoreValuesDataToJson extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting core values data migration to JSON format...');

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get all old format core value items
            $oldCoreValueItems = ContentManagement::where('section_name', 'core_values')
                ->where('section_item_name', 'regexp', '^core_value_[0-9]+_')
                ->get();

            if ($oldCoreValueItems->isEmpty()) {
                $this->warn('No old format core value items found. Migration not needed.');
                return self::SUCCESS;
            }

            $this->info("Found {$oldCoreValueItems->count()} old format items.");

            // Group items by core value number
            $coreValueData = [];
            foreach ($oldCoreValueItems as $item) {
                if (preg_match('/core_value_(\d+)_(title|description|icon)$/', $item->section_item_name, $matches)) {
                    $coreValueNum = $matches[1];
                    $field = $matches[2];

                    if (!isset($coreValueData[$coreValueNum])) {
                        $coreValueData[$coreValueNum] = [
                            'title' => '',
                            'description' => '',
                            'icon' => 'ShieldCheck'
                        ];
                    }

                    $coreValueData[$coreValueNum][$field] = $item->section_content;
                }
            }

            $this->info("Found " . count($coreValueData) . " core values to migrate.");

            // Create new JSON format items
            $createdCount = 0;
            foreach ($coreValueData as $coreValueNum => $data) {
                // Check if core value has any content
                if (empty($data['title']) && empty($data['description'])) {
                    $this->warn("Skipping core value {$coreValueNum} - no content found.");
                    continue;
                }

                // Ensure icon has a default value
                if (empty($data['icon'])) {
                    $data['icon'] = 'ShieldCheck';
                }

                // Create new JSON format item
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$coreValueNum}"
                    ],
                    [
                        'section_content' => json_encode([
                            'title' => $data['title'],
                            'description' => $data['description'],
                            'icon' => $data['icon'],
                            'order' => (int)$coreValueNum
                        ]),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );

                $createdCount++;
                $this->info("✓ Migrated core_value_{$coreValueNum}: {$data['title']}");
            }

            // Delete old format items
            $deletedCount = $oldCoreValueItems->count();
            ContentManagement::where('section_name', 'core_values')
                ->where('section_item_name', 'regexp', '^core_value_[0-9]+_')
                ->delete();

            $this->info("Deleted {$deletedCount} old format items.");

            // Commit the transaction
            DB::commit();

            $this->info('✓ Migration completed successfully!');
            $this->info("  - Migrated: {$createdCount} core values");
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
