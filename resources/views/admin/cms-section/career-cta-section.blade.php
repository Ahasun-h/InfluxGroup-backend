<x-layouts.app title="Career CTA Management">

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Career CTA Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your Career Call-to-Action section from here</p>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                          About Page
                    </span>
                </div>
            </div>

            <!-- CTA Preview -->
            <section class="relative rounded-xl border border-gray-200 dark:border-surface-600 overflow-hidden">

                <!-- Background Gradient -->
                <div class="bg-industrial-blue p-8 md:p-12 text-center">
                    <div class="max-w-4xl mx-auto">
                        <!-- Title -->
                        <h2 class="text-2xl md:text-4xl font-black uppercase italic mb-4 text-white editable-title"
                            data-field="title">
                            {!! $content['title'] ?? 'Join Our <span class="text-yellow-400">Mission</span>' !!}
                        </h2>

                        <!-- Description -->
                        <p class="text-base md:text-lg mb-8 text-industrial-100 editable-description"
                           data-field="description">
                            {{ $content['description'] ?? 'Be part of Bangladesh\'s engineering excellence story' }}
                            <button onclick="editField('description')"
                                class="ml-2 p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </button>
                        </p>

                        <!-- CTA Button -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <!-- Career CTA Button -->
                            <div class="relative group inline-flex">
                                <a href="#"
                                   class="inline-flex items-center justify-center gap-3 bg-white text-industrial-blue px-8 py-4 rounded-lg font-black uppercase tracking-wider text-xs hover:bg-industrial-dark hover:text-white transition-all"
                                   data-field="button_link">
                                    <span class="editable-button-text"
                                         data-field="button_text">
                                        {{ $content['button_text'] ?? 'Career Opportunities' }}
                                        <button onclick="editField('button_text')"
                                            class="ml-2 p-1 text-industrial-blue/50 hover:text-industrial-blue transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                    </span>
                                </a>
                                <!-- Button URL edit button -->
                                <button onclick="editField('button_link')"
                                    class="absolute -top-3 -right-3 w-8 h-8 bg-white/30 hover:bg-white/50 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10"
                                    title="Edit button link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Quick Links -->
        <div
            class="glass-card p-8 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.hero.index') }}"
                    class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Hero Section</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage hero section content</p>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
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

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl w-full max-w-lg mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Content</h3>
            </div>
            <div class="p-6">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label id="fieldLabel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Content
                        </label>
                        <div id="textareaContainer" class="hidden">
                            <!-- Textarea will be dynamically inserted here -->
                        </div>
                        <div id="inputContainer">
                            <!-- Input will be dynamically inserted here -->
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-surface-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-surface-700 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-brand-500 text-white hover:bg-brand-600 transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            function editField(fieldName) {
                const fieldElement = document.querySelector(`[data-field="${fieldName}"]`);
                let fieldValue = '';
                let labelText = 'Content';

                if (fieldName === 'title') {
                    // For title field, get the HTML content
                    fieldValue = fieldElement?.innerHTML?.trim() || '';
                    labelText = 'Title';
                } else if (fieldName === 'description') {
                    // For description field, get text content
                    fieldValue = fieldElement?.textContent?.trim() || '';
                    labelText = 'Description';
                } else if (fieldName === 'button_text') {
                    // For button text, get text content
                    fieldValue = fieldElement?.textContent?.trim() || '';
                    labelText = 'Button Text';
                } else if (fieldName === 'button_link') {
                    // For button link, get href attribute from the anchor tag
                    const linkElement = document.querySelector(`a[data-field="button_link"]`);
                    fieldValue = linkElement?.getAttribute('href') || '';
                    labelText = 'Button Link';
                }

                // Update form action
                const form = document.getElementById('editForm');
                form.action = '{{ route('admin.career-cta-section.update') }}';

                // Clear both containers completely
                const textareaContainer = document.getElementById('textareaContainer');
                const inputContainer = document.getElementById('inputContainer');
                textareaContainer.innerHTML = '';
                inputContainer.innerHTML = '';

                // Create appropriate input type based on field
                if (fieldName === 'title' || fieldName === 'description') {
                    // Use textarea for title and description
                    const textarea = document.createElement('textarea');
                    textarea.name = fieldName;
                    textarea.id = 'fieldValue';
                    textarea.rows = '4';
                    textarea.className = 'w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all';
                    textarea.value = fieldValue;
                    textareaContainer.classList.remove('hidden');
                    textareaContainer.appendChild(textarea);
                    inputContainer.classList.add('hidden');
                } else {
                    // Use text input for other fields
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = fieldName;
                    input.id = 'fieldValue';
                    input.className = 'w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all';
                    input.value = fieldValue;
                    inputContainer.classList.remove('hidden');
                    inputContainer.appendChild(input);
                    textareaContainer.classList.add('hidden');
                }

                // Update label
                document.getElementById('fieldLabel').textContent = labelText;

                // Show modal
                document.getElementById('editModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            // Close modal on outside click
            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        </script>
    </x-slot:scripts>
</x-layouts.app>
