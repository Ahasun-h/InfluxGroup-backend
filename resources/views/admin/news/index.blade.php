<x-layouts.app title="Manage News & Updates">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">News & Updates</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Share your latest news and company updates.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.categories.index', ['area' => 'news']) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-gray-100 dark:bg-surface-800 hover:bg-gray-200 dark:hover:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold transition-all gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>News Categories</span>
                </a>
                <a href="{{ route('admin.news.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Article</span>
                </a>
            </div>
        </div>

        <!-- Category Filter -->
        @if($categories->isNotEmpty())
        <div class="flex items-center gap-2 flex-wrap">
            <button onclick="filterByCategory('all')" class="category-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all" data-category="all">
                All News
            </button>
            @foreach($categories as $category)
            <button onclick="filterByCategory('{{ $category->id }}')" class="category-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all" data-category="{{ $category->id }}">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
        @endif

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="news-grid">
            @forelse($news as $article)
            <div class="glass-card overflow-hidden group" data-category="{{ $article->category_id }}">
                <div class="relative h-48 overflow-hidden">
                    @if($article->image)
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-surface-800 dark:to-surface-700 flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        @if($article->featured)
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-yellow-500 text-white shadow-sm">
                            Featured
                        </span>
                        @endif
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                            @if($article->is_published) bg-green-500 text-white
                            @else bg-gray-500 text-white @endif shadow-sm">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        @if($article->category)
                        <span class="text-xs font-semibold text-brand-500 uppercase tracking-wider">{{ $article->category }}</span>
                        @endif
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit line-clamp-2 mt-1">{{ $article->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mt-2">{{ $article->excerpt }}</p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.news.edit', $article) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" onsubmit="return confirm('Delete this article?');">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No news articles found. Share your first update!</p>
            </div>
            @endforelse
        </div>

        @if($news->hasPages())
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        @endif
    </div>

    <script>
        function filterByCategory(categoryId) {
            const cards = document.querySelectorAll('#news-grid > div');
            const buttons = document.querySelectorAll('.category-filter-btn');

            // Update button styles
            buttons.forEach(btn => {
                if (btn.dataset.category === categoryId) {
                    btn.classList.add('bg-brand-500', 'text-white');
                    btn.classList.remove('bg-gray-100', 'dark:bg-surface-800', 'text-gray-700', 'dark:text-gray-300');
                } else {
                    btn.classList.remove('bg-brand-500', 'text-white');
                    btn.classList.add('bg-gray-100', 'dark:bg-surface-800', 'text-gray-700', 'dark:text-gray-300');
                }
            });

            // Filter cards
            cards.forEach(card => {
                if (categoryId === 'all' || card.dataset.category === categoryId) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Initialize first button as active
        document.addEventListener('DOMContentLoaded', () => {
            filterByCategory('all');
        });
    </script>
</x-layouts.app>
