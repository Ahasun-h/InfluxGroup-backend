<x-layouts.app title="Journey Section Management">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Journey Section Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your company timeline from here</p>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
            </div>

            <!-- Journey Timeline Preview -->
            <section class="py-20 md:py-32 bg-industrial-light rounded-xl border border-gray-200 dark:border-surface-600">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-industrial-dark editable-title" data-field="title">
                            {{ $journeyItems['journey_section_title']->section_content ?? 'Our Journey' }}
                            <button onclick="editField('title')" class="ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </h2>
                        <p class="text-slate-600 text-lg max-w-2xl mx-auto editable-description" data-field="description">
                            {{ $journeyItems['journey_section_description']->section_content ?? 'Four decades of excellence in powering Bangladesh\'s development' }}
                            <button onclick="editField('description')" class="ml-2 p-1 text-brand-500 hover:text-brand-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </p>
                    </div>

                    <div class="relative">
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-industrial-blue/20 hidden md:block"></div>
                        <div class="space-y-12 md:space-y-16">
                            @foreach($timelineItems as $item)
                            <div class="relative flex items-center {{ $loop->index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                                <div class="w-full md:w-5/12 {{ $loop->index % 2 === 0 ? 'md:pr-12' : 'md:pl-12' }}">
                                    <div class="bg-white p-6 md:p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow relative group">
                                        <button onclick="editTimeline({{ $item['order'] }})" class="absolute top-2 right-2 z-20 w-6 h-6 bg-white/50 hover:bg-white rounded-full flex items-center justify-center text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <div class="text-industrial-blue font-black text-xl md:text-2xl mb-2 editable-timeline{{ $item['order'] }}-year" data-field="timeline{{ $item['order'] }}_year">
                                            {{ $item['year'] }}
                                        </div>
                                        <h3 class="text-lg md:text-xl font-bold mb-3 text-industrial-dark editable-timeline{{ $item['order'] }}-title" data-field="timeline{{ $item['order'] }}_title">
                                            {{ $item['title'] }}
                                        </h3>
                                        <p class="text-slate-600 text-sm md:text-base editable-timeline{{ $item['order'] }}-description" data-field="timeline{{ $item['order'] }}_description">
                                            {{ $item['description'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-industrial-blue rounded-full border-4 border-white shadow-lg"></div>
                                <div class="w-0 md:w-5/12"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Quick Links -->
        <div class="glass-card p-8 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Homepage Content</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage other homepage sections</p>
                    </div>
                </a>

                <a href="{{ route('admin.hero.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Hero Section</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage hero section content</p>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Dashboard</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Back to main dashboard</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Hidden form for field updates -->
    <form id="journey-form" action="{{ route('admin.journey.update') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="title" value="{{ $journeyItems['journey_section_title']->section_content ?? '' }}">
        <input type="hidden" name="description" value="{{ $journeyItems['journey_section_description']->section_content ?? '' }}">

        @foreach($timelineItems as $item)
            <input type="hidden" name="timeline{{ $item['order'] }}_year" value="{{ $item['year'] }}">
            <input type="hidden" name="timeline{{ $item['order'] }}_title" value="{{ $item['title'] }}">
            <input type="hidden" name="timeline{{ $item['order'] }}_description" value="{{ $item['description'] }}">
        @endforeach
    </form>

    <!-- Single Field Edit Modal -->
    <div id="field-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="field-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Field</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-field-name">
                <div>
                    <label id="field-label" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Field Value</label>
                    <textarea id="field-input" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeFieldModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveField()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Edit Modal -->
    <div id="timeline-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="timeline-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Timeline Item</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-timeline">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Year</label>
                    <input type="text" id="timeline-year" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" id="timeline-title" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea id="timeline-description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeTimelineModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveTimeline()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Timeline</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Field editing functions
        function editField(fieldName) {
            const modal = document.getElementById('field-modal');
            const input = document.getElementById('field-input');
            const title = document.getElementById('field-modal-title');
            const label = document.getElementById('field-label');
            const fieldNameInput = document.getElementById('current-field-name');

            fieldNameInput.value = fieldName;

            const titles = {
                'title': 'Edit Title',
                'description': 'Edit Description'
            };

            const labels = {
                'title': 'Title',
                'description': 'Description'
            };

            title.textContent = titles[fieldName] || 'Edit Field';
            label.textContent = labels[fieldName] || 'Field Value';

            // Get current value from the page
            const element = document.querySelector(`[data-field="${fieldName}"]`);
            if (element) {
                input.value = element.textContent.trim();
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeFieldModal() {
            const modal = document.getElementById('field-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveField() {
            const fieldName = document.getElementById('current-field-name').value;
            const value = document.getElementById('field-input').value;

            // Update the preview
            const element = document.querySelector(`[data-field="${fieldName}"]`);
            if (element) {
                element.textContent = value;
            }

            // Update the form value
            const formInput = document.querySelector(`#journey-form [name="${fieldName}"]`);
            if (formInput) {
                formInput.value = value;
            }

            closeFieldModal();

            // Auto-submit the form
            document.getElementById('journey-form').submit();
        }

        // Timeline editing functions
        function editTimeline(timelineId) {
            const modal = document.getElementById('timeline-modal');
            const yearInput = document.getElementById('timeline-year');
            const titleInput = document.getElementById('timeline-title');
            const descriptionInput = document.getElementById('timeline-description');
            const timelineInput = document.getElementById('current-timeline');
            const modalTitle = document.getElementById('timeline-modal-title');

            timelineInput.value = timelineId;
            modalTitle.textContent = 'Edit Timeline ' + timelineId;

            // Get current values
            yearInput.value = document.querySelector(`[data-field="timeline${timelineId}_year"]`)?.textContent || '';
            titleInput.value = document.querySelector(`[data-field="timeline${timelineId}_title"]`)?.textContent || '';
            descriptionInput.value = document.querySelector(`[data-field="timeline${timelineId}_description"]`)?.textContent || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTimelineModal() {
            const modal = document.getElementById('timeline-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveTimeline() {
            const timelineId = document.getElementById('current-timeline').value;
            const year = document.getElementById('timeline-year').value;
            const title = document.getElementById('timeline-title').value;
            const description = document.getElementById('timeline-description').value;

            // Update the preview
            const yearElement = document.querySelector(`[data-field="timeline${timelineId}_year"]`);
            const titleElement = document.querySelector(`[data-field="timeline${timelineId}_title"]`);
            const descriptionElement = document.querySelector(`[data-field="timeline${timelineId}_description"]`);

            if (yearElement) yearElement.textContent = year;
            if (titleElement) titleElement.textContent = title;
            if (descriptionElement) descriptionElement.textContent = description;

            // Update the form values
            const yearInput = document.querySelector(`input[name="timeline${timelineId}_year"]`);
            const titleInput = document.querySelector(`input[name="timeline${timelineId}_title"]`);
            const descriptionInput = document.querySelector(`input[name="timeline${timelineId}_description"]`);

            if (yearInput) yearInput.value = year;
            if (titleInput) titleInput.value = title;
            if (descriptionInput) descriptionInput.value = description;

            closeTimelineModal();

            // Auto-submit the form
            document.getElementById('journey-form').submit();
        }

        // Close modals on outside click
        document.addEventListener('DOMContentLoaded', function() {
            const fieldModal = document.getElementById('field-modal');
            if (fieldModal) {
                fieldModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeFieldModal();
                    }
                });
            }

            const timelineModal = document.getElementById('timeline-modal');
            if (timelineModal) {
                timelineModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeTimelineModal();
                    }
                });
            }
        });

        // Show success message if any
        @if(session('success'))
            setTimeout(() => {
                alert('{{ session('success') }}');
            }, 100);
        @endif
    </script>
</x-layouts.app>