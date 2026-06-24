<x-layouts.app title="Quote Request #{{ $quoteRequest->id }}">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">
                        Quote Request #{{ $quoteRequest->id }}
                    </h1>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $quoteRequest->status_badge_color }}">
                        {{ $quoteRequest->status_label }}
                    </span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">
                    Received on {{ $quoteRequest->created_at->format('F d, Y') }}
                </p>
            </div>
            <div class="flex gap-2">
                @if(!$quoteRequest->quotation_id)
                    <a href="{{ route('admin.quote-requests.convert', $quoteRequest) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Convert to Quotation
                    </a>
                @else
                    <a href="{{ route('admin.quotations.show', $quoteRequest->quotation_id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        View Quotation
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Quote Request Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Client Information -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Client Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-white">{{ $quoteRequest->email }}</p>
                        </div>
                        @if($quoteRequest->phone)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                <p class="text-gray-900 dark:text-white">{{ $quoteRequest->phone }}</p>
                            </div>
                        @endif
                        @if($quoteRequest->company)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Company</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->company }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Requirements -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Requirements</h2>
                    </div>

                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $quoteRequest->requirements }}</p>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Timeline</h2>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-brand-500"></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Request Received</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->created_at->format('F d, Y - H:i') }}</p>
                            </div>
                        </div>
                        @if($quoteRequest->contacted_at)
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Contacted</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->contacted_at->format('F d, Y - H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($quoteRequest->quoted_at)
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Quotation Sent</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->quoted_at->format('F d, Y - H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Actions -->
            <div class="space-y-6">
                <!-- Status Management -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Status</h2>
                    </div>

                    <form action="{{ route('admin.quote-requests.update-status', $quoteRequest) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Update Status</label>
                                <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="pending" {{ $quoteRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="contacted" {{ $quoteRequest->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="quoted" {{ $quoteRequest->status === 'quoted' ? 'selected' : '' }}>Quoted</option>
                                    <option value="converted" {{ $quoteRequest->status === 'converted' ? 'selected' : '' }}>Converted</option>
                                    <option value="closed" {{ $quoteRequest->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
                                <textarea name="admin_notes" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none" placeholder="Add notes about this request...">{{ $quoteRequest->admin_notes }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-4 py-3 rounded-xl font-semibold transition-all">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Actions</h2>
                    </div>

                    <div class="space-y-2">
                        @if(!$quoteRequest->quotation_id)
                            <a href="{{ route('admin.quote-requests.convert', $quoteRequest) }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Convert to Quotation
                            </a>
                        @else
                            <a href="{{ route('admin.quotations.show', $quoteRequest->quotation_id) }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                View Quotation
                            </a>
                            <a href="{{ route('admin.quotations.pdf', $quoteRequest->quotation_id) }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Quotation PDF
                            </a>
                        @endif

                        <a href="mailto:{{ $quoteRequest->email }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Email
                        </a>

                        <a href="{{ route('admin.quote-requests.index') }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>

                @if($quoteRequest->admin_notes)
                    <!-- Admin Notes -->
                    <div class="glass-card p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Admin Notes</h2>
                        </div>

                        <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $quoteRequest->admin_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>