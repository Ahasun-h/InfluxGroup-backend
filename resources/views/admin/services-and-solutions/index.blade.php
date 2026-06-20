<x-layouts.app title="Manage Services & Solutions">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Services & Solutions</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your service offerings and solution packages.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.categories.index', ['area' => 'service']) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-gray-100 dark:bg-surface-800 hover:bg-gray-200 dark:hover:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold transition-all gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.services-and-solutions.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Item</span>
                </a>
            </div>
        </div>

        <!-- Type Filter Tabs -->
        <div class="glass-card p-4 flex gap-2">
            <button onclick="filterByType('all')" class="px-6 py-2 rounded-xl font-bold text-sm transition-all type-filter active" data-type="all">
                All Items
            </button>
            <button onclick="filterByType('service')" class="px-6 py-2 rounded-xl font-bold text-sm transition-all type-filter" data-type="service">
                Services
            </button>
            <button onclick="filterByType('solution')" class="px-6 py-2 rounded-xl font-bold text-sm transition-all type-filter" data-type="solution">
                Solutions
            </button>
        </div>

        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="items-grid">
            @forelse($items as $item)
            <div class="glass-card overflow-hidden group item-card" data-type="{{ $item->type }}">
                <div class="relative h-48 overflow-hidden">
                    @if($item->image)
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                    @else
                        <div class="w-full h-full bg-gray-100 dark:bg-surface-800 flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                            @if($item->type == 'service') bg-brand-500 text-white
                            @else bg-industrial-blue text-white @endif shadow-sm">
                            {{ $item->type }}
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        @if($item->is_active)
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-green-500 text-white shadow-sm">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-gray-500 text-white shadow-sm">
                                Inactive
                            </span>
                        @endif
                    </div>
                    @if($item->category)
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/90 dark:bg-surface-900/90 text-gray-900 dark:text-white backdrop-blur-md shadow-sm">
                            {{ $item->category }}
                        </span>
                    </div>
                    @endif
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit line-clamp-1">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.services-and-solutions.edit', $item) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                        <form action="{{ route('admin.services-and-solutions.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="md:col-span-3 py-12 glass-card flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-surface-800 flex items-center justify-center text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No services or solutions found. Create your first offering!</p>
            </div>
            @endforelse
        </div>

        @if($items->hasPages())
            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @endif
    </div>

    <x-slot:styles>
    <style>
        .type-filter {
            background: #f3f4f6;
            color: #6b7280;
        }
        .type-filter:hover {
            background: #e5e7eb;
        }
        .type-filter.active {
            background: #0d9488;
            color: white;
        }
        .dark .type-filter {
            background: #1e293b;
            color: #94a3b8;
        }
        .dark .type-filter:hover {
            background: #334155;
        }
        .dark .type-filter.active {
            background: #0d9488;
            color: white;
        }
    </style>
    </x-slot:styles>

    <x-slot:scripts>
    <script>
        function filterByType(type) {
            // Update button styles
            document.querySelectorAll('.type-filter').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.type === type) {
                    btn.classList.add('active');
                }
            });

            // Filter items
            document.querySelectorAll('.item-card').forEach(card => {
                if (type === 'all' || card.dataset.type === type) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    </x-slot:scripts>
</x-layouts.app>