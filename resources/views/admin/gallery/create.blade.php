<x-layouts.app title="Add Media">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gallery.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Add Media to Gallery</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Upload a photo or link a video.</p>
            </div>
        </div>

        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="glass-card p-6 sm:p-8 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Media Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Substation Installation Phase 1"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div x-data="{ type: 'photo' }">
                    <!-- Type Selector moved inside x-data for better control or just use @change on a parent -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Type</label>
                            <select name="type" id="type" required x-model="type"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <option value="photo">Photo</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                            <select name="category" id="category" required
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <option value="projects">Projects</option>
                                <option value="events">Events</option>
                                <option value="office">Office</option>
                                <option value="technical">Technical</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="type === 'photo'" class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Upload Photo</label>
                        <div class="relative group aspect-video">
                            <div class="w-full h-full rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 group-hover:border-brand-500 transition-all overflow-hidden relative">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Click to upload</span>
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    
                    <div x-show="type === 'video'" class="space-y-2" style="display: none;">
                        <label for="url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Video URL (YouTube/Vimeo)</label>
                        <input type="text" name="url" id="url" value="{{ old('url') }}" placeholder="https://youtube.com/..."
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-6 flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                        Add to Gallery
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
