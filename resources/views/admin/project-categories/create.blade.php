<x-layouts.app title="Create Project Category">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.project-categories.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Create Project Category</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new category to organize your projects.</p>
            </div>
        </div>

        <form action="{{ route('admin.project-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="glass-card p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Category Information</h3>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Icon (SVG)</label>
                        <div class="space-y-3">
                            <!-- SVG Input Section -->
                            <div id="svg-section" class="space-y-3">
                                <div class="flex gap-2">
                                    <textarea id="icon-svg" rows="3"
                                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400 font-mono text-xs"
                                        placeholder="Paste your SVG code here...">{{ old('icon') }}</textarea>
                                    <div id="svg-preview" class="w-12 h-12 bg-gray-100 dark:bg-surface-800 rounded-xl flex items-center justify-center border border-gray-200 dark:border-white/10 overflow-hidden">
                                        <span id="svg-display" class="text-2xl">⚡</span>
                                    </div>
                                </div>

                                <!-- Quick Select SVGs -->
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Quick select common SVGs:</p>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M13 2L3 14h9l-1 8 10-10-8 8z'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M13 2L3 14h9l-1 8 10-10-8 8z"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2.83l-14.14 14.14a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83 2.83l.06.06a1.65 1.65 0 0 0 1.82-.33H9a1.65 1.65 0 0 0 1.82.33l.06.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0-2.83l-14.14-14.14a2 2 0 0 1 0-2.83z'/><circle cx='12' cy='12' r='3'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2.83l-14.14 14.14a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83 2.83l.06.06a1.65 1.65 0 0 0 1.82-.33H9a1.65 1.65 0 0 0 1.82.33l.06.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0-2.83l-14.14-14.14a2 2 0 0 1 0-2.83z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='2' y='7' width='20' height='14' rx='2' ry='2'/><path d='M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M12 2v20M17 7H7l5 5v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-6l5-5z'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M12 2v20M17 7H7l5 5v6a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-6l5-5z"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M12 3v18m0-18c6.627 0 12 5.373 12 12s-5.373 12-12 12-5.373 0-12-5.373-12-12z'/><path d='M12 8v4'/><path d='M12 16h.01'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M12 3v18m0-18c6.627 0 12 5.373 12 12s-5.373 12-12 12-5.373 0-12-5.373-12-12z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'/><path d='M12 6v6l4 2'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z'/><path d='M12 9v9'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M12 9v9"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='3'/><path d='M12 2v20m0-18c6.627 0 12 5.373 12 12s-5.373 12-12 12-5.373 0-12-5.373-12-12z'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><circle cx="12" cy="12" r="3"/><path d="M12 2v20m0-18c6.627 0 12 5.373 12 12s-5.373 12-12 12-5.373 0-12-5.373-12-12z"/></svg>
                                        </button>
                                        <button type="button" class="svg-btn w-12 h-12 rounded-lg bg-gray-100 dark:bg-surface-800 hover:bg-brand-100 dark:hover:bg-brand-900 transition flex items-center justify-center p-1" data-svg="<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M18.36 6.64a9 9 0 1 1-12.73 0'/><line x1='12' y1='2' x2='12' y2='12'/></svg>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-gray-300"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Or paste your SVG code above</p>
                                </div>
                            </div>

                            <!-- Hidden input to store the selected icon -->
                            <input type="hidden" name="icon" id="icon-input" value="{{ old('icon') }}">
                        </div>
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Image</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order') ?? 0 }}" min="0"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" checked
                                class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.project-categories.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                    Create Category
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgInput = document.getElementById('icon-svg');
            const iconInput = document.getElementById('icon-input');
            const svgDisplay = document.getElementById('svg-display');

            // SVG input handling
            svgInput.addEventListener('input', function() {
                iconInput.value = this.value;
                if (this.value.trim()) {
                    svgDisplay.innerHTML = this.value;
                } else {
                    svgDisplay.innerHTML = '⚡';
                }
            });

            // Quick SVG selection
            document.querySelectorAll('.svg-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const svg = this.getAttribute('data-svg');
                    svgInput.value = svg;
                    iconInput.value = svg;
                    svgDisplay.innerHTML = svg;
                });
            });

            // Initialize with existing value (for form resubmission)
            if (iconInput.value) {
                svgInput.value = iconInput.value;
                svgDisplay.innerHTML = iconInput.value;
            }
        });
    </script>
</x-layouts.app>
