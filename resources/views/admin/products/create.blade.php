<x-layouts.app title="Create Product">
    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Create New Product</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new item to your product catalog.</p>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Basic Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Product Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Display Name</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., Transformers">
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Short name for badges and filters</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Short Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="overview" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Detailed Overview</label>
                                <textarea name="overview" id="overview" rows="5"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">{{ old('overview') }}</textarea>
                                <x-input-error :messages="$errors->get('overview')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Technical Specifications</h3>
                        <div id="specifications-container">
                            <div class="specification-item grid grid-cols-2 gap-3 mb-3">
                                <input type="text" name="specifications[]"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="Label (e.g., Voltage)">
                                <input type="text" name="specifications[]"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="Value (e.g., 230 kV)">
                            </div>
                        </div>
                        <button type="button" onclick="addSpecification()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Specification
                        </button>
                    </div>

                    <!-- Features -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Features</h3>
                        <div id="features-container">
                            <div class="feature-item mb-3">
                                <input type="text" name="features[]"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., High efficiency design">
                            </div>
                        </div>
                        <button type="button" onclick="addFeature()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Feature
                        </button>
                    </div>

                    <!-- Applications -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Typical Applications</h3>
                        <div id="applications-container">
                            <div class="application-item mb-3">
                                <input type="text" name="applications[]"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g., Power distribution networks">
                            </div>
                        </div>
                        <button type="button" onclick="addApplication()" class="px-4 py-2 bg-brand-100 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 rounded-xl text-sm font-semibold hover:bg-brand-200 dark:hover:bg-brand-500/20 transition-all">
                            + Add Application
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Product Image -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Image</h3>
                        <div class="relative group">
                            <div class="w-full aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400 group-hover:border-brand-500 transition-all overflow-hidden relative">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-xs font-semibold">Upload Main Image</span>
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Gallery</h3>
                        <div class="relative">
                            <div class="w-full aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Upload Gallery Images</span>
                                <input type="file" name="gallery[]" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Multiple files allowed</p>
                        </div>
                    </div>

                    <!-- Brochure -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Product Brochure</h3>
                        <div class="relative">
                            <div class="w-full aspect-video rounded-2xl border-2 border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center justify-center gap-2 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs font-semibold">Upload Brochure (PDF)</span>
                                <input type="file" name="brochure" accept=".pdf,.doc,.docx" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <x-input-error :messages="$errors->get('brochure')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="glass-card p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Settings</h3>
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order') ?? 0 }}" min="0"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" checked
                                class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                            <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active (visible on website)</label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Save Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot:scripts>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make functions globally available
            window.addSpecification = function() {
                const container = document.getElementById('specifications-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'specification-item grid grid-cols-2 gap-3 mb-3';
                div.innerHTML = `
                    <input type="text" name="specifications[]"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="Label (e.g., Voltage)">
                    <input type="text" name="specifications[]"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="Value (e.g., 230 kV)">
                    <button type="button" onclick="this.parentElement.remove()" class="col-span-2 text-red-500 text-xs hover:text-red-700">Remove</button>
                `;
                container.appendChild(div);
            };

            window.addFeature = function() {
                const container = document.getElementById('features-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'feature-item mb-3 flex gap-2';
                div.innerHTML = `
                    <input type="text" name="features[]"
                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="e.g., High efficiency design">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                `;
                container.appendChild(div);
            };

            window.addApplication = function() {
                const container = document.getElementById('applications-container');
                if (!container) return;

                const div = document.createElement('div');
                div.className = 'application-item mb-3 flex gap-2';
                div.innerHTML = `
                    <input type="text" name="applications[]"
                        class="flex-1 px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                        placeholder="e.g., Power distribution networks">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 text-sm hover:text-red-700 px-2">×</button>
                `;
                container.appendChild(div);
            };
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>
