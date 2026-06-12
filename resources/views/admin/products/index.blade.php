<x-layouts.app title="Manage Products">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Products Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Add, edit, or remove products from the catalog.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.product-categories.index') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Product</span>
                </a>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="glass-card p-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Filter by:</span>
                <select id="category-filter" onchange="filterByCategory(this.value)" class="bg-gray-50 dark:bg-surface-800 border-none rounded-xl text-sm px-4 py-2 outline-none focus:ring-2 focus:ring-brand-500 transition-all">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-full max-w-xs">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="search-input" onkeyup="searchProducts()" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-surface-800 border-none rounded-xl text-sm outline-none focus:ring-2 focus:ring-brand-500 transition-all">
            </div>
        </div>

        <!-- Products Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto text-left">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-surface-800/50">
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Product</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Category</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5" id="products-table">
                        @forelse($products as $product)
                        <tr class="product-row group hover:bg-gray-50/50 dark:hover:bg-surface-700/30 transition-colors"
                            data-category="{{ $product->category_id }}"
                            data-name="{{ strtolower($product->name) }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-surface-800 overflow-hidden flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white font-outfit text-sm">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ Str::limit($product->description, 50) }}</p>
                                        @if($product->slug)
                                        <p class="text-[10px] text-gray-400">/{{ $product->slug }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->productCategory)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-100 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    {{ $product->productCategory->name }}
                                </span>
                                @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">
                                    {{ $product->category }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $product->is_active ? 'bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-surface-800 flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">No products found. Start by adding one!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <x-slot:scripts>
        <script>
        function filterByCategory(categoryId) {
            const rows = document.querySelectorAll('.product-row');
            rows.forEach(row => {
                if (categoryId === 'all' || row.dataset.category === categoryId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function searchProducts() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.product-row');
            const categoryFilter = document.getElementById('category-filter').value;

            rows.forEach(row => {
                const matchesSearch = row.dataset.name.includes(searchTerm);
                const matchesCategory = categoryFilter === 'all' || row.dataset.category === categoryFilter;

                if (matchesSearch && matchesCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        </script>
    </x-slot:scripts>
</x-layouts.app>
