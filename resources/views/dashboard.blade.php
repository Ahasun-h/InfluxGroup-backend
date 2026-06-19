<x-layouts.app title="Admin Dashboard">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 to-brand-400 p-8 md:p-10 text-white shadow-xl shadow-brand-500/20">
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold font-outfit tracking-tight">Project Dashboard</h1>
                    <p class="text-brand-50 mt-2 text-lg font-medium opacity-90">Welcome back, {{ Auth::user()->name }}! Here's your project overview.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="px-5 py-2.5 bg-white text-brand-600 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        New Project
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass-card p-6 border-l-4 border-brand-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Projects</p>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['projects']['total'] }}</p>
                        <p class="text-sm font-semibold text-green-600 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            {{ $stats['projects']['active'] }} Active
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-7 h-7 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed</p>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['projects']['completed'] }}</p>
                        <p class="text-sm font-semibold text-gray-500 mt-2">Projects Done</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-green-100 dark:bg-green-500/10 flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Value</p>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">${{ number_format($stats['projects']['total_value'], 0) }}</p>
                        <p class="text-sm font-semibold text-blue-600 mt-2">Project Portfolio</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categories</p>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['categories'] }}</p>
                        <p class="text-sm font-semibold text-purple-600 mt-2">Total Categories</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 12h.01M7 17h.01M12 7h.01M12 12h.01M12 17h.01M17 7h.01M17 12h.01M17 17h.01z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="glass-card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['products'] }}</p>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Products</p>
                </div>
            </div>

            <div class="glass-card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 dark:bg-cyan-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['news'] }}</p>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">News Articles</p>
                </div>
            </div>

            <div class="glass-card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['gallery'] }}</p>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Gallery Items</p>
                </div>
            </div>

            <div class="glass-card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['testimonials'] }}</p>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Testimonials</p>
                </div>
            </div>
        </div>

        <!-- Charts and Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Project Status Chart -->
                <div class="glass-card p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white font-outfit mb-6">Projects by Status</h3>
                    <div class="h-64">
                        <canvas id="projectStatusChart"></canvas>
                    </div>
                </div>

                <!-- Recent Projects Table -->
                <div class="glass-card overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-surface-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white font-outfit">Recent Projects</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Latest project updates and status</p>
                            </div>
                            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-sm font-bold text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/10 rounded-lg transition-all">View all</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-surface-800/50">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Project</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Location</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Completion</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-surface-700">
                                @forelse($recentProjects as $project)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-surface-800/40 transition-all cursor-pointer">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-100 to-brand-200 dark:from-brand-500/20 dark:to-brand-500/10 flex items-center justify-center text-brand-600 dark:text-brand-400 font-bold text-sm">
                                                {{ substr($project->title, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $project->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $project->client }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $project->location }}</td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold
                                            @if($project->status == 'active') bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-500/20
                                            @elseif($project->status == 'completed') bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20
                                            @elseif($project->status == 'pending') bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20
                                            @else bg-gray-50 dark:bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-100 dark:border-gray-500/20
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full
                                                @if($project->status == 'active') bg-green-500 animate-pulse
                                                @elseif($project->status == 'completed') bg-blue-500
                                                @elseif($project->status == 'pending') bg-orange-500
                                                @else bg-gray-500
                                                @endif"></span>
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-gray-100 dark:bg-surface-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-brand-500 to-brand-600 rounded-full transition-all duration-500" style="width: {{ $project->completion }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $project->completion }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-extrabold text-gray-900 dark:text-white text-right">${{ number_format($project->value) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="font-semibold">No projects yet</p>
                                        <p class="text-sm mt-1">Create your first project to get started</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="space-y-8">
                <!-- Upcoming Deadlines -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit mb-4">Upcoming Deadlines</h3>
                    <div class="space-y-4">
                        @forelse($upcomingDeadlines as $deadline)
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-surface-800 border border-gray-100 dark:border-surface-700">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $deadline->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $deadline->location }}</p>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    <p class="text-xs font-bold text-brand-600">{{ $deadline->expected_completion->format('M d') }}</p>
                                    <p class="text-xs text-gray-400">{{ $deadline->expected_completion->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-200 dark:bg-surface-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-brand-500 to-brand-600 rounded-full" style="width: {{ $deadline->completion }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $deadline->completion }}%</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-semibold">No upcoming deadlines</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Project Status Chart
        const ctx = document.getElementById('projectStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Completed', 'Pending', 'On Hold'],
                datasets: [{
                    data: [
                        {{ $projectsByStatus['active'] ?? 0 }},
                        {{ $projectsByStatus['completed'] ?? 0 }},
                        {{ $projectsByStatus['pending'] ?? 0 }},
                        {{ $projectsByStatus['on_hold'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#10b981', // green for active
                        '#3b82f6', // blue for completed
                        '#f59e0b', // orange for pending
                        '#6b7280'  // gray for on hold
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif"
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
</x-layouts.app>