<x-layouts.app title="Edit News Article">
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

            /* Gallery preview styling */
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
            <a href="{{ route('admin.news.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Edit Article</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Updating: <span class="font-bold text-brand-500">{{ $news->title }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Article Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Article Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category_id" id="category_id"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Display Name</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $news->category) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="e.g., Company News">
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Short name for badges and filters</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="excerpt" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Excerpt</label>
                                <textarea name="excerpt" id="excerpt" rows="3" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-none"
                                    placeholder="Brief summary of the article...">{{ old('excerpt', $news->excerpt) }}</textarea>
                                <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Content</label>
                                <textarea name="content" id="content" rows="10" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-y"
                                    placeholder="Full article content...">{{ old('content', $news->content) }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div>
                                <label for="author" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Author</label>
                                <input type="text" name="author" id="author" value="{{ old('author', $news->author) }}" placeholder="e.g., John Doe"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="author_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Author Title</label>
                                <input type="text" name="author_title" id="author_title" value="{{ old('author_title', $news->author_title) }}" placeholder="e.g., CEO"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="publication_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Publication Date</label>
                                <input type="date" name="publication_date" id="publication_date" value="{{ old('publication_date', $news->publication_date) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="read_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Read Time</label>
                                <input type="text" name="read_time" id="read_time" value="{{ old('read_time', $news->read_time) }}" placeholder="e.g., 5 min read"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $news->order) }}" min="0"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="glass-card p-6 sm:p-8 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">SEO Metadata</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $news->meta_title) }}" placeholder="SEO title"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2" placeholder="SEO description"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-none">{{ old('meta_description', $news->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label for="meta_keywords" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}" placeholder="comma, separated, keywords"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Meta -->
                <div class="space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Featured Image</h3>
                        <div>
                            <input type="file" name="image" id="news-image" class="dropify" accept="image/*"
                                @if($news->image) data-default-file="{{ $news->image }}" @endif />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            @if($news->image)
                            <form action="{{ route('admin.news.removeImage', $news) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="text-sm text-red-500 hover:text-red-600">Remove current image</button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Article Gallery</h3>
                        @if($news->gallery && count($news->gallery) > 0)
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                @foreach($news->gallery as $index => $img)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-100 dark:border-white/5 relative group">
                                        <img src="{{ $img }}" class="w-full h-full object-cover">
                                        <form action="{{ route('admin.news.removeGalleryImage', $news) }}" method="POST" class="absolute top-1 right-1">
                                            @csrf
                                            <input type="hidden" name="image_index" value="{{ $index }}">
                                            <button type="submit" class="bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-all hover:scale-110">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
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
                                <input type="file" name="gallery[]" id="news-gallery" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-3"></div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Multiple files allowed (up to 10MB each)</p>
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $news->featured) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-6 bg-gray-200 dark:bg-surface-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-brand-500 transition-colors">Mark as Featured</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-6 bg-gray-200 dark:bg-surface-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-brand-500 transition-colors">Publish Article</span>
                        </label>
                    </div>

                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3 sticky top-8">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Update Article
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
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

                            // Initialize Dropify for news featured image
                            $('#news-image').dropify({
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

                            console.log('Dropify initialized on news edit form');

                            // Gallery preview functionality
                            const galleryInput = document.getElementById('news-gallery');
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
