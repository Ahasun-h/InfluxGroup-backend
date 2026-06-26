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

    <x-slot:styles>
        <!-- Dropify CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/dropify.min.css" />
        <style>
        /* Dropify custom styles */
        .dropify-wrapper {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: all 0.3s ease;
        }

        .dropify-wrapper:hover {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }

        .dropify-message p {
            font-size: 14px;
            color: #64748b;
        }

        .dropify-icon {
            color: #3b82f6;
        }

        .dropify-clear {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .dropify-clear:hover {
            background: rgba(220, 38, 38, 1);
            transform: scale(1.1);
        }

        /* Dark mode support */
        .dark .dropify-wrapper {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-color: #475569;
        }

        .dark .dropify-wrapper:hover {
            background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);
            border-color: #3b82f6;
        }

        .dark .dropify-message p {
            color: #94a3b8;
        }
    </style>
    </x-slot:styles>

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
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          Home Page
                    </span>
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
                                <button onclick="window.editField('title')" class="inline-block ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                            </h2>

                            <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8 editable-description" data-field="description">
                                {{ $getBrandContent($brandItems, 'brand_statements_description', 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.') }}
                                <button onclick="window.editField('description')" class="ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                            </p>

                            <div class="grid grid-cols-2 gap-8 md:gap-12">
                                @foreach($getBrandStats($brandItems)->take(4) as $stat)
                                    <div class="border-l-4 border-industrial-blue pl-4 md:pl-6 py-2 relative group">
                                        <button onclick="window.editStat({{ $stat['order'] }})" class="absolute top-0 right-0 w-5 h-5 bg-brand-500/10 hover:bg-brand-500 rounded-full flex items-center justify-center text-brand-500 hover:text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
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
                            <button onclick="window.editField('image_url')" class="absolute top-4 right-4 z-50 w-10 h-10 bg-brand-500 hover:bg-brand-700 rounded-full flex items-center justify-center text-white transition-all shadow-lg hover:scale-110 border-2 border-white opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>

                            <img id="brand-image" src="{{ $getBrandContent($brandItems, 'brand_statements_image', 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200') }}"
                                 class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110"
                                 onerror="this.src='https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'" />

                            <div class="absolute inset-0 bg-industrial-blue/10 mix-blend-multiply"></div>

                            <div class="absolute bottom-6 md:bottom-10 left-6 md:left-10 p-6 md:p-8 bg-industrial-blue text-white shadow-2xl max-w-[200px] md:max-w-xs transition-all">
                                <button onclick="window.editField('overlay_title')" class="absolute top-2 right-2 w-5 h-5 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 hover:opacity-100 transition-opacity">
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
                <a href="{{ route('admin.hero.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Hero Section</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage hero section content</p>
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
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Upload an image by drag & drop or click to browse</p>

                    <!-- Dropify Image Upload -->
                    <div class="dropify-wrapper">
                        <input type="file" id="image-upload" class="dropify" accept="image/*" data-default-file="{{ $getBrandContent($brandItems, 'brand_statements_image', '') }}" data-allowed-formats="portrait square landscape" data-max-file-size="5M" />
                        <input type="hidden" id="modal-image-url" value="{{ $getBrandContent($brandItems, 'brand_statements_image', '') }}" />
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="window.closeFieldModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="window.saveField()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save</button>
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
                    <button type="button" onclick="window.closeStatModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="window.saveStat()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Stat</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/dropify.min.js"></script>

        <script>
            (function() {
                console.log('=== Brand Statements Page Loaded ===');

                // Wait for libraries to be available
                function waitForLibraries(callback) {
                    const checkLibraries = function() {
                        if (typeof $ !== 'undefined' && typeof $.fn.dropify !== 'undefined') {
                            console.log('✓ jQuery and Dropify are ready');
                            callback();
                        } else {
                            console.log('Waiting for libraries...');
                            setTimeout(checkLibraries, 100);
                        }
                    };
                    checkLibraries();
                }

                // Dropify initialization
                function initDropify() {
                    if (typeof $ === 'undefined' || typeof $.fn.dropify === 'undefined') {
                        console.error('Libraries not loaded');
                        return false;
                    }

                    console.log('Looking for dropify elements...');
                    const dropifyElement = $('.dropify');
                    console.log('Dropify elements found:', dropifyElement.length);

                    if (dropifyElement.length === 0) {
                        console.warn('Dropify element not found');
                        return false;
                    }

                    // Destroy existing instance
                    if (dropifyElement.data('dropify')) {
                        console.log('Destroying existing Dropify instance');
                        dropifyElement.dropify('destroy');
                    }

                    try {
                        console.log('Initializing Dropify...');
                        const dr = dropifyElement.dropify({
                            messages: {
                                'default': 'Drag & drop an image here or click',
                                'replace': 'Drag & drop or click to replace',
                                'remove': 'Remove',
                                'error': 'Sorry, the file is too large'
                            },
                            error: {
                                'fileSize': 'The file size is too large (@{{ value }} max).',
                                'minWidth': 'The image width is too small (@{{ value }}px min).',
                                'maxWidth': 'The image width is too big (@{{ value }}px max).',
                                'minHeight': 'The image height is too small (@{{ value }}px min).',
                                'maxHeight': 'The image height is too big (@{{ value }}px max).',
                                'imageFormat': 'The image format is not allowed (@{{ value }} only).'
                            }
                        });

                        console.log('Dropify instance created:', !!dr);

                        // Handle Dropify events
                        dr.on('dropify.afterClear', function(event, element) {
                            console.log('✓ Image cleared');
                            $('#modal-image-url').val('');
                        });

                        dr.on('dropify.fileReady', function(event, element) {
                            console.log('✓ File selected, converting to base64...');

                            // Access the file through Dropify's element
                            const wrapper = $(element).closest('.dropify-wrapper');
                            const fileInput = wrapper.find('input[type="file"]');

                            console.log('File input found:', fileInput.length > 0);
                            console.log('Files in input:', fileInput[0].files.length);

                            if (fileInput.length > 0 && fileInput[0].files.length > 0) {
                                const file = fileInput[0].files[0];
                                console.log('Processing file:', file.name, file.type, file.size);

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const base64Url = e.target.result;
                                    $('#modal-image-url').val(base64Url);
                                    console.log('✓ Image converted to base64:', base64Url.substring(0, 50) + '...');
                                    console.log('✓ Modal image URL input value set');
                                };
                                reader.onerror = function(e) {
                                    console.error('✗ Failed to convert image:', e);
                                    alert('Failed to process image. Please try again.');
                                };
                                reader.readAsDataURL(file);
                            } else {
                                console.error('✗ No file found in input');
                                console.log('Available elements:', wrapper.html());
                            }
                        });

                        console.log('✓ Dropify initialized successfully');
                        return true;
                    } catch (error) {
                        console.error('✗ Dropify initialization failed:', error);
                        return false;
                    }
                }

                // Define all functions
                window.editStat = function(statId) {
                    console.log('editStat called with:', statId);
                    const modal = document.getElementById('stat-modal');
                    if (!modal) {
                        console.error('Stat modal not found!');
                        return;
                    }
                    const valueInput = document.getElementById('stat-value');
                    const labelInput = document.getElementById('stat-label');
                    const statInput = document.getElementById('current-stat');
                    const modalTitle = document.getElementById('stat-modal-title');

                    statInput.value = statId;
                    modalTitle.textContent = 'Edit Stat ' + statId;

                    valueInput.value = document.querySelector(`[data-field="stat${statId}_value"]`)?.textContent || '';
                    labelInput.value = document.querySelector(`[data-field="stat${statId}_label"]`)?.textContent || '';

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                };

                window.closeStatModal = function() {
                    const modal = document.getElementById('stat-modal');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                };

                window.saveStat = function() {
                    const statId = document.getElementById('current-stat').value;
                    const value = document.getElementById('stat-value').value;
                    const label = document.getElementById('stat-label').value;

                    const valueElement = document.querySelector(`[data-field="stat${statId}_value"]`);
                    const labelElement = document.querySelector(`[data-field="stat${statId}_label"]`);

                    if (valueElement) valueElement.textContent = value;
                    if (labelElement) labelElement.textContent = label;

                    const valueInput = document.querySelector(`input[name="stat${statId}_value"]`);
                    const labelInput = document.querySelector(`input[name="stat${statId}_label"]`);

                    if (valueInput) valueInput.value = value;
                    if (labelInput) labelInput.value = label;

                    window.closeStatModal();
                    document.getElementById('brand-form').submit();
                };

                window.editField = function(fieldName) {
                    console.log('editField called with:', fieldName);
                    const modal = document.getElementById('field-modal');
                    const title = document.getElementById('field-modal-title');
                    const fieldNameInput = document.getElementById('current-field-name');
                    const textInputGroup = document.getElementById('text-input-group');
                    const imageInputGroup = document.getElementById('image-input-group');

                    if (!modal) {
                        console.error('Modal not found!');
                        return;
                    }

                    fieldNameInput.value = fieldName;

                    const titles = {
                        'title': 'Edit Title',
                        'description': 'Edit Description',
                        'image_url': 'Edit Image URL',
                        'overlay_title': 'Edit Overlay Title',
                        'overlay_text': 'Edit Overlay Text'
                    };

                    title.textContent = titles[fieldName] || 'Edit Field';

                    if (fieldName === 'image_url') {
                        textInputGroup.classList.add('hidden');
                        imageInputGroup.classList.remove('hidden');

                        modal.classList.remove('hidden');
                        modal.classList.add('flex');

                        // Initialize Dropify after modal is visible and libraries are ready
                        setTimeout(function() {
                            waitForLibraries(function() {
                                const success = initDropify();
                                if (!success) {
                                    console.error('Failed to initialize Dropify');
                                    alert('Image upload failed to load. Please refresh the page.');
                                }
                            });
                        }, 300);

                    } else {
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

                        const element = document.querySelector(`[data-field="${fieldName}"]`);
                        if (element) {
                            let text = element.textContent;
                            if (text.startsWith('"') && text.endsWith('"')) {
                                text = text.slice(1, -1);
                            }
                            input.value = text.trim();
                        }

                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                };

                window.closeFieldModal = function() {
                    const modal = document.getElementById('field-modal');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                };

                window.saveField = function() {
                    console.log('=== saveField called ===');
                    const fieldName = document.getElementById('current-field-name').value;
                    console.log('Field name:', fieldName);

                    let value;

                    if (fieldName === 'image_url') {
                        const modalInput = document.getElementById('modal-image-url');
                        console.log('Modal image input found:', !!modalInput);
                        value = modalInput ? modalInput.value : '';
                        console.log('Raw modal value:', value ? value.substring(0, 50) + '...' : 'empty');
                        console.log('Modal value length:', value ? value.length : 0);

                        if (!value || value.trim() === '') {
                            alert('Please select an image first.');
                            return;
                        }
                    } else {
                        value = document.getElementById('field-input').value;

                        if (fieldName === 'overlay_text' && !value.startsWith('"')) {
                            value = '"' + value + '"';
                        }
                    }

                    console.log('Final value to save:', value ? value.substring(0, 50) + '...' : 'empty');

                    // Update the preview
                    if (fieldName === 'image_url') {
                        const brandImage = document.getElementById('brand-image');
                        if (brandImage) {
                            brandImage.src = value;
                            console.log('✓ Updated brand image src');
                        }
                    } else {
                        const element = document.querySelector(`[data-field="${fieldName}"]`);
                        if (element) {
                            element.textContent = value;
                            console.log('✓ Updated preview element');
                        }
                    }

                    // CRITICAL: Update the form input using multiple methods
                    console.log('=== Updating form input ===');
                    const formInput = document.querySelector(`#brand-form input[name="${fieldName}"]`);
                    console.log('Form input found:', !!formInput);
                    console.log('Form input before update:', formInput ? formInput.value.substring(0, 50) + '...' : 'not found');

                    if (formInput) {
                        // Method 1: Direct value assignment
                        formInput.value = value;
                        console.log('✓ Method 1 (direct):', formInput.value.substring(0, 50) + '...');

                        // Method 2: Using setAttribute
                        formInput.setAttribute('value', value);
                        console.log('✓ Method 2 (setAttribute):', formInput.getAttribute('value').substring(0, 50) + '...');

                        // Method 3: Using jQuery
                        $(formInput).val(value);
                        console.log('✓ Method 3 (jQuery):', $(formInput).val().substring(0, 50) + '...');

                        // Verify after all methods
                        setTimeout(function() {
                            console.log('Final form input value:', formInput.value.substring(0, 50) + '...');
                            console.log('Final form input length:', formInput.value.length);
                        }, 100);
                    } else {
                        console.error('❌ Form input not found for:', fieldName);
                        // Try to find ALL image_url inputs
                        const allImageInputs = document.querySelectorAll('input[name="image_url"]');
                        console.log('Found', allImageInputs.length, 'inputs with name="image_url"');
                        allImageInputs.forEach((input, index) => {
                            console.log(`Input ${index}:`, input.id, input.value.substring(0, 50) + '...');
                        });
                    }

                    window.closeFieldModal();

                    // Log all form data before submission
                    console.log('=== Final form data ===');
                    const form = document.getElementById('brand-form');
                    const formData = new FormData(form);
                    for (const [key, val] of formData.entries()) {
                        console.log(key + ':', val ? val.substring(0, 100) + '...' : 'empty');
                    }

                    console.log('=== Submitting form ===');
                    form.submit();
                };

                // Modal click handlers
                const fieldModal = document.getElementById('field-modal');
                if (fieldModal) {
                    fieldModal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            window.closeFieldModal();
                        }
                    });
                }

                const statModal = document.getElementById('stat-modal');
                if (statModal) {
                    statModal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            window.closeStatModal();
                        }
                    });
                }

                // Show success/error messages
                @if(session('success'))
                setTimeout(function() {
                    alert('Success: {{ session('success') }}');
                }, 100);
                @endif

                @if(session('error'))
                setTimeout(function() {
                    alert('Error: {{ session('error') }}');
                }, 100);
                @endif

                console.log('✓ Brand statements page initialized');
            })();
        </script>
    </x-slot:scripts>
</x-layouts.app>
