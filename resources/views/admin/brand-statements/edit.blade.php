<x-layouts.app title="Edit Brand Statement">
    @php
        // Helper function to get content data regardless of table structure
        $getContentData = function($brandStatement, $field, $default = '') {
            if (isset($brandStatement->content_data) && is_array($brandStatement->content_data)) {
                return $brandStatement->content_data[$field] ?? $default;
            }
            return $brandStatement->$field ?? $default;
        };

        $getStatsForEdit = function($brandStatement) {
            if (isset($brandStatement->content_data) && is_array($brandStatement->content_data) && isset($brandStatement->content_data['stats'])) {
                return $brandStatement->content_data['stats'];
            }
            return $brandStatement->stats ?? [];
        };

        // Get current image URL
        $currentImage = $getContentData($brandStatement, 'image_url', '');
    @endphp

    @push('styles')
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css" />
    <style>
        .dropify-wrapper .dropify-message {
            font-size: 14px;
            color: #777;
        }
        .dropify-wrapper .dropify-message p {
            font-size: 12px;
            color: #999;
        }
        .dropify-wrapper:hover .dropify-message {
            color: #555;
        }
    </style>
    @endpush

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Edit Brand Statement</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Update brand statement content</p>
            </div>
            <a href="{{ route('admin.brand-statements.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-surface-600 transition-colors font-semibold">
                Back to Preview
            </a>
        </div>

        <!-- Edit Form -->
        <div class="glass-card p-8">
            <form action="{{ route('admin.brand-statements.update', $brandStatement->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $getContentData($brandStatement, 'title', '')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="ESTABLISHED AUTHORITY IN HEAVY ENGINEERING">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                  placeholder="Following the legacy of JRC and Energypac...">{{ old('description', $getContentData($brandStatement, 'description', '')) }}</textarea>
                    </div>

                    <!-- Image Upload with Dropify -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
                        <input type="file" name="image_upload" id="image-upload" class="dropify" accept="image/*"
                               @if($currentImage) data-default-file="{{ $currentImage }}" @endif />
                        <input type="hidden" name="image_url" id="image-url" value="{{ old('image_url', $currentImage) }}" />

                        <!-- Or enter URL manually -->
                        <div class="mt-3">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Or enter image URL manually:</label>
                            <input type="text" id="manual-image-url" value="{{ old('image_url', $currentImage) }}"
                                   class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-brand-500"
                                   placeholder="https://images.unsplash.com/photo-1581092160607-ee22621dd758...">
                        </div>
                    </div>

                    <!-- Overlay Title -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Overlay Title</label>
                        <input type="text" name="overlay_title" value="{{ old('overlay_title', $getContentData($brandStatement, 'overlay_title', '')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="Core Reliability">
                    </div>

                    <!-- Overlay Text -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Overlay Text</label>
                        <input type="text" name="overlay_text" value="{{ old('overlay_text', $getContentData($brandStatement, 'overlay_text', '')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="Zero Downtime Operation Protocols">
                    </div>

                    <!-- Stats Section -->
                    <div class="border-t border-gray-200 dark:border-surface-600 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(range(1, 4) as $i)
                                <div class="p-4 bg-gray-50 dark:bg-surface-700 rounded-xl">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Stat {{ $i }}</h4>
                                    <div class="space-y-3">
                                        <input type="text" name="stats[{{ $i }}][value]"
                                               value="{{ old("stats.$i.value", $getStatsForEdit($brandStatement)[$i-1]['value'] ?? '') }}"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500"
                                               placeholder="45+">
                                        <input type="text" name="stats[{{ $i }}][label]"
                                               value="{{ old("stats.$i.label", $getStatsForEdit($brandStatement)[$i-1]['label'] ?? '') }}"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500"
                                               placeholder="Years Experience">
                                        <input type="hidden" name="stats[{{ $i }}][order]" value="{{ $i }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="publish" {{ ($brandStatement->status ?? 'draft') === 'publish' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ ($brandStatement->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.brand-statements.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Dropify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Dropify
            var drEvent = $('#image-upload').dropify({
                messages: {
                    'default': 'Drag and drop an image here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happened.'
                },
                error: {
                    'fileSize': 'The file size is too big ({{ value }}max).',
                    'minWidth': 'The image width is too small ({{ value }}}px min).',
                    'maxWidth': 'The image width is too big ({{ value }}}px max).',
                    'minHeight': 'The image height is too small ({{ value }}}px min).',
                    'maxHeight': 'The image height is too big ({{ value }}px max).',
                    'imageFormat': 'The image format is not allowed ({{ value }} only).'
                },
                tpl: {
                    wrap:            '<div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon" />\
                                        <p>{{ default }}</p>\
                                        <p style="font-size: 10px; margin-top: 5px; color: #999;">(or enter URL below)</p>\
                                       </div>\
                                       <div class="dropify-preview">\
                                       <span class="dropify-render"></span>\
                                       <div class="dropify-infos"><div class="dropify-infos-inner"></div></div>\
                                       </div>\
                                       <span class="dropify-error">{{ error }}</span>\
                                       <button class="dropify-clear">{{ remove }}</button>\
                                       </div>',
                    message:         '<div class="dropify-message">{{ default }}</div>',
                    preview:         '<div class="dropify-preview"><span class="dropify-render"></span>\
                                       <div class="dropify-infos"><div class="dropify-infos-inner"></div></div></div>',
                    filename:        '<p class="dropify-filename"><span></span></p>',
                    clearButton:     '<button class="dropify-clear">{{ remove }}</button>',
                    errorLine:       '<p class="dropify-error">{{ error }}</p>',
                    infos:           '<div class="dropify-infos-inner"></div>'
                }
            });

            // Handle file selection
            drEvent.on('dropify.afterClear', function(event, element) {
                $('#image-url').val('');
                $('#manual-image-url').val('');
            });

            // Sync manual URL input
            $('#manual-image-url').on('input change', function() {
                var url = $(this).val();
                $('#image-url').val(url);

                // Update Dropify preview if URL is provided
                if (url) {
                    var drEvent = $('#image-upload').data('dropify');
                    drEvent.resetPreview();
                    drEvent.setPreview(url, url);
                    drEvent.settings.defaultFile = url;
                    drEvent.init();
                }
            });

            // Handle file upload - need to upload to server and get URL
            drEvent.on('dropify.fileSelected', function(event, element) {
                var file = element.files[0];
                if (file) {
                    // For now, we'll store the file object reference
                    // In a real implementation, you'd upload to server and get the URL
                    console.log('File selected:', file.name);

                    // Create object URL for preview
                    var objectUrl = URL.createObjectURL(file);
                    $('#image-url').val(objectUrl);
                    $('#manual-image-url').val(objectUrl);
                }
            });
        });
    </script>
</x-layouts.app>
