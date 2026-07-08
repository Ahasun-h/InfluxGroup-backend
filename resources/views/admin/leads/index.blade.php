<x-layouts.app title="Leads Management">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Leads Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Manage and track contact form leads</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">New</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['new'] }}</p>
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">Qualified</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['qualified'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
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
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lost</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['lost'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="glass-card p-6">
            <form method="GET" action="{{ route('admin.leads.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                            <option value="">All Status</option>
                            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ request('status') === 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
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

        <!-- Leads Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-surface-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($leads as $lead)
                            <tr class="hover:bg-gray-50 dark:hover:bg-surface-700 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $lead->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $lead->email }}</div>
                                    @if($lead->phone)
                                        <div class="text-xs text-gray-400 dark:text-gray-500">{{ $lead->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $subjectLabels = [
                                            'general' => 'General Inquiry',
                                            'projects' => 'Project Inquiry',
                                            'products' => 'Product Info',
                                            'support' => 'Tech Support',
                                            'careers' => 'Careers',
                                            'other' => 'Other'
                                        ];
                                        $subjectLabel = $subjectLabels[$lead->subject] ?? ucfirst($lead->subject);
                                    @endphp
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $subjectLabel }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $lead->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $lead->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'new' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'qualified' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'converted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            'lost' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        ];
                                        $statusColor = $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($lead->assignedTo)
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $lead->assignedTo->name }}</div>
                                    @else
                                        <div class="text-sm text-gray-400 dark:text-gray-500">Unassigned</div>
                                    @endif
                                    @if(str_contains($lead->notes ?? '', 'Submitted via Quote Request form'))
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium rounded-full bg-purple-100 text-purple-800 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Quote
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="text-brand-500 hover:text-brand-600 p-1 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900/20" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="mailto:{{ $lead->email }}" class="text-green-500 hover:text-green-600 p-1 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20" title="Send Email">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this lead?');">
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No leads found</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Leads from the contact form will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
