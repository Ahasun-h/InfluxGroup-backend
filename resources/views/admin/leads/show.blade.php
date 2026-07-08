<x-layouts.app title="Lead Details">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Lead Details</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">View and manage lead information</p>
            </div>
            <a href="{{ route('admin.leads.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Leads
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lead Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information -->
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Contact Information
                        </h2>
                        @if(str_contains($lead->notes ?? '', 'Submitted via Quote Request form'))
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Quote Request
                            </span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Name</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $lead->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Email</label>
                            <p class="text-gray-900 dark:text-white font-medium">
                                <a href="mailto:{{ $lead->email }}" class="text-brand-500 hover:text-brand-600">{{ $lead->email }}</a>
                            </p>
                        </div>
                        @if($lead->phone)
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Phone</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $lead->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Submitted Date</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $lead->created_at->format('F j, Y - g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Message Details -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Message Details
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">Subject</label>
                            @php
                                $subjectLabels = [
                                    'general' => 'General Inquiry',
                                    'projects' => 'Project Inquiry',
                                    'products' => 'Product Information',
                                    'support' => 'Technical Support',
                                    'careers' => 'Career Opportunities',
                                    'other' => 'Other'
                                ];
                                $subjectLabel = $subjectLabels[$lead->subject] ?? ucfirst($lead->subject);
                            @endphp
                            @php
                                $subjectBadges = [
                                    'general' => 'bg-gray-100 text-gray-800',
                                    'projects' => 'bg-blue-100 text-blue-800',
                                    'products' => 'bg-green-100 text-green-800',
                                    'support' => 'bg-purple-100 text-purple-800',
                                    'careers' => 'bg-yellow-100 text-yellow-800',
                                    'other' => 'bg-pink-100 text-pink-800'
                                ];
                                $subjectBadge = $subjectBadges[$lead->subject] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $subjectBadge }}">{{ $subjectLabel }}</span>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2">Message</label>
                            <div class="bg-gray-50 dark:bg-surface-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $lead->message }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notes
                    </h2>
                    @if($lead->notes)
                        <div class="bg-gray-50 dark:bg-surface-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $lead->notes }}</p>
                        </div>
                    @else
                        <p class="text-gray-400 dark:text-gray-500 italic">No notes added</p>
                    @endif
                </div>
            </div>

            <!-- Status Management -->
            <div class="space-y-6">
                <!-- Current Status -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Current Status</h2>
                    @php
                        $statusColors = [
                            'new' => 'bg-green-100 text-green-800',
                            'contacted' => 'bg-blue-100 text-blue-800',
                            'qualified' => 'bg-purple-100 text-purple-800',
                            'converted' => 'bg-emerald-100 text-emerald-800',
                            'lost' => 'bg-red-100 text-red-800'
                        ];
                        $statusColor = $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <div class="text-center py-6">
                        <span class="px-6 py-3 text-lg font-bold rounded-full {{ $statusColor }}">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Update Status</h2>
                    <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="qualified" {{ $lead->status === 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="converted" {{ $lead->status === 'converted' ? 'selected' : '' }}>Converted</option>
                                    <option value="lost" {{ $lead->status === 'lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                                <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Add notes about this lead...">{{ $lead->notes ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Assign To</label>
                                <select name="assigned_to" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $lead->assigned_to === $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                                Update Lead
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="glass-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="mailto:{{ $lead->email }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Email
                        </a>
                        @if($lead->phone)
                            <a href="tel:{{ $lead->phone }}" class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call Now
                            </a>
                        @endif
                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this lead?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Lead
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
