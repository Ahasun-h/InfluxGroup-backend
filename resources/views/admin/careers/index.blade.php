<x-layouts.app title="Career Opportunities Management">

    {{-- Debug: Add PHP debug info --}}
    @php
        $debugInfo = [
            'total_jobs' => $jobs->count(),
            'showing_deleted' => $showDeleted ? 'YES' : 'NO',
            'deleted_jobs_count' => \DB::table('career_opportunities')->whereNotNull('deleted_at')->count(),
        ];
    @endphp

    {{-- Temporary debug section --}}
    <div class="bg-yellow-100 dark:bg-yellow-900 p-4 mb-4 rounded-lg">
        <h3 class="font-bold text-lg mb-2">🔍 Debug Info:</h3>
        <pre class="text-xs">{{ print_r($debugInfo, true) }}</pre>
        <div class="mt-2 text-sm">
            <strong>Current View:</strong> {{ $showDeleted ? 'Showing DELETED items only' : 'Showing ACTIVE items (deleted hidden)' }}</br>
            <strong>Total deleted items in database:</strong> {{ \DB::table('career_opportunities')->whereNotNull('deleted_at')->count() }}</br>
            <strong>Items currently visible:</strong> {{ $jobs->count() }}</br>
            <small>💡 Use "View Deleted (X items)" filter to see deleted items</small>
        </div>
    </div>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Career Opportunities</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage job listings and career opportunities.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refresh</span>
                </a>
                @if($showDeleted)
                    <a href="{{ route('admin.careers.index') }}" class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-blue-500 hover:bg-blue-600 text-white font-bold transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to Active Jobs</span>
                    </a>
                @endif
                <a href="{{ route('admin.careers.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Job</span>
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-500 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jobs->count() }}</p>
                </div>
            </div>
            <div class="glass-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Active Jobs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jobs->where('is_active', 1)->count() }}</p>
                </div>
            </div>
            <div class="glass-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-400 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Inactive Jobs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $jobs->where('is_active', 0)->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="glass-card p-4 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Filter by:</span>
                <select id="status-filter" onchange="filterByStatus(this.value)" class="bg-gray-50 dark:bg-surface-800 border-none rounded-xl text-sm px-4 py-2 outline-none focus:ring-2 focus:ring-brand-500 transition-all">
                    <option value="all">All Status</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                    <option value="deleted">View Deleted ({{ \DB::table('career_opportunities')->whereNotNull('deleted_at')->count() }} items)</option>
                </select>
            </div>
            <div class="relative w-full max-w-xs">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="search-input" onkeyup="searchJobs()" placeholder="Search jobs..." class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-surface-800 border-none rounded-xl text-sm outline-none focus:ring-2 focus:ring-brand-500 transition-all">
            </div>
        </div>

        <!-- Jobs Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto text-left">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-surface-800/50">
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Job Position</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Department</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Expiry Date</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5" id="jobs-table">
                        @forelse($jobs as $job)
                        <tr class="job-row group hover:bg-gray-50/50 dark:hover:bg-surface-700/30 transition-colors {{ $job->deleted_at ? 'bg-red-50 dark:bg-red-500/10' : '' }}"
                            data-status="{{ $job->deleted_at ? 'deleted' : ($job->is_active ? 'active' : 'inactive') }}"
                            data-title="{{ strtolower($job->title ?? '') }}"
                            data-department="{{ strtolower($job->department ?? '') }}"
                            data-deleted="{{ $job->deleted_at ? 'true' : 'false' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-brand-500 flex items-center justify-center text-white flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white font-outfit text-sm">{{ $job->title ?? 'No Title' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ \Illuminate\Support\Str::limit($job->description ?? '', 60) }}</p>
                                        @if($job->location)
                                        <p class="text-[10px] text-gray-400 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $job->location }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($job->department)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                    {{ $job->department }}
                                </span>
                                @else
                                <span class="text-gray-400 text-xs">No Department</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-100 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    {{ $job->type ?? 'Full-time' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($job->expiry_date ?? $job->posted_date)
                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                    @if($job->expiry_date)
                                        {{ \Carbon\Carbon::parse($job->expiry_date)->format('M d, Y') }}
                                    @else
                                        {{ $job->posted_date }}
                                    @endif
                                </span>
                                @else
                                <span class="text-gray-400 text-xs">No Expiry Date</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($job->deleted_at)
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">
                                        Deleted
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $job->is_active ? 'bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400' }}">
                                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($job->deleted_at)
                                        <!-- Deleted item actions -->
                                        <button onclick="restoreJob({{ $job->id }})" class="p-2 rounded-lg text-gray-400 hover:text-green-500 hover:bg-green-50 dark:hover:bg-green-500/10 transition-all" title="Restore job">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.careers.destroy', $job->id) }}" method="POST" onsubmit="return confirmPermanentDelete(event, this, {{ $job->id }}, '{{ $job->title ?? 'Job' }}');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="force_delete" value="1">
                                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all" title="Permanently delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <!-- Active item actions -->
                                        <button onclick="toggleStatus({{ $job->id }})" class="p-2 rounded-lg text-gray-400 hover:text-green-500 hover:bg-green-50 dark:hover:bg-green-500/10 transition-all" title="{{ $job->is_active ? 'Deactivate' : 'Activate' }} job">
                                            @if($job->is_active)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            @endif
                                        </button>
                                        <a href="{{ route('admin.careers.edit', $job->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.careers.destroy', $job->id) }}" method="POST" onsubmit="return confirmDelete(event, this, {{ $job->id }}, '{{ $job->title ?? 'Job' }}');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-surface-800 flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">No jobs found. Start by adding one!</p>
                                    <a href="{{ route('admin.careers.create') }}" class="inline-flex items-center gap-2 text-brand-500 hover:text-brand-600 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Your First Job
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
        function filterByStatus(status) {
            if (status === 'deleted') {
                // Load deleted items via AJAX
                loadDeletedItems();
                return;
            }

            // For other filters, use the current items
            const rows = document.querySelectorAll('.job-row');
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function loadDeletedItems() {
            console.log('Loading deleted items...');

            // Show loading indicator
            const tableBody = document.getElementById('jobs-table');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-8">Loading deleted items...</td></tr>';

            // Fetch deleted items
            fetch('/admin/careers?show_deleted=1', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse the HTML and extract the table body
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableBody = doc.querySelector('#jobs-table');

                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                    console.log('✓ Deleted items loaded');

                    // Re-attach event listeners to new delete forms
                    attachDeleteFormListeners();
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-8">No deleted items found</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error loading deleted items:', error);
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-red-500">Error loading deleted items</td></tr>';
            });
        }

        function attachDeleteFormListeners() {
            // Re-attach listeners to dynamically loaded forms
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            console.log('Re-attached listeners to', deleteForms.length, 'delete forms');
        }

        // Debug delete forms on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== CAREERS PAGE DEBUG ===');

            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            console.log('✓ Found', deleteForms.length, 'delete forms');

            deleteForms.forEach((form, index) => {
                console.log(`  Delete form ${index + 1}:`, form.action);
            });

            // Log all job rows (deleted items won't be visible by default now)
            const allRows = document.querySelectorAll('.job-row');
            console.log('✓ Total job rows in DOM:', allRows.length);

            allRows.forEach((row, index) => {
                const title = row.dataset.title || 'Unknown';
                const status = row.dataset.status || 'Unknown';
                console.log(`  Row ${index + 1}: ${title} - Status: ${status}`);
            });

            // Check current filter
            const currentFilter = document.getElementById('status-filter')?.value || 'unknown';
            console.log('✓ Current filter:', currentFilter);

            console.log('Note: Deleted items are hidden by default. Use "Deleted Only" filter to view them.');

            console.log('=== DEBUG COMPLETE ===');
        });

        function searchJobs() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.job-row');
            const statusFilter = document.getElementById('status-filter').value;

            rows.forEach(row => {
                const matchesSearch = row.dataset.title.includes(searchTerm) ||
                                     row.dataset.department.includes(searchTerm);
                const matchesStatus = statusFilter === 'all' || row.dataset.status === statusFilter;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function toggleStatus(jobId) {
            fetch(`/admin/careers/${jobId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error toggling status:', error);
            });
        }

        function confirmDelete(event, form, jobId, jobTitle) {
            console.log('=== DELETE ATTEMPT ===');
            console.log('Job ID:', jobId);
            console.log('Job Title:', jobTitle);
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);

            // Check if form has valid action
            if (!form.action || form.action === '') {
                console.error('Form action is empty!');
                alert('Form action is missing. Please check the form setup.');
                event.preventDefault();
                return false;
            }

            // Show confirmation dialog
            const confirmed = confirm(`Are you sure you want to delete "${jobTitle}"?`);
            if (!confirmed) {
                console.log('Delete cancelled by user');
                event.preventDefault();
                return false;
            }

            console.log('Delete confirmed, proceeding...');
            console.log('=== DELETE SUBMITTED ===');

            // Allow form submission
            return true;
        }

        function confirmPermanentDelete(event, form, jobId, jobTitle) {
            console.log('=== PERMANENT DELETE ATTEMPT ===');
            console.log('Job ID:', jobId);
            console.log('Job Title:', jobTitle);

            const confirmed = confirm(`⚠️ PERMANENT DEletion ⚠️\n\nThis will PERMANENTLY delete "${jobTitle}". This action cannot be undone!\n\nAre you absolutely sure?`);
            if (!confirmed) {
                console.log('Permanent delete cancelled by user');
                event.preventDefault();
                return false;
            }

            console.log('Permanent delete confirmed, proceeding...');
            console.log('=== PERMANENT DELETE SUBMITTED ===');

            return true;
        }

        function restoreJob(jobId) {
            console.log('=== RESTORE ATTEMPT ===');
            console.log('Job ID:', jobId);

            const confirmed = confirm(`Restore this job? It will become active again.`);
            if (!confirmed) {
                console.log('Restore cancelled by user');
                return false;
            }

            console.log('Restore confirmed, proceeding...');

            fetch(`/admin/careers/${jobId}/restore`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Restore response:', data);
                if (data.success) {
                    console.log('✓ Job restored successfully');
                    location.reload();
                } else {
                    alert('Failed to restore job: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('✗ Error restoring job:', error);
                alert('Error restoring job. Please try again.');
            });

            console.log('=== RESTORE REQUEST SENT ===');
        }

        // Debug delete forms on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== CAREERS PAGE DEBUG ===');

            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            console.log('✓ Found', deleteForms.length, 'delete forms');

            deleteForms.forEach((form, index) => {
                console.log(`  Delete form ${index + 1}:`, form.action);
            });

            // Log deleted items count
            const deletedRows = document.querySelectorAll('tr[data-deleted="true"]');
            console.log('✓ Found', deletedRows.length, 'deleted items in DOM');

            // Log all job rows
            const allRows = document.querySelectorAll('.job-row');
            console.log('✓ Total job rows in DOM:', allRows.length);

            allRows.forEach((row, index) => {
                const title = row.dataset.title || 'Unknown';
                const status = row.dataset.status || 'Unknown';
                const deleted = row.dataset.deleted || 'false';
                console.log(`  Row ${index + 1}: ${title} - Status: ${status}, Deleted: ${deleted}`);
            });

            // Check current filter
            const currentFilter = document.getElementById('status-filter')?.value || 'unknown';
            console.log('✓ Current filter:', currentFilter);

            console.log('=== DEBUG COMPLETE ===');
        });
        </script>
    </x-slot:scripts>

</x-layouts.app>