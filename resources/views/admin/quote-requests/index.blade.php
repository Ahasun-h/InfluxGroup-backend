<x-layouts.app title="Quote Requests Management">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Quote Requests
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Manage and convert client quote requests</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Contacted</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['contacted'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quoted</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['quoted'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Converted</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['converted'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="glass-card p-6">
            <form method="GET" action="{{ route('admin.quote-requests.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email or company..." class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="quoted" {{ request('status') === 'quoted' ? 'selected' : '' }}>Quoted</option>
                            <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quote Requests Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-surface-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($quoteRequests as $quoteRequest)
                            <tr class="hover:bg-gray-50 dark:hover:bg-surface-700 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $quoteRequest->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $quoteRequest->email }}</div>
                                    @if($quoteRequest->phone)
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $quoteRequest->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $quoteRequest->company ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $quoteRequest->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $quoteRequest->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $quoteRequest->status_badge_color }}">
                                        {{ $quoteRequest->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.quote-requests.show', $quoteRequest) }}" class="text-brand-500 hover:text-brand-600 p-1 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900/20" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @if(!$quoteRequest->quotation_id)
                                            <a href="{{ route('admin.quote-requests.convert', $quoteRequest) }}" class="text-green-500 hover:text-green-600 p-1 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20" title="Convert to Quotation">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.quotations.show', $quoteRequest->quotation_id) }}" class="text-purple-500 hover:text-purple-600 p-1 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20" title="View Quotation">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.quote-requests.destroy', $quoteRequest) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quote request?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No quote requests found</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Quote requests submitted via the contact form will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($quoteRequests->hasPages())
                <div class="bg-gray-50 dark:bg-surface-700 px-6 py-4">
                    {{ $quoteRequests->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>