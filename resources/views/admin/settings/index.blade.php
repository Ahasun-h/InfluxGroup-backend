<x-layouts.app title="Company Info & Settings">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Page Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Company Information</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage global details that appear across the website.</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="glass-card p-6 sm:p-8 space-y-8">
                <!-- Branding Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.172-1.172a4 4 0 115.656 5.656L17 13"></path>
                        </svg>
                        Branding & Identity
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Company Name</label>
                            <input type="text" name="name" value="{{ $info['name'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tagline</label>
                            <input type="text" name="tagline" value="{{ $info['tagline'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Company Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">{{ $info['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-white/5">

                <!-- Contact Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Details
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Support Email</label>
                            <input type="email" name="email" value="{{ $info['email'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Phone Number</label>
                            <input type="text" name="phone" value="{{ $info['phone'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Headquarters Address</label>
                            <input type="text" name="address" value="{{ $info['address'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-100 dark:border-white/5 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center px-10 py-3.5 bg-gradient-to-r from-brand-600 to-brand-400 text-white font-black rounded-2xl shadow-2xl shadow-brand-500/40 transition-all hover:shadow-brand-500/60 hover:-translate-y-1 active:translate-y-0 tracking-tight">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
