<x-layouts.app title="Edit Job Listing">

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.careers.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Edit Job</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Update job details for "{{ $job->title ?? 'Untitled Position' }}"</p>
            </div>
        </div>

        <form action="{{ route('admin.careers.update', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            <!-- Include posted_date to preserve existing value -->
            <input type="hidden" name="posted_date" value="{{ old('posted_date', $job->posted_date ?? 'Recently posted') }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-card p-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Basic Information</h3>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $job->is_active ? 'bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400' }}">
                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-100 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    {{ $job->type ?? 'Full-time' }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Job Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" required
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Senior Electrical Engineer">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Department</label>
                                <input type="text" name="department" id="department" value="{{ old('department', $job->department) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. Engineering">
                                @error('department')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}"
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
                                    <option value="Full-time" {{ old('type', $job->type) === 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('type', $job->type) === 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('type', $job->type) === 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ old('type', $job->type) === 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Experience Required</label>
                                <input type="text" name="experience" id="experience" value="{{ old('experience', $job->experience) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"
                                    placeholder="e.g. 5+ years">
                                @error('experience')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="salary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Salary Range</label>
                                <input type="text" name="salary" id="salary" value="{{ old('salary', $job->salary) }}"
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
                                placeholder="Provide a brief description of the job...">{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Requirements List -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Requirements</label>
                            <div id="requirements-container" class="space-y-2">
                                <!-- Dynamic requirement items will be added here via JS -->
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
                                <!-- Dynamic responsibility items will be added here via JS -->
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
                                <!-- Dynamic benefit items will be added here via JS -->
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
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $job->expiry_date) }}"
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                            <p class="mt-1.5 text-xs text-gray-500">When should this job listing expire?</p>
                            @error('expiry_date')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $job->order ?? 0) }}" min="0"
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
                                <input type="checkbox" name="is_active" value="1" {{ $job->is_active ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-gray-300 dark:border-white/10 text-brand-500 focus:ring-brand-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Make this job active</span>
                            </label>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit mb-4">Job Metadata</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Created</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($job->created_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Updated</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($job->updated_at)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="glass-card p-6 space-y-3">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Job</span>
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

        <!-- Danger Zone - Separate form outside main form -->
        <div class="glass-card p-6 bg-red-50 dark:bg-red-500/10 border-0 mt-8">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400 font-outfit mb-2">Danger Zone</h3>
            <p class="text-sm text-red-700 dark:text-red-300 mb-4">Once you delete a job, there is no going back.</p>
            <form action="{{ route('admin.careers.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold transition-all hover:-translate-y-1 active:translate-y-0">
                    Delete This Job
                </button>
            </form>
        </div>
    </div>

    <x-slot:scripts>
        <script>
        // Debug form submission - specifically target the UPDATE form
        document.addEventListener('DOMContentLoaded', function() {
            // Target the first POST form (which is the update form)
            const updateForm = document.querySelector('form[action*="careers"][method="POST"]');
            if (updateForm) {
                console.log('✓ Update form found:', updateForm.action);
                console.log('✓ Update form method:', updateForm.method);

                updateForm.addEventListener('submit', function(e) {
                    console.log('=== FORM SUBMISSION STARTED ===');
                    console.log('✓ Form action:', updateForm.action);
                    console.log('✓ Form method:', updateForm.method);

                    // Collect form data
                    const formData = new FormData(updateForm);
                    console.log('✓ Form data:');
                    for (let [key, value] of formData.entries()) {
                        console.log('  -', key, ':', value);
                    }

                    // Check if form has valid action
                    if (!updateForm.action || updateForm.action === '') {
                        console.error('✗ Form action is empty!');
                        e.preventDefault();
                        alert('Form action is missing. Please check the form setup.');
                        return false;
                    }

                    // Check for required fields
                    const requiredFields = updateForm.querySelectorAll('[required]');
                    console.log('✓ Required fields:', requiredFields.length);
                    requiredFields.forEach(field => {
                        if (!field.value) {
                            console.warn('✗ Missing required field:', field.name);
                        }
                    });

                    console.log('=== FORM SUBMISSION COMPLETE ===');
                });
            } else {
                console.error('✗ Update form not found!');
            }

            // Also find the delete form for separate debugging
            const deleteForm = document.querySelector('form[action*="destroy"]');
            if (deleteForm) {
                console.log('✓ Delete form found:', deleteForm.action);
            }
        });

        // Decode JSON data safely
        function safeJsonParse(json, fallback) {
            try {
                if (json && (typeof json === 'string' || Array.isArray(json))) {
                    return Array.isArray(json) ? json : JSON.parse(json);
                }
                return fallback || [];
            } catch (e) {
                console.error('JSON parse error:', e);
                return fallback || [];
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Loading job data for ID: {{ $job->id }}');

            // Populate existing requirements
            const requirements = safeJsonParse(@json($job->requirements ?? []), []);
            console.log('Requirements:', requirements);
            if (requirements.length > 0) {
                requirements.forEach(req => addRequirementItem(req));
            } else {
                addRequirementItem();
            }

            // Populate existing responsibilities
            const responsibilities = safeJsonParse(@json($job->responsibilities ?? []), []);
            console.log('Responsibilities:', responsibilities);
            if (responsibilities.length > 0) {
                responsibilities.forEach(resp => addResponsibilityItem(resp));
            } else {
                addResponsibilityItem();
            }

            // Populate existing benefits
            const benefits = safeJsonParse(@json($job->benefits ?? []), []);
            console.log('Benefits:', benefits);
            if (benefits.length > 0) {
                benefits.forEach(ben => addBenefitItem(ben));
            } else {
                addBenefitItem();
            }

            console.log('Job data loaded successfully');
        });

        function addRequirementItem(value = '') {
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