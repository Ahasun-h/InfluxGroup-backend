<x-layouts.app title="Create Job Listing">

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.careers.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Create New Job</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add a new career opportunity to your listings.</p>
            </div>
        </div>

        <form action="{{ route('admin.careers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Include posted_date with default value -->
            <input type="hidden" name="posted_date" value="{{ old('posted_date', 'Recently posted') }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Basic Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Senior Electrical Engineer">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Department</label>
                                <input type="text" name="department" id="department" value="{{ old('department') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Engineering">
                                @error('department')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Dhaka">
                                @error('location')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Type</label>
                                <select name="type" id="type" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                    <option value="Full-time" {{ old('type') === 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('type') === 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('type') === 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ old('type') === 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Experience Required</label>
                                <input type="text" name="experience" id="experience" value="{{ old('experience') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. 5+ years">
                                @error('experience')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="salary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Salary Range</label>
                                <input type="text" name="salary" id="salary" value="{{ old('salary', 'Competitive') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Competitive">
                                @error('salary')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Job Details</h3>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400 resize-none"
                                placeholder="Provide a brief description of the job...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Requirements List -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Requirements</label>
                            <div id="requirements-container" class="space-y-2">
                                <!-- Dynamic requirement items will be added here -->
                            </div>
                            <button type="button" onclick="addRequirementItem()" class="mt-3 inline-flex items-center gap-2 text-sm text-brand-500 hover:text-brand-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Requirement
                            </button>
                            @error('requirements')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Responsibilities List -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Responsibilities</label>
                            <div id="responsibilities-container" class="space-y-2">
                                <!-- Dynamic responsibility items will be added here -->
                            </div>
                            <button type="button" onclick="addResponsibilityItem()" class="mt-3 inline-flex items-center gap-2 text-sm text-brand-500 hover:text-brand-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Responsibility
                            </button>
                            @error('responsibilities')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Benefits List -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Benefits & Perks</label>
                            <div id="benefits-container" class="space-y-2">
                                <!-- Dynamic benefit items will be added here -->
                            </div>
                            <button type="button" onclick="addBenefitItem()" class="mt-3 inline-flex items-center gap-2 text-sm text-brand-500 hover:text-brand-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Benefit
                            </button>
                            @error('benefits')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Job Settings -->
                    <div class="glass-card p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Job Settings</h3>

                        <div>
                            <label for="expiry_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                            <p class="mt-1.5 text-xs text-gray-500">When should this job listing expire?</p>
                            @error('expiry_date')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                placeholder="0">
                            <p class="mt-1.5 text-xs text-gray-500">Lower numbers appear first</p>
                            @error('order')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="w-5 h-5 rounded border-gray-300 dark:border-white/10 text-brand-500 focus:ring-brand-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Make this job active</span>
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 space-y-3">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Create Job</span>
                        </button>
                        <a href="{{ route('admin.careers.index') }}"
                            class="w-full px-6 py-3 bg-gray-100 dark:bg-surface-800 hover:bg-gray-200 dark:hover:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot:scripts>
        <script>
        let requirementCount = 0;
        let responsibilityCount = 0;
        let benefitCount = 0;

        // Initialize with one empty item for each list
        document.addEventListener('DOMContentLoaded', function() {
            addRequirementItem();
            addResponsibilityItem();
            addBenefitItem();
        });

        function addRequirementItem(value = '') {
            requirementCount++;
            const container = document.getElementById('requirements-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'requirements[]';
            input.value = value;
            input.className = 'flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400';
            input.placeholder = 'Enter requirement...';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all';
            removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            removeBtn.onclick = function() { div.remove(); };

            div.appendChild(input);
            div.appendChild(removeBtn);
            container.appendChild(div);
        }

        function addResponsibilityItem(value = '') {
            responsibilityCount++;
            const container = document.getElementById('responsibilities-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'responsibilities[]';
            input.value = value;
            input.className = 'flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400';
            input.placeholder = 'Enter responsibility...';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all';
            removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            removeBtn.onclick = function() { div.remove(); };

            div.appendChild(input);
            div.appendChild(removeBtn);
            container.appendChild(div);
        }

        function addBenefitItem(value = '') {
            benefitCount++;
            const container = document.getElementById('benefits-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'benefits[]';
            input.value = value;
            input.className = 'flex-1 px-4 py-2 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400';
            input.placeholder = 'Enter benefit...';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'p-2 rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all';
            removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            removeBtn.onclick = function() { div.remove(); };

            div.appendChild(input);
            div.appendChild(removeBtn);
            container.appendChild(div);
        }
        </script>
    </x-slot:scripts>

</x-layouts.app>