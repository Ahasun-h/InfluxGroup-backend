<x-layouts.app title="Product Categories Management">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Product Categories</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage product categories for organizing your catalog.</p>
            </div>
            <a href="{{ route('admin.product-categories.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Category</span>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <div class="glass-card p-6 group hover:shadow-xl transition-all relative" data-category-id="{{ $category->id }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            @if($category->icon)
                                <span class="text-2xl">{{ $category->icon }}</span>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                            <span class="text-xs text-gray-500">Slug: {{ $category->slug }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $category->is_active ? 'bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                    {{ $category->description ?? 'No description provided.' }}
                </p>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/5">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <span>{{ $category->products()->count() }} Products</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button onclick="moveUp({{ $category->id }})" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all" {{ $loop->first ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <button onclick="moveDown({{ $category->id }})" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all" {{ $loop->last ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <a href="{{ route('admin.product-categories.edit', $category) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all" {{ $category->products()->count() > 0 ? 'disabled' : '' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($categories->isEmpty())
        <div class="text-center py-12 glass-card">
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-surface-800 flex items-center justify-center text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No categories found. Create your first category!</p>
            </div>
        </div>
        @endif
    </div>

    <x-slot:scripts>
        <script>
        function moveUp(categoryId) {
            const cards = Array.from(document.querySelectorAll('[data-category-id]'));
            const currentIndex = cards.findIndex(card => card.dataset.categoryId == categoryId);

            if (currentIndex > 0) {
                // Swap with previous category
                updateCategoryOrder(categoryId, currentIndex, currentIndex - 1);
            }
        }

        function moveDown(categoryId) {
            const cards = Array.from(document.querySelectorAll('[data-category-id]'));
            const currentIndex = cards.findIndex(card => card.dataset.categoryId == categoryId);

            if (currentIndex < cards.length - 1) {
                // Swap with next category
                updateCategoryOrder(categoryId, currentIndex, currentIndex + 1);
            }
        }

        async function updateCategoryOrder(categoryId, fromIndex, toIndex) {
            const cards = Array.from(document.querySelectorAll('[data-category-id]'));
            const fromId = cards[fromIndex].dataset.categoryId;
            const toId = cards[toIndex].dataset.categoryId;

            try {
                const response = await fetch('{{ route('admin.product-categories.update-order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        categories: [
                            { id: fromId, order: toIndex },
                            { id: toId, order: fromIndex }
                        ]
                    })
                });

                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Failed to update order:', error);
            }
        }
        </script>
    </x-slot:scripts>
</x-layouts.app>