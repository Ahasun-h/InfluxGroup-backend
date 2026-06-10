<x-layouts.app title="Brand Statement Management">

    @php
        // Helper function to get content from brand items
        $getBrandContent = function($brandItems, $itemKey, $default = '') {
            if (isset($brandItems[$itemKey]) && $brandItems[$itemKey]->section_content) {
                return $brandItems[$itemKey]->section_content;
            }
            return $default;
        };

        // Helper function to get stats
        $getBrandStats = function($brandItems) {
            $stats = [];
            for ($i = 1; $i <= 4; $i++) {
                $statKey = 'brand_statements_stat' . $i;
                if (isset($brandItems[$statKey]) && $brandItems[$statKey]->section_content) {
                    $statData = json_decode($brandItems[$statKey]->section_content, true);
                    if ($statData) {
                        $stats[] = $statData;
                    }
                }
            }
            return collect($stats)->sortBy('order')->values();
        };

        // Get current image URL
        $currentImage = $getBrandContent($brandItems, 'brand_statements_image', '');
    @endphp

    @push('styles')
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css" />
    <style>
        /* Ensure Dropify input is always visible */
        #image-upload.dropify {
            display: block !important;
        }
        /* Fix Dropify wrapper visibility */
        .dropify-wrapper {
            display: block !important;
        }
        /* Manual URL input validation styling */
        #manual-image-url:valid {
            border-color: #10b981;
        }
        #manual-image-url:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
    @endpush

    <!-- jQuery (needed for Dropify) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Dropify JS - Try multiple CDNs -->
    <script>
        // Try to load Dropify from primary CDN
        var dropifyScript = document.createElement('script');
        dropifyScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js';
        dropifyScript.onerror = function() {
            console.warn('Primary Dropify CDN failed, trying jsdelivr...');
            // Try jsdelivr CDN as backup
            var backupScript = document.createElement('script');
            backupScript.src = 'https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js';
            backupScript.onerror = function() {
                console.error('✗ Dropify failed to load from all CDNs');
            };
            backupScript.onload = function() {
                console.log('✓ Dropify loaded from jsdelivr CDN');
            };
            document.head.appendChild(backupScript);
        };
        dropifyScript.onload = function() {
            console.log('✓ Dropify loaded from cdnjs');
        };
        document.head.appendChild(dropifyScript);
    </script>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Brand Statement Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your brand statement section from here</p>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
            </div>

            <!-- Brand Statement Preview -->
            <section class="py-12 md:py-20 bg-white text-industrial-dark rounded-xl border border-gray-200 dark:border-surface-600 overflow-hidden">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark">
                                <span class="editable-title" data-field="title">
                                    {{ $getBrandContent($brandItems, 'brand_statements_title', 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING') }}
                                </span>
                                <button onclick="editField('title')" class="inline-block ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                            </h2>

                            <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8 editable-description" data-field="description">
                                {{ $getBrandContent($brandItems, 'brand_statements_description', 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.') }}
                                <button onclick="editField('description')" class="ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                            </p>

                            <div class="grid grid-cols-2 gap-8 md:gap-12">
                                @foreach($getBrandStats($brandItems)->take(4) as $stat)
                                    <div class="border-l-4 border-industrial-blue pl-4 md:pl-6 py-2 relative group">
                                        <button onclick="editStat({{ $stat['order'] }})" class="absolute top-0 right-0 w-5 h-5 bg-brand-500/10 hover:bg-brand-500 rounded-full flex items-center justify-center text-brand-500 hover:text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <div class="text-2xl md:text-3xl font-display font-black text-industrial-blue editable-stat{{ $stat['order'] }}-value" data-field="stat{{ $stat['order'] }}_value">
                                            {{ $stat['value'] }}
                                        </div>
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 editable-stat{{ $stat['order'] }}-label" data-field="stat{{ $stat['order'] }}_label">
                                            {{ $stat['label'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="relative group overflow-hidden rounded-sm h-[300px] md:h-[400px]">
                            <button onclick="editField('image_url')" class="absolute top-4 right-4 z-50 w-10 h-10 bg-brand-500 hover:bg-brand-700 rounded-full flex items-center justify-center text-white transition-all shadow-lg hover:scale-110 border-2 border-white opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>

                            <img id="brand-image" src="{{ $getBrandContent($brandItems, 'brand_statements_image', 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200') }}"
                                 class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110"
                                 onerror="this.src='https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'" />

                            <div class="absolute inset-0 bg-industrial-blue/10 mix-blend-multiply"></div>

                            <div class="absolute bottom-6 md:bottom-10 left-6 md:left-10 p-6 md:p-8 bg-industrial-blue text-white shadow-2xl max-w-[200px] md:max-w-xs transition-all">
                                <button onclick="editField('overlay_title')" class="absolute top-2 right-2 w-5 h-5 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 hover:opacity-100 transition-opacity">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>

                                <div class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 opacity-70 editable-overlay-title" data-field="overlay_title">
                                    {{ $getBrandContent($brandItems, 'brand_statements_overlay_title', 'Core Reliability') }}
                                </div>

                                <div class="text-lg md:text-xl font-display font-bold italic leading-tight editable-overlay-text" data-field="overlay_text">
                                    "{{ $getBrandContent($brandItems, 'brand_statements_overlay_text', 'Zero Downtime Operation Protocols') }}"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Quick Links -->
        <div class="glass-card p-8 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Homepage Content</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage other homepage sections</p>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Dashboard</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Back to main dashboard</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Settings</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Company settings</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Hidden form for field updates -->
    <form id="brand-form" action="{{ route('admin.brand-statements.update') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="title" value="{{ $getBrandContent($brandItems, 'brand_statements_title', '') }}">
        <input type="hidden" name="description" value="{{ $getBrandContent($brandItems, 'brand_statements_description', '') }}">
        <input type="hidden" name="image_url" value="{{ $getBrandContent($brandItems, 'brand_statements_image', '') }}">
        <input type="hidden" name="overlay_title" value="{{ $getBrandContent($brandItems, 'brand_statements_overlay_title', '') }}">
        <input type="hidden" name="overlay_text" value="{{ $getBrandContent($brandItems, 'brand_statements_overlay_text', '') }}">

        @foreach($getBrandStats($brandItems)->take(4) as $stat)
            <input type="hidden" name="stat{{ $stat['order'] }}_value" value="{{ $stat['value'] }}">
            <input type="hidden" name="stat{{ $stat['order'] }}_label" value="{{ $stat['label'] }}">
        @endforeach
    </form>

    <!-- Single Field Edit Modal -->
    <div id="field-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="field-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Field</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-field-name">

                <!-- Text Input (default) -->
                <div id="text-input-group">
                    <label id="field-label" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Field Value</label>
                    <textarea id="field-input" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                </div>

                <!-- Image Upload (for image_url field) -->
                <div id="image-input-group" class="hidden">
                    <label id="image-field-label" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Image</label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Drag & drop an image, click to browse, or paste a URL below</p>

                    <input type="file" id="image-upload" class="dropify" accept="image/*" />
                    <input type="hidden" id="image-url-input" />

                    <!-- Manual URL input with enhanced styling -->
                    <div class="mt-4 p-4 bg-gray-50 dark:bg-surface-700 rounded-lg border border-gray-200 dark:border-surface-600">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656-5.656l4-4a4 4 0 00-5.656 5.656l1.101 1.101M5 22h14"></path>
                            </svg>
                            <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">Or paste image URL:</label>
                        </div>
                        <input type="text" id="manual-image-url"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-colors"
                               placeholder="https://example.com/image.jpg or https://unsplash.com/..."
                        />
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">✨ Press Enter or click away to preview the image</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeFieldModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveField()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Edit Modal -->
    <div id="stat-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="stat-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Stat</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-stat">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Value</label>
                    <input type="text" id="stat-value" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Label</label>
                    <input type="text" id="stat-label" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeStatModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveStat()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Stat</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dropifyInstance = null;

        // Make functions available globally for debugging
        window.checkDropifyStatus = function() {
            console.log('=== Dropify Status Check ===');
            console.log('jQuery:', typeof window.$ !== 'undefined' ? '✓' : '✗');
            console.log('Dropify plugin:', typeof window.$ !== 'undefined' && typeof window.$.fn.dropify !== 'undefined' ? '✓' : '✗');
            console.log('Dropify instance:', dropifyInstance ? '✓' : '✗');

            const dropifyScript = document.querySelector('script[src*="dropify"]');
            if (dropifyScript) {
                console.log('Script element:', '✓ found');
                console.log('Script src:', dropifyScript.src);
                console.log('Script readyState:', dropifyScript.readyState || 'N/A');
            } else {
                console.log('Script element:', '✗ not found');
            }

            return {
                jquery: typeof window.$ !== 'undefined',
                dropify: typeof window.$ !== 'undefined' && typeof window.$.fn.dropify !== 'undefined',
                instance: dropifyInstance !== null
            };
        };

        // Check if Dropify is ready (jQuery and Dropify loaded)
        function checkDropifyReady() {
            return (typeof window.$ !== 'undefined' && typeof window.$.fn.dropify !== 'undefined');
        }

        // Initialize when DOM is ready with retry logic
        window.addEventListener('DOMContentLoaded', function() {
            // Check multiple times with increasing delays
            const checkAttempts = [100, 500, 1000, 2000];

            checkAttempts.forEach(function(delay, index) {
                setTimeout(function() {
                    const isReady = checkDropifyReady();

                    if (index === 0) {
                        // First check - show full status
                        console.log('=== Brand Statements Debug ===');
                        console.log('jQuery:', typeof window.$ !== 'undefined' ? '✓ loaded' : '✗ not loaded');

                        // Check if Dropify script element exists
                        const dropifyScript = document.querySelector('script[src*="dropify"]');
                        console.log('Dropify script element:', dropifyScript ? '✓ found' : '✗ not found');

                        if (dropifyScript) {
                            console.log('  - src:', dropifyScript.src);
                            console.log('  - loaded:', dropifyScript.readyState || 'loading');
                        }

                        console.log('Dropify plugin:', typeof window.$.fn.dropify !== 'undefined' ? '✓ loaded' : '✗ not loaded');
                    }

                    if (isReady && index === 0) {
                        console.log('✓ Dropify is ready to use!');
                    } else if (index === checkAttempts.length - 1 && !isReady) {
                        console.warn('✗ Dropify.js not loaded after all retries. Will use basic file input.');
                        console.log('Workaround: You can still paste image URLs in the manual input field.');
                    } else if (isReady) {
                        console.log('✓ Dropify loaded on attempt #' + (index + 1));
                    }
                }, delay);
            });
        });

        // Field editing functions
        function editField(fieldName) {
            const modal = document.getElementById('field-modal');
            const title = document.getElementById('field-modal-title');
            const fieldNameInput = document.getElementById('current-field-name');
            const textInputGroup = document.getElementById('text-input-group');
            const imageInputGroup = document.getElementById('image-input-group');

            fieldNameInput.value = fieldName;

            const titles = {
                'title': 'Edit Title',
                'description': 'Edit Description',
                'image_url': 'Edit Image URL',
                'overlay_title': 'Edit Overlay Title',
                'overlay_text': 'Edit Overlay Text'
            };

            title.textContent = titles[fieldName] || 'Edit Field';

            // Check if this is an image field
            if (fieldName === 'image_url') {
                textInputGroup.classList.add('hidden');
                imageInputGroup.classList.remove('hidden');

                // Get current image URL
                const currentImageUrl = document.getElementById('brand-image').src;

                // Destroy existing Dropify instance
                if (dropifyInstance) {
                    try {
                        dropifyInstance.destroy();
                    } catch (e) {
                        console.warn('Error destroying Dropify:', e);
                    }
                    dropifyInstance = null;
                }

                // Initialize values
                const dropifyInput = document.getElementById('image-upload');
                if (dropifyInput) {
                    dropifyInput.setAttribute('data-default-file', currentImageUrl);
                    dropifyInput.style.display = '';
                }
                document.getElementById('image-url-input').value = currentImageUrl;
                document.getElementById('manual-image-url').value = currentImageUrl;

                // Check if Dropify is available and initialize
                if (checkDropifyReady()) {
                    try {
                        // Use window.$ to be explicit
                        dropifyInstance = window.$('#image-upload').dropify({
                            messages: {
                                'default': 'Drag and drop an image here or click',
                                'replace': 'Drag and drop or click to replace',
                                'remove':  'Remove',
                                'error':   'Ooops, something wrong happened.'
                            }
                        });

                        // Handle Dropify events
                        dropifyInstance.on('dropify.afterClear', function() {
                            document.getElementById('image-url-input').value = '';
                            document.getElementById('manual-image-url').value = '';
                        });

                        // Handle file selection - update URL input when file is selected
                        dropifyInstance.on('dropify.change', function(event, element) {
                            console.log('File selected via Dropify');
                            // Create object URL for preview
                            const file = element.files[0];
                            if (file) {
                                const objectUrl = URL.createObjectURL(file);
                                document.getElementById('image-url-input').value = objectUrl;
                                document.getElementById('manual-image-url').value = objectUrl;
                            }
                        });

                        console.log('✓ Dropify initialized successfully');
                    } catch (e) {
                        console.warn('✗ Dropify initialization error:', e);
                        console.log('Falling back to basic file input');
                    }
                } else {
                    console.log('✗ Dropify not available, using basic file input');
                    console.log('  jQuery:', typeof window.$ !== 'undefined' ? 'loaded' : 'NOT loaded');
                    console.log('  Dropify:', typeof window.$ !== 'undefined' && typeof window.$.fn.dropify !== 'undefined' ? 'loaded' : 'NOT loaded');
                }

                // Setup manual URL input with debounce for better UX
                const manualInput = document.getElementById('manual-image-url');

                // Remove any existing event listeners by cloning
                const newManualInput = manualInput.cloneNode(true);
                manualInput.parentNode.replaceChild(newManualInput, manualInput);

                // Debounce function for URL input
                let urlUpdateTimeout;
                const debouncedUpdate = function(url) {
                    clearTimeout(urlUpdateTimeout);
                    urlUpdateTimeout = setTimeout(function() {
                        document.getElementById('image-url-input').value = url;

                        // Update Dropify preview if available and URL is valid
                        if (url && dropifyInstance && checkDropifyReady()) {
                            try {
                                // Check if URL looks like an image URL
                                if (url.match(/\.(jpg|jpeg|png|gif|webp|svg|bmp)(\?.*)?$/i) ||
                                    url.includes('http') ||
                                    url.includes('data:image')) {

                                    // Reset and set new preview with URL
                                    dropifyInstance.resetPreview();
                                    dropifyInstance.setPreview(url, url);
                                    dropifyInstance.settings.defaultFile = url;

                                    // Update the input element's data-default-file attribute
                                    const dropifyEl = document.getElementById('image-upload');
                                    if (dropifyEl) {
                                        dropifyEl.setAttribute('data-default-file', url);
                                    }

                                    console.log('✓ Dropify preview updated:', url.substring(0, 50) + '...');
                                }
                            } catch (error) {
                                console.warn('✗ Error updating Dropify preview:', error);
                            }
                        }
                    }, 500); // 500ms debounce
                };

                // Add input event listener with debounce
                document.getElementById('manual-image-url').addEventListener('input', function(e) {
                    const url = e.target.value;
                    debouncedUpdate(url);
                });

                // Handle paste event (immediate update)
                document.getElementById('manual-image-url').addEventListener('paste', function(e) {
                    setTimeout(() => {
                        const url = e.target.value;
                        if (url) {
                            document.getElementById('image-url-input').value = url;
                            if (dropifyInstance && checkDropifyReady()) {
                                console.log('📋 URL pasted, updating preview...');
                            }
                        }
                    }, 10);
                });

                // Handle blur event (final update when leaving field)
                document.getElementById('manual-image-url').addEventListener('blur', function(e) {
                    const url = e.target.value.trim();
                    if (url && dropifyInstance && checkDropifyReady()) {
                        try {
                            if (url.match(/\.(jpg|jpeg|png|gif|webp|svg|bmp)(\?.*)?$/i) ||
                                url.includes('http') ||
                                url.includes('data:image')) {
                                dropifyInstance.resetPreview();
                                dropifyInstance.setPreview(url, url);
                                dropifyInstance.settings.defaultFile = url;
                                console.log('✓ Final preview updated');
                            }
                        } catch (error) {
                            console.warn('✗ Error on blur:', error);
                        }
                    }
                });

            } else {
                // Show text input
                imageInputGroup.classList.add('hidden');
                textInputGroup.classList.remove('hidden');

                const input = document.getElementById('field-input');
                const label = document.getElementById('field-label');

                const labels = {
                    'title': 'Title',
                    'description': 'Description',
                    'overlay_title': 'Overlay Title',
                    'overlay_text': 'Overlay Text'
                };

                label.textContent = labels[fieldName] || 'Field Value';

                // Get current value from the page
                const element = document.querySelector(`[data-field="${fieldName}"]`);
                if (element) {
                    // Handle text content with quotes
                    let text = element.textContent;
                    if (text.startsWith('"') && text.endsWith('"')) {
                        text = text.slice(1, -1);
                    }
                    input.value = text.trim();
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeFieldModal() {
            const modal = document.getElementById('field-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // Destroy Dropify instance when closing (if it exists)
            if (dropifyInstance && typeof dropifyInstance.destroy === 'function') {
                try {
                    dropifyInstance.destroy();
                } catch (e) {
                    console.warn('Error destroying Dropify instance:', e);
                }
                dropifyInstance = null;
            }
        }

        function saveField() {
            const fieldName = document.getElementById('current-field-name').value;
            let value;

            // Get value based on field type
            if (fieldName === 'image_url') {
                value = document.getElementById('image-url-input').value;
            } else {
                value = document.getElementById('field-input').value;

                // Add quotes back for overlay text
                if (fieldName === 'overlay_text' && !value.startsWith('"')) {
                    value = '"' + value + '"';
                }
            }

            // Update the preview
            const element = document.querySelector(`[data-field="${fieldName}"]`);
            if (element) {
                element.textContent = value;
            } else if (fieldName === 'image_url') {
                document.getElementById('brand-image').src = value;
            }

            // Update the form value
            const formInput = document.querySelector(`#brand-form [name="${fieldName}"]`);
            if (formInput) {
                formInput.value = value;
            }

            closeFieldModal();

            // Auto-submit the form
            document.getElementById('brand-form').submit();
        }

        // Stat editing functions
        function editStat(statId) {
            const modal = document.getElementById('stat-modal');
            const valueInput = document.getElementById('stat-value');
            const labelInput = document.getElementById('stat-label');
            const statInput = document.getElementById('current-stat');
            const modalTitle = document.getElementById('stat-modal-title');

            statInput.value = statId;
            modalTitle.textContent = 'Edit Stat ' + statId;

            // Get current values
            valueInput.value = document.querySelector(`[data-field="stat${statId}_value"]`)?.textContent || '';
            labelInput.value = document.querySelector(`[data-field="stat${statId}_label"]`)?.textContent || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStatModal() {
            const modal = document.getElementById('stat-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveStat() {
            const statId = document.getElementById('current-stat').value;
            const value = document.getElementById('stat-value').value;
            const label = document.getElementById('stat-label').value;

            // Update the preview
            const valueElement = document.querySelector(`[data-field="stat${statId}_value"]`);
            const labelElement = document.querySelector(`[data-field="stat${statId}_label"]`);

            if (valueElement) valueElement.textContent = value;
            if (labelElement) labelElement.textContent = label;

            // Update the form values
            const valueInput = document.querySelector(`input[name="stat${statId}_value"]`);
            const labelInput = document.querySelector(`input[name="stat${statId}_label"]`);

            if (valueInput) valueInput.value = value;
            if (labelInput) labelInput.value = label;

            closeStatModal();

            // Auto-submit the form
            document.getElementById('brand-form').submit();
        }

        // Close modals on outside click and initialize
        (function() {
            // Setup modal click handlers
            const fieldModal = document.getElementById('field-modal');
            if (fieldModal) {
                fieldModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeFieldModal();
                    }
                });
            }

            const statModal = document.getElementById('stat-modal');
            if (statModal) {
                statModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeStatModal();
                    }
                });
            }

            // Show success message if any
            @if(session('success'))
                setTimeout(() => {
                    alert('{{ session('success') }}');
                }, 100);
            @endif

            console.log('Brand statements page initialized');
        })();
    </script>
</x-layouts.app>
