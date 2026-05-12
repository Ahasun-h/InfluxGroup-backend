<x-layouts.app title="Create Project">
    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.projects.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Add New Project</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new project to your portfolio.</p>
            </div>
        </div>

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category" id="category" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="power" {{ old('category') == 'power' ? 'selected' : '' }}>Power Generation</option>
                                    <option value="transmission" {{ old('category') == 'transmission' ? 'selected' : '' }}>Transmission</option>
                                    <option value="renewable" {{ old('category') == 'renewable' ? 'selected' : '' }}>Renewable Energy</option>
                                    <option value="industrial" {{ old('category') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                </select>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="e.g. Dhaka, Bangladesh"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="client" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Client</label>
                                <input type="text" name="client" id="client" value="{{ old('client') }}" placeholder="e.g. BPDB, DESCO"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="capacity" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Capacity / Scale</label>
                                <input type="text" name="capacity" id="capacity" value="{{ old('capacity') }}" placeholder="e.g. 100MW, 230kV"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Type</label>
                                <input type="text" name="type" id="type" value="{{ old('type') }}" placeholder="e.g. EPC, Consultancy"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="completion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Completion (%)</label>
                                <input type="text" name="completion" id="completion" value="{{ old('completion') }}" placeholder="e.g. 85%"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Project Value</label>
                                <input type="text" name="value" id="value" value="{{ old('value') }}" placeholder="e.g. $50M"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>

                            <div>
                                <label for="expected_completion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Expected Completion</label>
                                <input type="date" name="expected_completion" id="expected_completion" value="{{ old('expected_completion') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Sections (Scope, Highlights, Stats) -->
                    <div class="space-y-6" x-data="{ 
                        scopes: [''], 
                        highlights: [''],
                        stats: [{label: '', value: ''}]
                    }">
                        <!-- Project Scope -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Scope</h3>
                                <button type="button" @click="scopes.push('')" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(scope, index) in scopes" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="scope[]" x-model="scopes[index]" placeholder="e.g. Design & Engineering"
                                            class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <button type="button" @click="scopes.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="scopes.length > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Key Highlights -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Key Highlights</h3>
                                <button type="button" @click="highlights.push('')" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(highlight, index) in highlights" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="highlights[]" x-model="highlights[index]" placeholder="e.g. Zero LTI achieved"
                                            class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <button type="button" @click="highlights.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="highlights.length > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Project Stats -->
                        <div class="glass-card p-6 sm:p-8 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Stats</h3>
                                <button type="button" @click="stats.push({label: '', value: ''})" class="text-xs font-bold text-brand-500 hover:text-brand-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Stat
                                </button>
                            </div>
                            <div class="space-y-3">
                                <template x-for="(stat, index) in stats" :key="index">
                                    <div class="grid grid-cols-2 gap-2 relative group">
                                        <input type="text" :name="'stats['+index+'][label]'" x-model="stat.label" placeholder="Label (e.g. Concrete)"
                                            class="px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                        <div class="flex gap-2">
                                            <input type="text" :name="'stats['+index+'][value]'" x-model="stat.value" placeholder="Value (e.g. 5000m³)"
                                                class="flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                            <button type="button" @click="stats.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 transition-colors" x-show="stats.length > 1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Meta -->
                <div class="space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Featured Image</h3>
                        <div class="relative group aspect-video">
                            <div class="w-full h-full rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 group-hover:border-brand-500 transition-all overflow-hidden relative">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-center px-4">Upload main image</span>
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Project Gallery</h3>
                        <div class="relative group h-24">
                            <div class="w-full h-full rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 group-hover:border-brand-500 transition-all overflow-hidden relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Add Multiple Images</span>
                                <input type="file" name="additional_images[]" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="featured" value="1" class="sr-only peer">
                                <div class="w-10 h-6 bg-gray-200 dark:bg-surface-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-brand-500 transition-colors">Mark as Featured</span>
                        </label>
                    </div>

                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3 sticky top-8">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Save Project
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
