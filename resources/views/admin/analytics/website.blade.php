<x-layouts.app title="Website Analytics">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Website Analytics</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Detailed website performance metrics and visitor data</p>
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
               class="px-6 py-3 rounded-lg font-semibold transition-all bg-brand-500 text-white">
                Website
            </a>
            <a href="{{ route('admin.analytics.business') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700">
                Business
            </a>
            <a href="{{ route('admin.analytics.content') }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-700">
                Content
            </a>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Unique Visitors</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['unique_visitors']) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Page Views</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_page_views']) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Returning Visitors</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['returning_visitors']) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Avg Page Views/Visitor</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['avg_page_views_per_visitor'], 1) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visitors by Day Chart -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Visitors Trend (Last {{ $period }} Days)</h3>
            <div class="h-64 flex items-end gap-2">
                @forelse($visitorsByDay as $data)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-brand-500 rounded-t hover:bg-brand-600 transition-all cursor-pointer"
                             style="height: {{ ($data->count / $visitorsByDay->max('count')) * 100 }}%"
                             title="{{ $data->date }}: {{ $data->count }} visitors">
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transform -rotate-45 origin-top-left">
                            {{ \Carbon\Carbon::parse($data->date)->format('M d') }}
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center text-gray-500 dark:text-gray-400">
                        No visitor data available for this period
                    </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Pages -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Pages</h3>
                <div class="space-y-3">
                    @forelse($topPages as $page)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $page->url }}</p>
                            </div>
                            <div class="ml-4 flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($page->views) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">views</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No page view data available
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Device Types -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Device Types</h3>
                <div class="space-y-3">
                    @forelse($deviceTypes as $device)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($device->device_type === 'mobile')
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($device->device_type === 'tablet')
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                                <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $device->device_type ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($device->count) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    ({{ $deviceTypes->sum('count') > 0 ? round(($device->count / $deviceTypes->sum('count')) * 100, 1) : 0 }}%)
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No device data available
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Traffic Sources -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Traffic Sources</h3>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @forelse($trafficSources as $source)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $source->referer }}">
                                    {{ \Illuminate\Support\Str::limit($source->referer, 50) }}
                                </p>
                            </div>
                            <div class="ml-4 flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($source->count) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">visits</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No traffic source data available
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Browsers -->
            <div class="glass-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Browsers</h3>
                <div class="space-y-3">
                    @forelse($browsers as $browser)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $browser->browser ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-brand-500">{{ number_format($browser->count) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    ({{ $browsers->sum('count') > 0 ? round(($browser->count / $browsers->sum('count')) * 100, 1) : 0 }}%)
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            No browser data available
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
