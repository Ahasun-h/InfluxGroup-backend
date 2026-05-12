<x-layouts.app title="Edit News Article">
    <div class="max-w-4xl mx-auto space-y-8">
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
                <!-- Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Article Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-base focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Excerpt (Short Summary)</label>
                                <textarea name="excerpt" id="excerpt" rows="2" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">{{ old('excerpt', $news->excerpt) }}</textarea>
                                <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Content</label>
                                <textarea name="content" id="content" rows="12" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">{{ old('content', $news->content) }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Sidebar -->
                <div class="space-y-6">
                    <!-- Featured Image -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Featured Image</h3>
                        <div class="relative group aspect-video">
                            @if($news->image)
                                <img src="{{ $news->image }}" class="w-full h-full object-cover rounded-2xl">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all rounded-2xl flex items-center justify-center">
                                    <span class="text-white text-xs font-bold bg-white/20 backdrop-blur-md px-3 py-1 rounded-lg">Change Image</span>
                                </div>
                            @else
                                <div class="w-full h-full rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 group-hover:border-brand-500 transition-all overflow-hidden relative">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs font-semibold">Upload Photo</span>
                                </div>
                            @endif
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Meta -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Post Metadata</h3>
                        
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <option value="company-updates" {{ old('category', $news->category) == 'company-updates' ? 'selected' : '' }}>Company Updates</option>
                                <option value="press-release" {{ old('category', $news->category) == 'press-release' ? 'selected' : '' }}>Press Release</option>
                                <option value="industry-news" {{ old('category', $news->category) == 'industry-news' ? 'selected' : '' }}>Industry News</option>
                                <option value="milestones" {{ old('category', $news->category) == 'milestones' ? 'selected' : '' }}>Milestones</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3">
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
</x-layouts.app>
