<x-layouts.app title="Partners Section Management">

    <x-slot:styles>
        <style>
            @keyframes fade-in-down {
                0% {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes dropify-loader-anim {
                0%, 100% { opacity: 0; transform: translate(-50%, -50%) scale(0.5); }
                50% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            }

            .animate-fade-in-down {
                animation: fade-in-down 0.3s ease-out;
            }

            input:focus,
            textarea:focus {
                outline: none;
            }

            /* Image preview styles */
            .hidden {
                display: none !important;
            }

            #image-preview .preview-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                min-height: 80px;
            }

            /* Emoji preview styles */
            .emoji-display {
                font-size: 3rem;
                line-height: 1;
            }

            /* Image preview container styles */
            #image-preview {
                min-height: 80px;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                transition: all 0.3s ease;
            }

            #image-preview:hover {
                background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            }

            button,
            input,
            textarea {
                transition: all 0.2s ease;
            }

            .partner-card {
                transition: all 0.3s ease;
            }

            .partner-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
            }

            .delete-button {
                z-index: 10;
            }

            /* Dropify custom styles */
            .dropify-wrapper {
                border: 2px dashed #cbd5e1;
                border-radius: 8px;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                transition: all 0.3s ease;
                min-height: 120px;
            }

            .dropify-wrapper:hover {
                border-color: #3b82f6;
                background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            }

            .dropify-message p {
                font-size: 12px;
                color: #64748b;
                font-weight: 500;
            }

            .dropify-icon {
                color: #3b82f6;
            }

            .dropify-preview {
                position: relative;
                overflow: hidden;
                background: #f8fafc;
                border-radius: 6px;
            }

            .dropify-render {
                position: relative;
                height: 100%;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dropify-render img {
                max-width: 100%;
                max-height: 200px;
                object-fit: contain;
            }

            .dropify-infos {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                padding: 8px 12px;
                color: white;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .dropify-wrapper:hover .dropify-infos {
                opacity: 1;
            }

            .dropify-infos-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .dropify-infos-message {
                font-size: 12px;
                color: rgba(255, 255, 255, 0.9);
            }

            .dropify-clear {
                background: rgba(239, 68, 68, 0.9);
                color: white;
                border: none;
                border-radius: 4px;
                padding: 4px 12px;
                font-size: 11px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .dropify-clear:hover {
                background: rgba(220, 38, 38, 1);
                transform: scale(1.05);
            }

            .dropify-loader {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                z-index: 10;
            }

            .dropify-loader span {
                display: block;
                position: absolute;
                top: 50%;
                left: 50%;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: #3b82f6;
                animation: dropify-loader-anim 1s ease-in-out infinite;
            }

            .dropify-loader span:nth-child(1) { animation-delay: -0.6s; }
            .dropify-loader span:nth-child(2) { animation-delay: -0.4s; }
            .dropify-loader span:nth-child(3) { animation-delay: -0.2s; }
            .dropify-loader span:nth-child(4) { animation-delay: 0s; }

            /* Dark mode support */
            .dark .dropify-wrapper {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                border-color: #475569;
            }

            .dark .dropify-wrapper:hover {
                background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);
                border-color: #3b82f6;
            }

            .dark .dropify-message p {
                color: #94a3b8;
            }

            /* Ensure partner labels are always visible */
            .partner-card label {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                color: #111827 !important; /* Always dark in light mode */
                font-weight: 700 !important;
                font-size: 11px !important;
                letter-spacing: 1.5px !important;
                text-transform: uppercase !important;
                margin-bottom: 12px !important;
            }

            .dark .partner-card label {
                color: #f9fafb !important; /* Always light in dark mode */
            }
        </style>
    </x-slot:styles>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Partners Section Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website partners section from here</p>
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
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          Home Page
                    </span>
                </div>
            </div>

            <form action="{{ route('admin.partners.update') }}" method="POST" id="partners-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section Header Editor -->
                <div class="bg-white dark:bg-surface-800 border border-gray-200 dark:border-surface-600 rounded-lg p-8 md:p-12 mb-8">
                    <div class="text-center mb-8">
                        <input type="text" name="title" value="{{ $content['title'] }}"
                               class="w-full text-3xl md:text-4xl font-display font-black uppercase italic text-gray-900 dark:text-white text-center bg-transparent focus:border-brand-500 focus:ring-0 p-4 placeholder:text-gray-600 dark:placeholder:text-gray-400 transition-colors"
                               placeholder="Trusted by Industry Leaders">

                        <textarea name="subtitle" rows="2"
                                  class="w-full text-gray-600 dark:text-gray-300 text-lg text-center bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-gray-600 dark:placeholder:text-gray-400"
                                  placeholder="Proud partner to government agencies, multinational corporations, and leading enterprises">{{ $content['subtitle'] }}</textarea>

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6" id="partners-container">
                            @foreach($partners as $partner)
                                <div
                                    class="bg-white dark:bg-surface-800 p-6 md:p-8 rounded-lg flex flex-col items-center justify-center shadow-lg hover:shadow-xl transition-all group partner-card relative"
                                    data-partner-id="{{ $partner['id'] }}">
                                    <!-- Delete Button -->
                                    <button type="button"
                                            class="absolute top-2 right-2 w-6 h-6 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"
                                            data-id="{{ $partner['id'] }}" title="Delete this partner">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="delete_partner_{{ $partner['id'] }}"
                                           id="delete_partner_{{ $partner['id'] }}" value="">

                                    <!-- Logo Section -->
                                    <div class="mb-4 w-full">
                                        <label class="block text-xs uppercase font-bold tracking-wider text-gray-900 dark:text-white mb-2">Partner Logo</label>

                                        <!-- Logo Preview Area -->
                                        <div class="relative">
                                            @if(!empty($partner['logo']) && (str_starts_with($partner['logo'], 'http') || str_starts_with($partner['logo'], '/') || str_starts_with($partner['logo'], 'data:image')))
                                                <!-- Existing Image Preview -->
                                                <div class="relative group">
                                                    <img src="{{ $partner['logo'] }}" alt="Partner Logo" class="w-full h-24 object-contain bg-gray-50 dark:bg-surface-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-surface-600 p-2">
                                                    <div class="absolute inset-0 bg-black dark:bg-white bg-opacity-50 dark:bg-opacity-50 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <label class="cursor-pointer px-4 py-2 bg-white dark:bg-surface-800 text-gray-800 dark:text-white rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors">
                                                            Change Logo
                                                            <input type="file" name="partner_logo_{{ $partner['id'] }}" class="hidden" accept="image/*" onchange="handlePartnerImageUpload({{ $partner['id'] }}, this)">
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Upload Area -->
                                                <div class="border-2 border-dashed border-gray-300 dark:border-surface-600 rounded-lg p-4 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors bg-gray-50 dark:bg-surface-700">
                                                    <label class="cursor-pointer">
                                                        <div class="text-gray-500 dark:text-gray-400 mb-2">
                                                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Click to upload or drag and drop</p>
                                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                                                        </div>
                                                        <input type="file" name="partner_logo_{{ $partner['id'] }}" class="hidden" accept="image/*" onchange="handlePartnerImageUpload({{ $partner['id'] }}, this)">
                                                    </label>
                                                </div>
                                            @endif
                                        </div>

                                        <input type="hidden" name="partners[{{ $partner['id'] }}][logo]" id="partner_logo_url_{{ $partner['id'] }}" value="{{ $partner['logo'] }}">
                                    </div>

                                    <!-- Name Input -->
                                    <div class="w-full">
                                        <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 dark:text-gray-400 mb-2">Partner Name</label>
                                        <input type="text" name="partners[{{ $partner['id'] }}][name]"
                                               value="{{ $partner['name'] }}"
                                               class="w-full text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white text-center bg-transparent focus:border-brand-500 focus:ring-0 p-2 placeholder:text-gray-600 dark:placeholder:text-gray-400 transition-colors"
                                               placeholder="Partner Name">
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Partner Button -->
                            <button type="button" onclick="window.addPartner()"
                                    class="border-2 border-dashed border-gray-300 dark:border-surface-600 rounded-lg flex flex-col items-center justify-center p-8 hover:border-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10 transition-all group min-h-[250px] partner-card bg-white dark:bg-surface-800">
                                <div
                                    class="w-12 h-12 rounded-full bg-white dark:bg-surface-700 text-gray-400 dark:text-gray-500 flex items-center justify-center group-hover:bg-brand-500 group-hover:text-white transition-all mb-4 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 group-hover:text-brand-500 transition-colors">
                                    Add New Partner
                                </span>
                                <span class="text-xs text-gray-400 dark:text-gray-500 mt-2 group-hover:text-gray-500 dark:group-hover:text-gray-400 transition-colors">
                                    Click to add a new partner
                                </span>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="flex items-center justify-between bg-white dark:bg-surface-800 border border-gray-200 dark:border-surface-600 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400 text-sm">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>All changes are saved instantly and reflected on the frontend</span>
                    </div>

                    <button type="submit"
                            class="group inline-flex items-center gap-3 px-8 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>

    <x-slot:scripts>
        <script>
            (function() {
                console.log('Partners page loaded');

                let nextId = {{ count($partners) + 1 }};

                // Add new partner
                function addPartner() {
                    try {
                        const container = document.getElementById('partners-container');
                        const addButton = container.lastElementChild;

                        console.log('Adding new partner with ID:', nextId);

                        if (!container) {
                            console.error('Partners container not found!');
                            return;
                        }

                        if (!addButton) {
                            console.error('Add button not found!');
                            return;
                        }

                        const div = document.createElement('div');
                        div.className = 'bg-white p-6 md:p-8 rounded-lg flex flex-col items-center justify-center shadow-lg hover:shadow-xl transition-all group partner-card relative animate-fade-in-down';
                        div.setAttribute('data-partner-id', nextId);

                        const partnerId = nextId;
                        div.innerHTML = `
                            <!-- Delete Button -->
                            <button type="button"
                                class="absolute top-2 right-2 w-6 h-6 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"
                                data-id="${partnerId}"
                                title="Delete this partner">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <input type="hidden" name="delete_partner_${partnerId}" id="delete_partner_${partnerId}" value="">

                            <!-- Logo Section -->
                            <div class="mb-4 w-full">
                                <label class="block text-xs uppercase font-bold tracking-wider text-gray-900 dark:text-white mb-2">Partner Logo</label>

                                <!-- Upload Area -->
                                <div class="border-2 border-dashed border-gray-300 dark:border-surface-600 rounded-lg p-4 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors bg-gray-50 dark:bg-surface-700">
                                    <label class="cursor-pointer">
                                        <div class="text-gray-500 dark:text-gray-400 mb-2">
                                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Click to upload or drag and drop</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                                        </div>
                                        <input type="file" name="partner_logo_${partnerId}" class="hidden" accept="image/*" onchange="handlePartnerImageUpload(${partnerId}, this)">
                                    </label>
                                </div>

                                <input type="hidden" name="partners[${partnerId}][logo]" id="partner_logo_url_${partnerId}" value="">
                            </div>

                            <!-- Name Input -->
                            <div class="w-full">
                                <label class="block text-[10px] uppercase font-bold tracking-wider text-gray-500 dark:text-gray-400 mb-2">Partner Name</label>
                                <input type="text"
                                    name="partners[${partnerId}][name]"
                                    class="w-full text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white text-center bg-transparent focus:border-brand-500 focus:ring-0 p-2 placeholder:text-gray-600 dark:placeholder:text-gray-400 transition-colors"
                                    placeholder="Partner Name">
                            </div>
                        `;

                        container.insertBefore(div, addButton);

                        console.log('New partner card added:', partnerId);

                        // Initialize Dropify for the new file input
                        const newDropify = div.querySelector('.dropify');
                        if (newDropify) {
                            setTimeout(function() {
                                if (typeof $ !== 'undefined' && typeof $.fn.dropify === 'function') {
                                    $(newDropify).dropify({
                                        messages: {
                                            'default': 'Drag & drop an image here or click',
                                            'replace': 'Drag & drop or click to replace',
                                            'remove': 'Remove',
                                            'error': 'Sorry, the file is too large'
                                        },
                                        tpl: {
                                            wrap: '<div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon" />@{{ message }}@<p class="dropify-error" /></div></div>',
                                            message: '<div class="dropify-message"><svg class="dropify-icon" width="40" height="40" viewBox="0 0 40 40" fill="currentColor"><path d="M20 4a16 16 0 1 1 16 16 16 16 0 0 1-16 16zm0 2a14 14 0 1 0 14 14 14 14 0 0 0-14-14zm7 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-9 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg><p>@{{ message }}@</p></div>',
                                            preview: '<div class="dropify-preview"><div class="dropify-render"></div><div class="dropify-infos"><div class="dropify-infos-inner"><span class="dropify-infos-message">@{{ message }}@</span><button type="button" class="dropify-clear">Remove</button></div></div></div>',
                                            loader: '<div class="dropify-loader"><span></span><span></span><span></span><span></span></div>'
                                        }
                                    });

                                    // Add event listeners for the new Dropify instance
                                    $(newDropify).on('dropify.fileReady', function(event, element) {
                                        const wrapper = $(element).closest('.dropify-wrapper');
                                        const fileInput = wrapper.find('input[type="file"]');
                                        const id = fileInput[0].id.replace('partner_logo_', '');
                                        const urlInput = document.getElementById(`partner_logo_url_${id}`);

                                        if (fileInput.length > 0 && fileInput[0].files.length > 0) {
                                            const file = fileInput[0].files[0];
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                const base64Url = e.target.result;
                                                if (urlInput) {
                                                    urlInput.value = base64Url;
                                                }
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    });

                                    console.log('✓ New Dropify initialized');
                                }
                            }, 100);
                        }

                        // Add delete button functionality
                        const deleteButton = div.querySelector('.delete-button');
                        if (deleteButton) {
                            deleteButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const id = this.getAttribute('data-id');
                                const form = document.getElementById('partners-form');
                                if (confirm('Delete this partner?')) {
                                    const deleteInput = document.getElementById(`delete_partner_${id}`);
                                    if (deleteInput && form) {
                                        deleteInput.value = id;
                                        form.submit();
                                    }
                                }
                            });
                        }

                        // Focus on the name input field
                        setTimeout(() => {
                            const nameInput = div.querySelector('input[type="text"]');
                            if (nameInput) {
                                nameInput.focus();
                            }
                        }, 100);

                        nextId++;
                    } catch (error) {
                        console.error('Error adding new partner:', error);
                        alert('There was an error adding a new partner. Please check the console for details.');
                    }
                }

                function handlePartnerImageUpload(id, input) {
                    if (!input.files || !input.files[0]) {
                        return;
                    }

                    const file = input.files[0];
                    const maxSize = 5 * 1024 * 1024; // 5MB

                    if (file.size > maxSize) {
                        alert('File size is too large. Maximum size is 5MB.');
                        input.value = '';
                        return;
                    }

                    // Convert to base64
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const base64Url = e.target.result;
                        const urlInput = document.getElementById(`partner_logo_url_${id}`);
                        if (urlInput) {
                            urlInput.value = base64Url;

                            // Update the preview area
                            const partnerCard = document.querySelector(`.partner-card[data-partner-id="${id}"]`);
                            if (partnerCard) {
                                const logoSection = partnerCard.querySelector('.mb-4.w-full');
                                if (logoSection) {
                                    const logoContainer = logoSection.querySelector('.relative');
                                    if (logoContainer) {
                                        logoContainer.innerHTML = `
                                            <div class="relative group">
                                                <img src="${base64Url}" alt="Partner Logo" class="w-full h-24 object-contain bg-gray-50 dark:bg-surface-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-surface-600 p-2">
                                                <div class="absolute inset-0 bg-black dark:bg-white bg-opacity-50 dark:bg-opacity-50 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <label class="cursor-pointer px-4 py-2 bg-white dark:bg-surface-800 text-gray-800 dark:text-white rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-surface-700 transition-colors">
                                                        Change Logo
                                                        <input type="file" name="partner_logo_${id}" class="hidden" accept="image/*" onchange="handlePartnerImageUpload(${id}, this)">
                                                    </label>
                                                </div>
                                            </div>
                                        `;
                                    }
                                }
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                };

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOM Loaded - Partners page ready');
                });

                // Expose functions to window
                window.addPartner = addPartner;
                window.handlePartnerImageUpload = handlePartnerImageUpload;

                // Add delete button functionality for existing partners
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('partners-form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            console.log('Partners form submitting...');
                        });
                    }

                    // Add delete button functionality for existing partners
                    const deleteButtons = document.querySelectorAll('.delete-button');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const id = this.getAttribute('data-id');
                            if (confirm('Delete this partner?')) {
                                const deleteInput = document.getElementById(`delete_partner_${id}`);
                                if (deleteInput && form) {
                                    deleteInput.value = id;
                                    form.submit();
                                }
                            }
                        });
                    });
                });

                console.log('✓ Partners page initialized');
            })();
        </script>
    </x-slot:scripts>

</x-layouts.app>