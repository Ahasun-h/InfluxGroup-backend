<x-layouts.app title="Add Testimonial">
    <div class="max-w-xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.testimonials.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Add Testimonial</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add social proof from a satisfied client.</p>
            </div>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="glass-card p-6 sm:p-8 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Client Name</label>
                    <input type="text" name="name" id="name" required placeholder="e.g. John Doe"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Position</label>
                        <input type="text" name="position" id="position" placeholder="e.g. CEO"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                    </div>
                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Company</label>
                        <input type="text" name="company" id="company" placeholder="e.g. Global Power"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="rating" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Rating (1-5)</label>
                    <select name="rating" id="rating" required
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Testimonial Content</label>
                    <textarea name="content" id="content" rows="4" required placeholder="What did the client say?"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"></textarea>
                </div>

                <div class="pt-6 flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                        Add Testimonial
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
