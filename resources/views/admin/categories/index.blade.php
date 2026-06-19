<x-layouts.app title="Categories Management">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Categories</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage categories for all your content types</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                New Category
            </a>
        </div>

        <!-- Service Area Tabs -->
        <div class="border-b border-gray-200 dark:border-surface-700">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('admin.categories.index', ['area' => 'all']) }}"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                          {{ $serviceArea === 'all' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    All Categories
                    <span class="bg-gray-100 dark:bg-surface-700 text-gray-600 dark:text-gray-300 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $counts['all'] }}</span>
                </a>
                <a href="{{ route('admin.categories.index', ['area' => 'product']) }}"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                          {{ $serviceArea === 'product' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Products
                    <span class="bg-gray-100 dark:bg-surface-700 text-gray-600 dark:text-gray-300 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $counts['product'] }}</span>
                </a>
                <a href="{{ route('admin.categories.index', ['area' => 'project']) }}"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                          {{ $serviceArea === 'project' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Projects
                    <span class="bg-gray-100 dark:bg-surface-700 text-gray-600 dark:text-gray-300 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $counts['project'] }}</span>
                </a>
                <a href="{{ route('admin.categories.index', ['area' => 'service']) }}"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                          {{ $serviceArea === 'service' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Services
                    <span class="bg-gray-100 dark:bg-surface-700 text-gray-600 dark:text-gray-300 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $counts['service'] }}</span>
                </a>
                <a href="{{ route('admin.categories.index', ['area' => 'news']) }}"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                          {{ $serviceArea === 'news' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    News
                    <span class="bg-gray-100 dark:bg-surface-700 text-gray-600 dark:text-gray-300 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $counts['news'] }}</span>
                </a>
            </nav>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="categories-container">
                @foreach($categories as $category)
                    <div class="glass-card p-6 hover:shadow-lg transition-shadow duration-200" data-category-id="{{ $category->id }}" data-category-order="{{ $category->order }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                @if($category->icon)
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 dark:from-brand-500/20 dark:to-brand-500/10 flex items-center justify-center text-brand-600 dark:text-brand-400">
                                        {!! $category->icon !!}
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 dark:from-brand-500/20 dark:to-brand-500/10 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold text-lg">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($category->service_area === 'product') bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400
                                        @elseif($category->service_area === 'project') bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400
                                        @elseif($category->service_area === 'service') bg-purple-100 text-purple-800 dark:bg-purple-500/20 dark:text-purple-400
                                        @else bg-orange-100 text-orange-800 dark:bg-orange-500/20 dark:text-orange-400
                                        @endif">
                                        {{ ucfirst($category->service_area) }}
                                    </span>
                                </div>
                            </div>
                            @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-400">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        @if($category->description)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $category->description }}</p>
                        @else
                            <p class="text-gray-400 dark:text-gray-500 text-sm mb-4 italic">No description</p>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-surface-700">
                            <div class="flex items-center gap-2">
                                <button onclick="moveCategory({{ $category->id }}, 'up')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors" title="Move Up">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <button onclick="moveCategory({{ $category->id }}, 'down')" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors" title="Move Down">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors" title="Edit">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/20 transition-colors" title="Delete">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 12h.01M7 17h.01M12 7h.01M12 12h.01M12 17h.01M17 7h.01M17 12h.01M17 17h.01z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No categories found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first category</p>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white rounded-lg font-medium hover:bg-brand-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Create Category
                </a>
            </div>
        @endif
    </div>

    <form id="delete-form" method="POST" action="{{ route('admin.categories.destroy', ':id') }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function moveCategory(categoryId, direction) {
            const container = document.getElementById('categories-container');
            const cards = Array.from(container.children);
            const currentIndex = cards.findIndex(card => card.dataset.categoryId == categoryId);

            if (currentIndex === -1) return;

            const newIndex = direction === 'up' ? currentIndex - 1 : currentIndex + 1;

            if (newIndex < 0 || newIndex >= cards.length) return;

            // Swap the cards
            const temp = cards[currentIndex].innerHTML;
            cards[currentIndex].innerHTML = cards[newIndex].innerHTML;
            cards[newIndex].innerHTML = temp;

            // Update the data attributes
            const tempId = cards[currentIndex].dataset.categoryId;
            const tempOrder = cards[currentIndex].dataset.categoryOrder;

            cards[currentIndex].dataset.categoryId = cards[newIndex].dataset.categoryId;
            cards[currentIndex].dataset.categoryOrder = cards[newIndex].dataset.categoryOrder;

            cards[newIndex].dataset.categoryId = tempId;
            cards[newIndex].dataset.categoryOrder = tempOrder;

            // Collect new order and submit
            const categories = [];
            container.querySelectorAll('[data-category-id]').forEach((card, index) => {
                categories.push({
                    id: card.dataset.categoryId,
                    order: index
                });
            });

            fetch('{{ route("admin.categories.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                },
                body: JSON.stringify({ categories: categories })
            }).then(response => response.json()).then(data => {
                // Success
            }).catch(error => {
                console.error('Error updating order:', error);
            });
        }

        function confirmDelete(categoryId, categoryName) {
            if (confirm(`Are you sure you want to delete "${categoryName}"? This action cannot be undone.`)) {
                const form = document.getElementById('delete-form');
                form.action = form.action.replace(':id', categoryId);
                form.submit();
            }
        }
    </script>
</x-layouts.app>