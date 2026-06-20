<x-layouts.app title="Edit Project">
    <x-slot:styles>
        <!-- Load Dropify dependencies -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
        <script src="{{ asset('js/dropify.min.js') }}"></script>

        <style>
            /* Dropify custom styling for dark theme */
            .dropify-wrapper {
                background: #121828;
                border: 2px dashed #1a1f2e;
                border-radius: 0.75rem;
                transition: all 0.2s ease;
                overflow: hidden;
            }

            .dropify-wrapper:hover {
                border-color: #0d9488;
                background: rgba(13, 148, 136, 0.05);
            }

            .dropify-message {
                padding: 2rem 1rem;
                color: #9ca3af;
            }

            .dropify-message span {
                font-size: 0.7rem;
                font-weight: 500;
            }

            .dropify-preview {
                background: #0a0e17;
            }

            .dropify-clear {
                background: rgba(239, 68, 68, 0.9);
                color: white;
                border: none;
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
            }

            .dropify-clear:hover {
                background: rgb(220, 38, 38);
            }

            .dropify-error {
                background: rgba(239, 68, 68, 0.1);
                border-color: #ef4444;
                color: #fca5a5;
            }

            /* Project gallery preview styling */
            .gallery-preview-item {
                position: relative;
            }

            .gallery-preview-item button {
                position: absolute;
                top: 4px;
                right: 4px;
                background: #ef4444;
                color: white;
                border: 2px solid white;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                opacity: 0;
                transition: all 0.2s ease;
            }

            .gallery-preview-item:hover button {
                opacity: 1;
            }
        </style>
    </x-slot:styles>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.projects.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Edit Project</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Updating: <span class="font-bold text-brand-500">{{ $project->title }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Display Name</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="e.g., Power Generation">
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Short name for badges and filters</p>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="ongoing" {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="planned" {{ old('status', $project->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                </select>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $project->location) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="client" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Client</label>
                                <input type="text" name="client" id="client" value="{{ old('client', $project->client) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="capacity" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Capacity / Scale</label>
                                <input type="text" name="capacity" id="capacity" value="{{ old('capacity', $project->capacity) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Type</label>
                                <input type="text" name="type" id="type" value="{{ old('type', $project->type) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="completion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Completion (%)</label>
                                <input type="text" name="completion" id="completion" value="{{ old('completion', $project->completion) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Value</label>
                                <input type="number" name="value" id="value" value="{{ old('value', $project->value) }}" step="0.01"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="expected_completion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Expected Completion</label>
                                <input type="date" name="expected_completion" id="expected_completion" value="{{ old('expected_completion', $project->expected_completion ? $project->expected_completion->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Sections -->
                    <div class="space-y-6" x-data="{
                        scopes: {{ json_encode(old('scope', $project->scope ?? [''])) }},
                        highlights: {{ json_encode(old('highlights', $project->highlights ?? [''])) }},
                        stats: {{ json_encode(old('stats', $project->stats ?? [['label' => '', 'value' => '']])) }}
                    }">
                        <!-- Project Scope -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Scope</h3>
                                <button type="button" @click="scopes.push('')" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(scope, index) in scopes" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="scope[]" x-model="scopes[index]"
                                            class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <button type="button" @click="scopes.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="scopes.length > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Key Highlights -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Key Highlights</h3>
                                <button type="button" @click="highlights.push('')" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(highlight, index) in highlights" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="highlights[]" x-model="highlights[index]"
                                            class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <button type="button" @click="highlights.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="highlights.length > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Project Stats -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Stats</h3>
                                <button type="button" @click="stats.push({label: '', value: ''})" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Stat
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(stat, index) in stats" :key="index">
                                    <div class="grid grid-cols-2 gap-2 relative group">
                                        <input type="text" :name="'stats['+index+'][label]'" x-model="stat.label" placeholder="Label"
                                            class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <div class="flex gap-2">
                                            <input type="text" :name="'stats['+index+'][value]'" x-model="stat.value" placeholder="Value"
                                                class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                            <button type="button" @click="stats.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="stats.length > 1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Meta -->
                <div class="space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Featured Image</h3>
                        <div>
                            <input type="file" name="image" id="project-image" class="dropify" accept="image/*"
                                @if($project->image) data-default-file="{{ $project->image }}" @endif />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Gallery</h3>
                        @if($project->images && count($project->images) > 0)
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                @foreach($project->images as $img)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-100 dark:border-white/5">
                                        <img src="{{ $img }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div>
                            <div class="w-full aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-brand-500 transition-all relative" id="gallery-dropzone">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Add More Gallery Images</span>
                                <input type="file" name="additional_images[]" id="project-gallery" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-3"></div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Multiple files allowed (up to 10MB each)</p>
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-6 bg-gray-200 dark:bg-surface-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-brand-500 transition-colors">Mark as Featured</span>
                        </label>
                    </div>

                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3 sticky top-8">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Update Project
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot:scripts>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for jQuery and Dropify to load
            var checkJQuery = setInterval(function() {
                if (typeof jQuery !== 'undefined') {
                    clearInterval(checkJQuery);
                    var $ = jQuery;

                    // Wait for Dropify to load
                    var checkDropify = setInterval(function() {
                        if (typeof $.fn.dropify !== 'undefined') {
                            clearInterval(checkDropify);
                            console.log('Dropify loaded! Initializing...');

                            // Initialize Dropify for project featured image
                            $('#project-image').dropify({
                                showRemove: true,
                                showErrors: true,
                                errorsPosition: 'outside',
                                messages: {
                                    'default': 'Drag and drop a file here or click',
                                    'replace': 'Drag and drop or click to replace',
                                    'remove': 'Remove',
                                    'error': 'Ooops, something wrong happened.'
                                }
                            });

                            console.log('Dropify initialized on project edit form');

                            // Gallery preview functionality
                            const galleryInput = document.getElementById('project-gallery');
                            const galleryPreview = document.getElementById('gallery-preview');

                            if (galleryInput && galleryPreview) {
                                galleryInput.addEventListener('change', function(e) {
                                    const files = e.target.files;

                                    for (let i = 0; i < files.length; i++) {
                                        const file = files[i];
                                        if (file.type.startsWith('image/')) {
                                            const reader = new FileReader();
                                            reader.onload = function(event) {
                                                const div = document.createElement('div');
                                                div.className = 'gallery-preview-item aspect-square';
                                                div.innerHTML = `
                                                    <img src="${event.target.result}" class="w-full h-full object-cover rounded-lg">
                                                    <button type="button" onclick="this.parentElement.remove()">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                `;
                                                galleryPreview.appendChild(div);
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    }
                                });
                            }
                        } else {
                            console.log('Waiting for Dropify to load...');
                        }
                    }, 200);
                } else {
                    console.log('Waiting for jQuery to load...');
                }
            }, 200);
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>
