<x-layouts.app title="Content Analytics">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Content Analytics</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Content performance, engagement, and popularity metrics</p>
            </div>
            <div class="flex gap-2">
                <form method="GET" class="inline">
                    <input type="hidden" name="period" value="7">
                    <button type="submit" class="px-4 py-2 rounded-lg font-medium transition-all {{ $period == 7 ? 'bg-brand-500 text-white' : 'bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300' }}">7 Days</button>
                </form>
                <form method="GET" class="inline">
                    <input type="hidden" name="period" value="30">
                    <button type="submit" class="px-4 py-2 rounded-lg font-medium transition-all {{ $period == 30 ? 'bg-brand-500 text-white' : 'bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300' }}">30 Days</button>
                </form>
                <form method="GET" class="inline">
                    <input type="hidden" name="period" value="90">
                    <button type="submit" class="px-4 py-2 rounded-lg font-medium transition-all {{ $period == 90 ? 'bg-brand-500 text-white' : 'bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300' }}">90 Days</button>
                </form>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="glass-card p-2 flex gap-2 overflow-x-auto">
            <a href="{{ route('admin.analytics.index') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700">
                Overview
            </a>
            <a href="{{ route('admin.analytics.website') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700">
                Website
            </a>
            <a href="{{ route('admin.analytics.business') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700">
                Business
            </a>
            <a href="{{ route('admin.analytics.content') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all bg-brand-500 text-white">
                Content
            </a>
        </div>

        <!-- Content Overview Stats -->
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Overview</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Projects</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_projects']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active Projects</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['active_projects']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Completed Projects</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['completed_projects']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_products']) }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Pages -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Most Viewed Pages (Last {{ $period }} Days)</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($topPages as $index => $page)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-surface-700 rounded-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $page->url }}">
                                    {{ \Illuminate\Support\Str::limit($page->url, 60) }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-brand-500">{{ number_format($page->views) }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">views</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                        No page view data available for this period
                    </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Projects by Category -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Projects by Category</h3>
                <div class="space-y-3">
                    @forelse($projectsByCategory as $categoryData)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $categoryData->category->name ?? 'Uncategorized' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($categoryData->count) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">projects</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No project category data available
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Project Page Views -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Most Viewed Project Pages</h3>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @forelse($projectPageViews as $index => $page)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white font-semibold text-xs">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $page->url }}">
                                        {{ \Illuminate\Support\Str::limit($page->url, 40) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($page->views) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">views</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No project page view data available
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Content Management Quick Actions -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Management</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 dark:bg-surface-700 hover:bg-gray-100 dark:hover:bg-surface-600 rounded-xl transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Projects</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($stats['total_projects']) }} total</p>
                    </div>
                </a>

                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 dark:bg-surface-700 hover:bg-gray-100 dark:hover:bg-surface-600 rounded-xl transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Products</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($stats['total_products']) }} total</p>
                    </div>
                </a>

                <a href="{{ route('admin.services-and-solutions.index') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 dark:bg-surface-700 hover:bg-gray-100 dark:hover:bg-surface-600 rounded-xl transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Services</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage services</p>
                    </div>
                </a>

                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-3 px-6 py-4 bg-gray-50 dark:bg-surface-700 hover:bg-gray-100 dark:hover:bg-surface-600 rounded-xl transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4 3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">News</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage news</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Content Performance Tips -->
        <div class="glass-card p-6 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-900/20 dark:to-blue-900/20">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Content Performance Insights</h3>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Monitor which projects get the most views to understand customer interests</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Use page view data to prioritize content updates and improvements</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Track traffic sources to identify which channels bring the most engaged visitors</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
