<x-layouts.app title="{{ $customer->name }}">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.index') }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-700 transition-all">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">{{ $customer->name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $customer->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="mailto:{{ $customer->email }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Send Email
                </a>
            </div>
        </div>

        <!-- Customer Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lifetime Value</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($customer->lifetime_value, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($customer->total_orders) }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Interactions</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $customer->interactions()->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">First Contact</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $customer->first_contact_at ? $customer->first_contact_at->format('M d') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($customer->company)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Company</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $customer->company }}</p>
                            </div>
                        @endif
                        @if($customer->phone)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $customer->phone }}</p>
                            </div>
                        @endif
                        @if($customer->industry)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Industry</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $customer->industry }}</p>
                            </div>
                        @endif
                        @if($customer->address)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $customer->address }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Source</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($customer->source ?? 'N/A') }}</p>
                        </div>
                        @if($customer->assignedTo)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Assigned To</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $customer->assignedTo->name }}</p>
                            </div>
                        @endif
                    </div>
                    @if($customer->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="text-gray-900 dark:text-white mt-1">{{ $customer->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Interactions Timeline -->
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Interaction History</h2>
                        <button type="button" onclick="document.getElementById('addInteractionForm').classList.toggle('hidden')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-lg font-semibold transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Interaction
                        </button>
                    </div>

                    <!-- Add Interaction Form (Hidden by default) -->
                    <div id="addInteractionForm" class="hidden mb-6 p-4 bg-gray-50 dark:bg-surface-700 rounded-xl">
                        <form method="POST" action="{{ route('admin.customers.add-interaction', $customer) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Type</label>
                                    <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-surface-800 text-gray-900 dark:text-white">
                                        <option value="note">Note</option>
                                        <option value="email">Email</option>
                                        <option value="call">Phone Call</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="quote">Quote</option>
                                        <option value="lead">Lead</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                    <input type="text" name="subject" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-surface-800 text-gray-900 dark:text-white" placeholder="Optional subject">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Content</label>
                                <textarea name="content" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-surface-800 text-gray-900 dark:text-white" placeholder="Interaction details..."></textarea>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg font-semibold transition-all">Save</button>
                                <button type="button" onclick="document.getElementById('addInteractionForm').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-semibold transition-all">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Timeline -->
                    <div class="space-y-4">
                        @forelse($interactions as $interaction)
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full @if($interaction->type === 'email') bg-blue-100 text-blue-600 @elseif($interaction->type === 'call') bg-green-100 text-green-600 @elseif($interaction->type === 'meeting') bg-purple-100 text-purple-600 @else bg-gray-100 text-gray-600 @endif flex items-center justify-center">
                                        @if($interaction->type === 'email')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        @elseif($interaction->type === 'call')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        @elseif($interaction->type === 'meeting')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700 my-2"></div>
                                </div>
                                <div class="flex-1 pb-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $interaction->type_label }}</p>
                                            @if($interaction->subject)
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $interaction->subject }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $interaction->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $interaction->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    @if($interaction->content)
                                        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $interaction->content }}</p>
                                    @endif
                                    @if($interaction->createdBy)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">By {{ $interaction->createdBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                No interactions yet. Add your first interaction above.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Related Data -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Data</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.leads.index') }}?search={{ $customer->email }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-600 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Leads</span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->leads->count() }}</span>
                        </a>
                        <a href="{{ route('admin.quote-requests.index') }}?search={{ $customer->email }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-600 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Quote Requests</span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->quoteRequests->count() }}</span>
                        </a>
                        <a href="{{ route('admin.quotations.index') }}?search={{ $customer->email }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-surface-700 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-600 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Quotations</span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->quotations->count() }}</span>
                        </a>
                    </div>
                </div>

                <!-- Tags -->
                @if($customer->tags && count($customer->tags) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($customer->tags as $tag)
                                <span class="px-3 py-1 bg-brand-100 text-brand-800 dark:bg-brand-900 dark:text-brand-200 rounded-full text-sm">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
