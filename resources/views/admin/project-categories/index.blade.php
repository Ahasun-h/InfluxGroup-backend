<x-layouts.app title="Manage Project Categories">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Project Categories</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage project categories for better organization.</p>
            </div>
            <a href="{{ route('admin.project-categories.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Category</span>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="glass-card overflow-hidden group h-full flex flex-col">
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-brand-500 to-brand-700">
                    @if($category->image)
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                    @elseif($category->icon)
                        <div class="w-full h-full flex items-center justify-center text-white/90 bg-gradient-to-br from-brand-500 to-brand-700">
                            <div class="w-24 h-24">{!! $category->icon !!}</div>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/30">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold @if($category->is_active) bg-green-500 text-white @else bg-gray-500 text-white @endif">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-6 space-y-4 flex-1 flex flex-col">
                    <div class="flex items-start gap-3">
                        @if($category->icon && $category->image)
                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-surface-800 rounded-lg flex items-center justify-center border border-gray-200 dark:border-white/10">
                                <div class="w-6 h-6 text-brand-500">{!! $category->icon !!}</div>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit truncate">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/10 mt-auto">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Order: {{ $category->order }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.project-categories.edit', $category) }}" class="text-brand-500 hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2h2.828l2.758-2.758a2 2 0 012.828 0z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.project-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 011-1h2a1 1 0 011 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-surface-800 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Categories Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first project category.</p>
                <a href="{{ route('admin.project-categories.create') }}" class="inline-flex items-center px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition">
                    Create Category
                </a>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
