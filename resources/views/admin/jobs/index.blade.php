<x-layouts.app title="Job Openings">
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Job Openings</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage recruitment and careers.</p>
            </div>
            <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Post Job</span>
            </a>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-surface-800/50">
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Position</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Department</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($jobs as $job)
                        <tr class="group hover:bg-gray-50/50 dark:hover:bg-surface-700/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $job->department }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600 dark:bg-surface-800 dark:text-gray-400">
                                    {{ $job->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="p-2 rounded-lg text-gray-400 hover:text-brand-500 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">No job openings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
