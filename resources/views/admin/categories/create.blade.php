<x-layouts.app title="Create Category">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Categories
            </a>
        </div>

        <div class="glass-card p-8">
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white font-outfit mb-6">Create New Category</h1>

            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Service Area -->
                    <div>
                        <label for="service_area" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Service Area <span class="text-red-500">*</span>
                        </label>
                        <select id="service_area" name="service_area" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                            <option value="">Select Area...</option>
                            @foreach($serviceAreas as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('service_area')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                            placeholder="e.g., Power Generation">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                            placeholder="Brief description of this category..."></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Icon (SVG)
                        </label>
                        <textarea id="icon" name="icon" rows="4"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all font-mono text-sm"
                            placeholder="<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'>...</svg>"></textarea>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Paste SVG code for the category icon</p>
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Display Order
                        </label>
                        <input type="number" id="order" name="order" min="0" value="0"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Lower numbers appear first</p>
                        @error('order')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked
                            class="w-5 h-5 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                        <label for="is_active" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Active (visible in frontend)
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-surface-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition-all shadow-lg hover:shadow-xl">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>