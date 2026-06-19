<x-layouts.app title="Edit Product">
    <x-slot:styles>
        <!-- Load Dropify dependencies -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
        <script src="{{ asset('js/dropify.min.js') }}"></script>

        <style>
            /* Custom gallery removal button styling */
            .gallery-item {
                position: relative;
            }

            .gallery-remove-btn {
                position: absolute;
                top: -8px;
                right: -8px;
                background: #ef4444;
                color: white;
                border-radius: 50%;
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                border: 3px solid white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                z-index: 20;
                transition: all 0.2s ease;
            }

            .gallery-remove-btn:hover {
                background: #dc2626;
                transform: scale(1.15);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            }

            .gallery-remove-btn button {
                background: transparent;
                border: none;
                padding: 0;
                margin: 0;
                cursor: pointer;
                color: white;
                font-size: 18px;
                line-height: 1;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .gallery-remove-btn svg {
                width: 16px;
                height: 16px;
                pointer-events: none;
            }

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
        </style>
    </x-slot:styles>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Edit Product</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Updating: <span class="font-bold text-brand-500">{{ $product->name }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Display Name</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., Transformers">
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Short name for badges and filters</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Short Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">{{ old('description', $product->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="overview" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Detailed Overview</label>
                                <textarea name="overview" id="overview" rows="5"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">{{ old('overview', $product->overview) }}</textarea>
                                <x-input-error :messages="$errors->get('overview')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Technical Specifications</h3>
                        <div id="specifications-container">
                            @if($product->specifications && is_array($product->specifications))
                                @foreach($product->specifications as $spec)
                                <div class="specification-item grid grid-cols-2 gap-3 mb-3">
                                    @if(is_array($spec))
                                        <input type="text" name="specifications[]" value="{{ $spec['label'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                            placeholder="Label (e.g., Voltage)">
                                        <input type="text" name="specifications[]" value="{{ $spec['value'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                            placeholder="Value (e.g., 230 kV)">
                                    @else
                                        <input type="text" name="specifications[]" value="{{ $spec }}"
                                            class="col-span-2 w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                                    @endif
                                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="col-span-2 text-red-500 text-xs hover:text-red-700">Remove</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addSpecification()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Specification
                        </button>
                    </div>

                    <!-- Features -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Features</h3>
                        <div id="features-container">
                            @if($product->features && is_array($product->features))
                                @foreach($product->features as $feature)
                                <div class="feature-item mb-3 flex gap-2">
                                    <input type="text" name="features[]" value="{{ $feature }}"
                                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                        placeholder="e.g., High efficiency design">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addFeature()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Feature
                        </button>
                    </div>

                    <!-- Applications -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Typical Applications</h3>
                        <div id="applications-container">
                            @if($product->applications && is_array($product->applications))
                                @foreach($product->applications as $application)
                                <div class="application-item mb-3 flex gap-2">
                                    <input type="text" name="applications[]" value="{{ $application }}"
                                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                        placeholder="e.g., Power distribution networks">
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addApplication()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Application
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Product Image -->
                    <div class="glass-card p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Image</h3>
                            @if($product->image)
                                <form action="{{ route('admin.products.remove-image', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold">Remove Image</button>
                                </form>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="image" id="product-image" class="dropify" accept="image/*"
                                @if($product->image) data-default-file="{{ $product->image }}" @endif />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="glass-card p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Gallery</h3>
                            <span class="text-xs text-gray-500">{{ $product->gallery ? count($product->gallery) : 0 }} images</span>
                        </div>
                        <div>
                            @if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0)
                                <div class="grid grid-cols-3 gap-2 mb-3" id="existing-gallery">
                                    @foreach($product->gallery as $index => $image)
                                    <div class="gallery-item">
                                        <img src="{{ $image }}" class="w-full aspect-square object-cover rounded-lg border border-gray-200 dark:border-white/10">
                                        <div class="gallery-remove-btn" title="Remove image">
                                            <form action="{{ route('admin.products.remove-gallery-image', $product) }}" method="POST" style="margin: 0; padding: 0;">
                                                @csrf
                                                <input type="hidden" name="image_index" value="{{ $index }}">
                                                <button type="submit" onclick="return confirm('Are you sure you want to remove this image?');">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="w-full aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-brand-500 transition-all relative" id="gallery-dropzone">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Add New Gallery Images</span>
                                <span class="text-xs text-gray-500">Click to upload or drag and drop</span>
                                <input type="file" name="gallery[]" id="product-gallery" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-3"></div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Multiple files allowed (up to 10MB each)</p>
                        </div>
                    </div>

                    <!-- Brochure -->
                    <div class="glass-card p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Brochure</h3>
                            @if($product->brochure)
                                <form action="{{ route('admin.products.remove-brochure', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold">Remove Brochure</button>
                                </form>
                            @endif
                        </div>
                        <div>
                            @if($product->brochure)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-surface-800 rounded-xl mb-3 relative group/brochure">
                                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">Current Brochure</p>
                                        <a href="{{ $product->brochure }}" target="_blank" class="text-xs text-brand-500 hover:text-brand-600">View File</a>
                                    </div>
                                </div>
                            @endif
                            <div class="w-full aspect-video rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-brand-500 transition-all relative @if($product->brochure) hidden @endif" id="brochure-dropzone">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Upload New Brochure (PDF, DOC, DOCX)</span>
                                <span class="text-xs text-gray-500">This will replace the existing file</span>
                                <input type="file" name="brochure" id="product-brochure" accept=".pdf,.doc,.docx" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div id="brochure-preview" class="mt-3 hidden">
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-surface-800 rounded-xl">
                                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white" id="brochure-name">Selected File</p>
                                        <p class="text-xs text-gray-500" id="brochure-size">File Size</p>
                                    </div>
                                    <button type="button" id="remove-brochure" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('brochure')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $product->order) }}" min="0"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" {{ $product->is_active ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active (visible on website)</label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
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

                            // Initialize Dropify for product image
                            $('#product-image').dropify({
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

                            console.log('Dropify initialized on product form elements');

                            // Gallery preview functionality
                            const galleryInput = document.getElementById('product-gallery');
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
                                                    <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 hover:opacity-100 transition-all" onclick="this.parentElement.remove();">
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

                            // Brochure preview functionality
                            const brochureInput = document.getElementById('product-brochure');
                            const brochurePreview = document.getElementById('brochure-preview');
                            const brochureName = document.getElementById('brochure-name');
                            const brochureSize = document.getElementById('brochure-size');
                            const removeBrochureBtn = document.getElementById('remove-brochure');
                            const brochureDropzone = document.getElementById('brochure-dropzone');

                            if (brochureInput && brochurePreview) {
                                brochureInput.addEventListener('change', function(e) {
                                    const file = e.target.files[0];
                                    if (file) {
                                        brochureName.textContent = file.name;
                                        brochureSize.textContent = formatFileSize(file.size);
                                        brochurePreview.classList.remove('hidden');
                                        // Hide dropzone to show preview instead
                                        if (brochureDropzone) {
                                            brochureDropzone.classList.add('hidden');
                                        }
                                    }
                                });

                                if (removeBrochureBtn) {
                                    removeBrochureBtn.addEventListener('click', function() {
                                        brochureInput.value = '';
                                        brochurePreview.classList.add('hidden');
                                        // Show dropzone again
                                        if (brochureDropzone) {
                                            brochureDropzone.classList.remove('hidden');
                                        }
                                    });
                                }
                            }

                            function formatFileSize(bytes) {
                                if (bytes === 0) return '0 Bytes';
                                const k = 1024;
                                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                                const i = Math.floor(Math.log(bytes) / Math.log(k));
                                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                            }
                        } else {
                            console.log('Waiting for Dropify to load...');
                        }
                    }, 200);
                } else {
                    console.log('Waiting for jQuery to load...');
                }
            }, 200);

            // Make functions globally available
            window.addSpecification = function() {
                const container = document.getElementById('specifications-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'specification-item grid grid-cols-2 gap-3 mb-3';
                div.innerHTML = `
                    <input type="text" name="specifications[]"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="Label (e.g., Voltage)">
                    <input type="text" name="specifications[]"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="Value (e.g., 230 kV)">
                    <button type="button" onclick="this.parentElement.remove()" class="col-span-2 text-red-500 text-xs hover:text-red-700">Remove</button>
                `;
                container.appendChild(div);
            };

            window.addFeature = function() {
                const container = document.getElementById('features-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'feature-item mb-3 flex gap-2';
                div.innerHTML = `
                    <input type="text" name="features[]"
                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="e.g., High efficiency design">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                `;
                container.appendChild(div);
            };

            window.addApplication = function() {
                const container = document.getElementById('applications-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'application-item mb-3 flex gap-2';
                div.innerHTML = `
                    <input type="text" name="applications[]"
                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="e.g., Power distribution networks">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                `;
                container.appendChild(div);
            };
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>
