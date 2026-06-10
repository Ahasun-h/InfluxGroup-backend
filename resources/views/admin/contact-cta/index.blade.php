<x-layouts.app title="Contact CTA Management">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Contact CTA Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your Call-to-Action section from here</p>
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
            </div>

            <!-- CTA Preview -->
            <section
                class="relative rounded-xl border border-gray-200 dark:border-surface-600 overflow-hidden">

                <!-- Background Gradient -->
                <div class="bg-gradient-to-r from-[#007bff] to-[#0056b3] p-8 md:p-12 text-center">
                    <div class="max-w-4xl mx-auto">
                        <!-- Title -->
                        <h2 class="text-2xl md:text-4xl font-black uppercase italic mb-4 text-white editable-title"
                            data-field="title">
                            {{ $content['title'] ?? 'Ready to Power Your Success?' }}
                            <button onclick="editField('title')"
                                class="ml-2 p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </button>
                        </h2>

                        <!-- Description -->
                        <p class="text-base md:text-lg mb-8 text-white/90 editable-description"
                            data-field="description">
                            {{ $content['description'] ?? "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions." }}
                            <button onclick="editField('description')"
                                class="ml-2 p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </button>
                        </p>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <!-- Primary CTA Button -->
                            <div class="relative group inline-flex">
                                <a href="{{ $content['button_link'] ?? '/contact' }}"
                                   class="editable-button-link"
                                   data-field="button_link">
                                    <span class="inline-flex items-center justify-center gap-3 bg-white text-[#007bff] px-8 py-4 rounded-lg font-black uppercase tracking-wider text-xs hover:bg-[#0a0e17] hover:text-white transition-all editable-button-text"
                                        data-field="button_text">
                                        {{ $content['button_text'] ?? 'Get in Touch' }}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                </a>
                                <button onclick="editCtaButton('button_text', 'button_link')"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Secondary Static Button -->
                            <a href="/contact"
                               class="inline-flex items-center justify-center gap-3 bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-black uppercase tracking-wider text-xs hover:bg-white hover:text-[#007bff] transition-all">
                                Contact Us
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13 2.257a1 1 0 01-1.21 1.502l-4.493 1.498a1 1 0 01-.684-.949V5a2 2 0 012-2zm11.336-2.046a1 1 0 010-1.79l-2.11-2.11a1 1 0 01-1.415 0l-1.414 1.415a1 1 0 010 1.414l2.11 2.111a1 1 0 011.415 0z"></path>
                                </svg>
                            </a>
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
                <a href="{{ route('admin.homepage.index') }}"
                    class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div
                        class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Homepage Content</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage other homepage sections</p>
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

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div
                        class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Settings</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Company settings</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Hidden form for field updates -->
    <form id="cta-form" action="{{ route('admin.contact-cta.update') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="title" value="{{ $content['title'] ?? 'Ready to Power Your Success?' }}">
        <input type="hidden" name="description"
            value="{{ $content['description'] ?? "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions." }}">
        <input type="hidden" name="button_text" value="{{ $content['button_text'] ?? 'Get in Touch' }}">
        <input type="hidden" name="button_link" value="{{ $content['button_link'] ?? '/contact' }}">
    </form>

    <!-- Single Field Edit Modal -->
    <div id="field-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="field-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Field</h3>
            </div>
            <form id="field-form" class="p-6 space-y-4">
                <input type="hidden" id="current-field-name">
                <div>
                    <label id="field-label" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Field
                        Value</label>
                    <textarea id="field-input" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeFieldModal()"
                        class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveField()"
                        class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CTA Button Edit Modal -->
    <div id="cta-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="cta-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Button</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-cta-text-field">
                <input type="hidden" id="current-cta-link-field">

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Button Text</label>
                    <input type="text" id="cta-button-text"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                        placeholder="Get in Touch">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Button Link</label>
                    <input type="text" id="cta-button-link"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                        placeholder="/contact">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeCtaModal()"
                        class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveCtaButton()"
                        class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save
                        Button</button>
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
                'title': 'Edit Section Title',
                'description': 'Edit Description'
            };

            const labels = {
                'title': 'Section Title',
                'description': 'Description'
            };

            title.textContent = titles[fieldName] || 'Edit Field';
            label.textContent = labels[fieldName] || 'Field Value';

            // Get current value from the page
            const element = document.querySelector(`[data-field="${fieldName}"]`);
            if (element) {
                const textElement = element.childNodes[0] || element;
                input.value = textElement.textContent || element.textContent;
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
                const textElement = element.childNodes[0] || element;
                textElement.textContent = value;
            }

            // Update the form value
            const formInput = document.querySelector(`#cta-form [name="${fieldName}"]`);
            if (formInput) {
                formInput.value = value;
            }

            closeFieldModal();

            // Auto-submit the form
            document.getElementById('cta-form').submit();
        }

        // CTA button editing functions
        function editCtaButton(textField, linkField) {
            const modal = document.getElementById('cta-modal');
            const title = document.getElementById('cta-modal-title');
            const textInput = document.getElementById('cta-button-text');
            const linkInput = document.getElementById('cta-button-link');
            const textFieldInput = document.getElementById('current-cta-text-field');
            const linkFieldInput = document.getElementById('current-cta-link-field');

            textFieldInput.value = textField;
            linkFieldInput.value = linkField;

            title.textContent = 'Edit Primary Button';

            // Get current values
            const textElement = document.querySelector(`[data-field="${textField}"]`);
            const linkElement = document.querySelector(`input[name="${linkField}"]`);

            if (textElement) {
                const textNode = textElement.childNodes[0] || textElement;
                textInput.value = textNode.textContent || textElement.textContent;
            }
            if (linkElement) {
                linkInput.value = linkElement.value;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCtaModal() {
            const modal = document.getElementById('cta-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function saveCtaButton() {
            const textField = document.getElementById('current-cta-text-field').value;
            const linkField = document.getElementById('current-cta-link-field').value;
            const buttonText = document.getElementById('cta-button-text').value;
            const buttonLink = document.getElementById('cta-button-link').value;

            // Update the preview
            const textElement = document.querySelector(`[data-field="${textField}"]`);
            if (textElement) {
                const textNode = textElement.childNodes[0] || textElement;
                textNode.textContent = buttonText;
            }

            // Update the link href
            const linkElement = document.querySelector(`[data-field="${linkField}"]`);
            if (linkElement) {
                linkElement.href = buttonLink;
            }

            // Update the form values
            document.querySelector(`input[name="${textField}"]`).value = buttonText;
            document.querySelector(`input[name="${linkField}"]`).value = buttonLink;

            closeCtaModal();

            // Auto-submit the form
            document.getElementById('cta-form').submit();
        }

        // Close modal on outside click
        document.addEventListener('DOMContentLoaded', function () {
            const fieldModal = document.getElementById('field-modal');
            if (fieldModal) {
                fieldModal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeFieldModal();
                    }
                });
            }

            const ctaModal = document.getElementById('cta-modal');
            if (ctaModal) {
                ctaModal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeCtaModal();
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