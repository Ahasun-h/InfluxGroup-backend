<x-layouts.app title="Edit Service/Solution">
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

            .service-fields { display: none; }
            .solution-fields { display: none; }
        </style>
    </x-slot:styles>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.services-and-solutions.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Edit Item</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Editing: <span class="font-bold text-brand-500">{{ $item->title }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.services-and-solutions.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Basic Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $item->title) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Type</label>
                                <select name="type" id="type" required onchange="toggleTypeFields()"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="service" {{ old('type', $item->type) == 'service' ? 'selected' : '' }}>Service</option>
                                    <option value="solution" {{ old('type', $item->type) == 'solution' ? 'selected' : '' }}>Solution</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category_id" id="category_id"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Display Name</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="e.g., Engineering">
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Short name for badges and filters</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Short Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="overview" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Detailed Overview</label>
                                <textarea name="overview" id="overview" rows="5"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">{{ old('overview') }}</textarea>
                                <x-input-error :messages="$errors->get('overview')" class="mt-2" />
                            </div>

                            <div>
                                <label for="icon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Icon</label>
                                <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="e.g., Cog, Wrench">
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Lucide Vue icon name</p>
                            </div>
                        </div>
                    </div>

                    <!-- Service Fields -->
                    <div class="glass-card p-6 space-y-6 service-fields" id="service-fields">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Service Details</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Features</label>
                                <div id="features-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="features[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., 24/7 Support">
                                        <button type="button" onclick="removeFeature(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addFeature()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Feature</button>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Process Steps</label>
                                <div id="process-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="process[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Consultation">
                                        <button type="button" onclick="removeProcess(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addProcess()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Process Step</button>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Duration</label>
                                    <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                        placeholder="e.g., 2-4 weeks">
                                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="availability" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Availability</label>
                                    <input type="text" name="availability" id="availability" value="{{ old('availability') }}"
                                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                        placeholder="e.g., 24/7">
                                    <x-input-error :messages="$errors->get('availability')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Solution Fields -->
                    <div class="glass-card p-6 space-y-6 solution-fields" id="solution-fields">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Solution Details</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Components</label>
                                <div id="components-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="components[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Power Distribution">
                                        <button type="button" onclick="removeComponent(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addComponent()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Component</button>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Applications</label>
                                <div id="applications-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="applications[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Manufacturing Plants">
                                        <button type="button" onclick="removeApplication(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addApplication()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Application</button>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Benefits</label>
                                <div id="benefits-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="benefits[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Cost Effective">
                                        <button type="button" onclick="removeBenefit(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addBenefit()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Benefit</button>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Industries</label>
                                <div id="industries-container">
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" name="industries[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Power Generation">
                                        <button type="button" onclick="removeIndustry(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addIndustry()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Industry</button>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Stats</label>
                                <div id="stats-container">
                                    <div class="grid grid-cols-2 gap-2 mb-2">
                                        <input type="text" name="stats[]" placeholder="Value (e.g., 50+)" class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <input type="text" name="stats[]" placeholder="Label (e.g., Projects)" class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <button type="button" onclick="removeStat(this)" class="col-span-2 text-red-500 text-sm hover:text-red-700 p-2">Remove Stat</button>
                                    </div>
                                </div>
                                <button type="button" onclick="addStat()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">+ Add Stat</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Image -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Featured Image</h3>
                        <div>
                            <input type="file" name="image" id="item-image" class="dropify" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Gallery</h3>
                        <div>
                            <div class="w-full aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-brand-500 transition-all relative" id="gallery-dropzone">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Upload Gallery Images</span>
                                <input type="file" name="gallery[]" id="item-gallery" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-3"></div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Multiple files allowed</p>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order') ?? 0 }}" min="0"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" checked
                                class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active (visible on website)</label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Save Item
                        </button>
                        <a href="{{ route('admin.services-and-solutions.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
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
            // Toggle type fields based on selection
            toggleTypeFields();

            // Wait for jQuery and Dropify to load
            var checkJQuery = setInterval(function() {
                if (typeof jQuery !== 'undefined') {
                    clearInterval(checkJQuery);
                    var $ = jQuery;

                    var checkDropify = setInterval(function() {
                        if (typeof $.fn.dropify !== 'undefined') {
                            clearInterval(checkDropify);

                            $('#item-image').dropify({
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

                            // Gallery preview functionality
                            const galleryInput = document.getElementById('item-gallery');
                            const galleryPreview = document.getElementById('gallery-preview');

                            if (galleryInput && galleryPreview) {
                                galleryInput.addEventListener('change', function(e) {
                                    galleryPreview.innerHTML = '';
                                    const files = e.target.files;

                                    for (let i = 0; i < files.length; i++) {
                                        const file = files[i];
                                        if (file.type.startsWith('image/')) {
                                            const reader = new FileReader();
                                            reader.onload = function(event) {
                                                const div = document.createElement('div');
                                                div.className = 'relative aspect-square';
                                                div.innerHTML = `
                                                    <img src="${event.target.result}" class="w-full h-full object-cover rounded-lg">
                                                    <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 hover:opacity-100 transition-all" onclick="this.parentElement.remove();">×</button>
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

        function toggleTypeFields() {
            const type = document.getElementById('type').value;
            const serviceFields = document.getElementById('service-fields');
            const solutionFields = document.getElementById('solution-fields');

            if (type === 'service') {
                serviceFields.style.display = 'block';
                solutionFields.style.display = 'none';
            } else {
                serviceFields.style.display = 'none';
                solutionFields.style.display = 'block';
            }
        }

        // Service field functions
        function addFeature() {
            const container = document.getElementById('features-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="features[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., 24/7 Support">
                <button type="button" onclick="removeFeature(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeFeature(btn) {
            btn.parentElement.remove();
        }

        function addProcess() {
            const container = document.getElementById('process-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="process[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Consultation">
                <button type="button" onclick="removeProcess(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeProcess(btn) {
            btn.parentElement.remove();
        }

        // Solution field functions
        function addComponent() {
            const container = document.getElementById('components-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="components[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Power Distribution">
                <button type="button" onclick="removeComponent(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeComponent(btn) {
            btn.parentElement.remove();
        }

        function addApplication() {
            const container = document.getElementById('applications-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="applications[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Manufacturing Plants">
                <button type="button" onclick="removeApplication(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeApplication(btn) {
            btn.parentElement.remove();
        }

        function addBenefit() {
            const container = document.getElementById('benefits-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="benefits[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Cost Effective">
                <button type="button" onclick="removeBenefit(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeBenefit(btn) {
            btn.parentElement.remove();
        }

        function addIndustry() {
            const container = document.getElementById('industries-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="industries[]" class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white" placeholder="e.g., Power Generation">
                <button type="button" onclick="removeIndustry(this)" class="p-2 text-gray-400 hover:text-red-500 transition-colors">×</button>
            `;
            container.appendChild(div);
        }

        function removeIndustry(btn) {
            btn.parentElement.remove();
        }

        function addStat() {
            const container = document.getElementById('stats-container');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-2 gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="stats[]" placeholder="Value (e.g., 50+)" class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                <input type="text" name="stats[]" placeholder="Label (e.g., Projects)" class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                <button type="button" onclick="removeStat(this)" class="col-span-2 text-red-500 text-sm hover:text-red-700 p-2">Remove Stat</button>
            `;
            container.appendChild(div);
        }

        function removeStat(btn) {
            btn.parentElement.remove();
        }
        </script>
    </x-slot:scripts>
</x-layouts.app>