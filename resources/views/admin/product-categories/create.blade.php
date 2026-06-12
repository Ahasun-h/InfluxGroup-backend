<x-layouts.app title="Create Product Category">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.product-categories.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Create New Category</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new category to organize your products.</p>
            </div>
        </div>

        <form action="{{ route('admin.product-categories.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Basic Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Category Information</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., Transformers">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="Brief description of this product category">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <label for="icon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Icon (Emoji)</label>
                                <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., ⚡ or 🔌">
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Use an emoji icon for visual identification</p>
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                                <input type="number" name="order" id="order" value="{{ old('order') ?? 0 }}" min="0"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                                <x-input-error :messages="$errors->get('order')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" id="is_active" checked
                                    class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active (visible on website)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview & Actions -->
                <div class="space-y-6">
                    <!-- Category Preview -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Preview</h3>
                        <div class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 border-dashed border-gray-200 dark:border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white text-2xl" id="icon-preview">
                                    ⚡
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white" id="preview-name">Category Name</h4>
                                    <span class="text-xs text-gray-500">Preview</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Save Category
                        </button>
                        <a href="{{ route('admin.product-categories.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
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
            const nameInput = document.getElementById('name');
            const iconInput = document.getElementById('icon');
            const previewName = document.getElementById('preview-name');
            const iconPreview = document.getElementById('icon-preview');

            if (nameInput && previewName) {
                nameInput.addEventListener('input', function() {
                    previewName.textContent = this.value || 'Category Name';
                });
            }

            if (iconInput && iconPreview) {
                iconInput.addEventListener('input', function() {
                    iconPreview.textContent = this.value || '⚡';
                });
            }
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>