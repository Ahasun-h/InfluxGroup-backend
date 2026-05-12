<x-layouts.app title="Post Job">
    <div class="max-w-2xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.jobs.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Post New Job</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a career opportunity to the website.</p>
            </div>
        </div>

        <form action="{{ route('admin.jobs.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="glass-card p-6 sm:p-8 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Title</label>
                    <input type="text" name="title" id="title" required placeholder="e.g. Electrical Engineer"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="department" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Department</label>
                        <input type="text" name="department" id="department" required placeholder="e.g. Engineering"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Type</label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            <option value="Full-time">Full-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Location</label>
                    <input type="text" name="location" id="location" required placeholder="e.g. Dhaka, Bangladesh"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Description</label>
                    <textarea name="description" id="description" rows="8" required placeholder="Detail the role, requirements, and benefits..."
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"></textarea>
                </div>

                <div class="pt-6 flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                        Post Job Opening
                    </button>
                    <a href="{{ route('admin.jobs.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
