<x-layouts.app title="Brand Statement - Migration Needed">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-2xl p-8 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 2.667 1.732 4l6.736 3.546c.77 1.333 2.693 1.333 3.464 0l4.736-3.546c.77-1.333.192-2.667-1.732-4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-yellow-800 dark:text-yellow-200 mb-2">Database Migration Needed</h2>
                    <p class="text-yellow-700 dark:text-yellow-300 mb-4">
                        The brand statement functionality requires additional database columns to be added to your <code class="bg-yellow-100 dark:bg-yellow-900 px-2 py-1 rounded">hero_sections</code> table.
                    </p>
                    <p class="text-sm text-yellow-600 dark:text-yellow-400 mb-4">
                        Don't worry! This is a quick fix and won't affect your existing data.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-brand-500 to-brand-700 p-6">
                <h3 class="text-xl font-bold text-white">Quick Fix - Two Options</h3>
            </div>

            <div class="p-8 space-y-8">
                <!-- Option 1 -->
                <div class="border-l-4 border-green-500 pl-6 py-2">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Option 1: Run Migration (Recommended)</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Run this command in your terminal:</p>
                    <div class="bg-gray-900 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <code class="text-green-400">php artisan migrate</code>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ✅ Safest option • ✅ Reversible • ✅ No data loss
                    </p>
                </div>

                <!-- Option 2 -->
                <div class="border-l-4 border-blue-500 pl-6 py-2">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Option 2: Manual SQL (Immediate)</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Execute this SQL in your database (phpMyAdmin, MySQL Workbench, etc.):</p>
                    <div class="bg-gray-900 dark:bg-gray-700 rounded-lg p-4 mb-4 overflow-x-auto">
                        <pre class="text-blue-400 text-sm"><code>ALTER TABLE `hero_sections`
ADD COLUMN `stats` JSON NULL COMMENT 'Brand statement statistics',
ADD COLUMN `image_url` VARCHAR(255) NULL COMMENT 'Brand statement image URL',
ADD COLUMN `overlay_title` VARCHAR(255) NULL COMMENT 'Brand statement overlay title',
ADD COLUMN `overlay_text` VARCHAR(255) NULL COMMENT 'Brand statement overlay text';</code></pre>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        ⚡ Immediate fix • ✅ Works instantly • 🔧 Manual process
                    </p>
                </div>
            </div>

            <!-- What This Does -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                <h4 class="text-lg font-bold text-blue-900 dark:text-blue-200 mb-3">📋 What This Migration Does:</h4>
                <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-300">
                    <li>✅ <strong>Adds 4 columns</strong> to the hero_sections table for brand statement data</li>
                    <li>✅ <strong>Preserves existing</strong> hero section data (no changes to current content)</li>
                    <li>✅ <strong>Enables brand statement</strong> management in the admin panel</li>
                    <li>✅ <strong>Fully reversible</strong> - can be rolled back if needed</li>
                </ul>
            </div>

            <!-- After Migration -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                <h4 class="text-lg font-bold text-green-900 dark:text-green-200 mb-3">🚀 After Migration:</h4>
                <ol class="space-y-2 text-sm text-green-800 dark:text-green-300">
                    <li><strong>1.</strong> Click the button below to check if migration worked</li>
                    <li><strong>2.</strong> You'll be redirected to the brand statement management page</li>
                    <li><strong>3.</strong> All features will be functional and ready to use!</li>
                </ol>
            </div>

            <!-- Action Button -->
            <div class="text-center">
                <a href="{{ route('admin.brand-statements.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-brand-500 text-white rounded-xl font-bold hover:bg-brand-600 transition-all shadow-lg hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    I've Run the Migration - Take Me to Brand Statement
                </a>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="mt-8 bg-gray-50 dark:bg-surface-800 rounded-xl p-6">
            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">🔧 Technical Details:</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                The original hero_sections table was designed for hero section content only. Brand statements need additional fields (statistics, image URL, overlay content) which are being added through this migration.
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                <strong>Table location:</strong> <code>influx_group.hero_sections</code><br>
                <strong>Migration file:</strong> <code>2026_05_12_140000_add_brand_statement_fields_to_hero_sections.php</code>
            </p>
        </div>
    </div>
</x-layouts.app>