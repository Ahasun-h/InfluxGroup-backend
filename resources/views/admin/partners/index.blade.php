<x-layouts.app title="Partners & Clients Management">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css">
    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>

    <div class="min-h-screen bg-[#0a0e17] py-20 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black uppercase tracking-wider text-white mb-2">
                            Partners <span class="text-[#007bff]">&</span> Clients
                        </h1>
                        <p class="text-gray-400 text-sm">Manage your trusted partners and client relationships</p>
                    </div>
                    <div class="flex items-center gap-2 text-[#007bff] text-sm font-black uppercase tracking-widest">
                        <span class="bg-[#007bff]/10 px-3 py-1 rounded">{{ count($partners) }} Partners</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.partners.update') }}" method="POST" id="partners-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section Header Editor -->
                <div class="bg-[#121828] border border-[#1a1f2e] rounded-lg p-8 md:p-12 mb-8">
                    <div class="text-center mb-8">
                        <input type="text" name="title" value="{{ $content['title'] }}"
                            class="w-full text-4xl md:text-5xl font-black uppercase tracking-wider text-white text-center bg-transparent focus:border-[#007bff] focus:ring-0 p-4 placeholder:text-gray-600 transition-colors"
                            placeholder="TRUSTED BY INDUSTRY LEADERS">

                        <textarea name="subtitle" rows="2"
                            class="w-full text-gray-400 text-lg text-center bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-gray-600"
                            placeholder="Proud partner to government agencies, multinational corporations, and leading enterprises">{{ $content['subtitle'] }}</textarea>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="partners-container">
                            @foreach($partners as $partner)
                                <div class="bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 value-card group/card relative">
                                    <!-- Delete Button -->
                                    <button type="button"
                                        class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"
                                        data-id="{{ $partner['id'] }}" title="Delete this partner">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="delete_partner_{{ $partner['id'] }}"
                                        id="delete_partner_{{ $partner['id'] }}" value="">

                                    <!-- Logo Upload -->
                                    <div class="mb-6">
                                        <label class="text-[10px] uppercase font-black tracking-widest text-[#007bff] block mb-3">Partner Logo</label>
                                        <input type="file"
                                            name="partner_logo_{{ $partner['id'] }}"
                                            id="partner_logo_{{ $partner['id'] }}"
                                            class="dropify"
                                            accept="image/*"
                                            data-default-file="{{ $partner['logo'] && !str_starts_with($partner['logo'], '<') && !str_starts_with($partner['logo'], 'http') ? asset($partner['logo']) : '' }}"
                                            data-height="120">
                                        <input type="hidden"
                                            name="partners[{{ $partner['id'] }}][logo]"
                                            id="partner_logo_url_{{ $partner['id'] }}"
                                            value="{{ $partner['logo'] }}">
                                    </div>

                                    <!-- Partner Name Input -->
                                    <div>
                                        <input type="text" name="partners[{{ $partner['id'] }}][name]"
                                            value="{{ $partner['name'] }}"
                                            class="w-full text-lg font-bold text-white bg-transparent focus:border-[#007bff] focus:ring-0 p-2 placeholder:text-gray-600 transition-colors"
                                            placeholder="Partner Name">
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Partner Button -->
                            <button type="button" onclick="addPartner()"
                                class="border-2 border-dashed border-[#1a1f2e] rounded-lg flex flex-col items-center justify-center p-8 hover:border-[#007bff] hover:bg-[#007bff]/5 transition-all group min-h-[250px] value-card">
                                <div
                                    class="w-16 h-16 rounded-full bg-[#121828] text-gray-500 flex items-center justify-center group-hover:bg-[#007bff] group-hover:text-white transition-all mb-4 shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-black uppercase tracking-widest text-gray-500 group-hover:text-[#007bff] transition-colors">
                                    Add New Partner
                                </span>
                                <span class="text-xs text-gray-600 mt-2 group-hover:text-gray-500 transition-colors">
                                    Click to add a new partner
                                </span>
                            </button>
                        </div>


                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between bg-[#121828] border border-[#1a1f2e] p-6 rounded-lg shadow-lg">
                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                        <svg class="w-5 h-5 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>All changes are saved instantly and reflected on the frontend</span>
                    </div>

                    <button type="submit"
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-[#007bff] text-white rounded-lg font-black uppercase tracking-wider text-sm hover:bg-[#0056b3] transition-all duration-300 hover:-translate-y-0.5 shadow-lg shadow-[#007bff]/30">
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

        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease-out;
        }

        /* Focus styles for inputs */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
        }

        /* Smooth transitions */
        button,
        input,
        textarea,
        select {
            transition: all 0.2s ease;
        }

        /* Custom scrollbar for dark theme */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0e17;
        }

        ::-webkit-scrollbar-thumb {
            background: #1a1f2e;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #007bff;
        }

        /* Icon preview hover effect */
        .icon-preview-container {
            transition: all 0.2s ease;
        }

        .icon-preview-container:hover {
            transform: scale(1.05);
        }

        /* Card hover improvement */
        .value-card {
            transition: all 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        }

        /* Delete button positioning */
        .delete-button {
            z-index: 10;
        }

        /* Dropify custom styling for dark theme */
        .dropify-wrapper {
            background: #121828;
            border: 2px dashed #1a1f2e;
            border-radius: 0.5rem;
            padding: 0;
            overflow: hidden;
        }

        .dropify-wrapper:hover {
            border-color: #007bff;
            background: rgba(0, 123, 255, 0.05);
        }

        .dropify-message {
            padding: 2rem 1rem;
            color: #9ca3af;
        }

        .dropify-message svg {
            fill: #9ca3af;
            width: 40px;
            height: 40px;
            margin-bottom: 0.5rem;
        }

        .dropify-message span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .dropify-preview {
            background: #0a0e17;
        }

        .dropify-clear {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }

        .dropify-clear:hover {
            background: rgb(220, 38, 38);
        }

        .dropify-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #fca5a5;
        }
    </style>

    <script>
        // Debug: Check if required libraries are loaded
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Dropify loaded:', typeof $.fn.dropify !== 'undefined');

        // Initialize Dropify after a short delay to ensure library is fully loaded
        setTimeout(function () {
            if (typeof $.fn.dropify === 'function' && $('.dropify').length) {
                console.log('Initializing Dropify on page load...');
                initializeDropify();
            } else {
                console.error('Dropify not available or no elements found');
                console.log('jQuery available:', typeof $ !== 'undefined');
                console.log('Dropify function:', typeof $.fn.dropify);
                console.log('Dropify elements:', $('.dropify').length);
            }
        }, 500);


        // Initialize Dropify after a short delay to ensure library is fully loaded
        setTimeout(function () {
            if (typeof $.fn.dropify === 'function' && $('.dropify').length) {
                console.log('Initializing Dropify on page load...');
                initializeDropify();
            } else {
                console.error('Dropify not available or no elements found');
            }
        }, 500);

        // Separate function to initialize Dropify
        function initializeDropify() {
            // Check if Dropify is available and element exists
            if (typeof $.fn.dropify === 'function' && $('.dropify').length && !$('.dropify').data('dropify')) {
                $('.dropify').dropify({
                    showRemove: true,
                    showErrors: true,
                    errorsPosition: 'outside',
                    messages: {
                        'default': 'Drag and drop a file here or click',
                        'replace': 'Drag and drop or click to replace',
                        'remove': 'Remove',
                        'error': 'Ooops, something wrong happened.'
                    }
                });
                console.log('Dropify initialized successfully');
            } else if ($('.dropify').data('dropify')) {
                console.log('Dropify already initialized');
            } else {
                console.error('Dropify library not loaded or element not found');
            }
        }



        var nextId = {{ count($partners) + 1 }};

        // Handle Dropify events
        $(document).on('dropify.afterClear', '.dropify', function(event, element) {
            var id = element.input[0].id.replace('partner_logo_', '');
            var urlInput = document.getElementById('partner_logo_url_' + id);
            if (urlInput) {
                urlInput.value = '';
            }
        });

        $(document).on('dropify.fileSelected', '.dropify', function(event, element) {
            var input = element.input[0];
            var id = input.id.replace('partner_logo_', '');
            if (input.files && input.files[0]) {
                var file = input.files[0];
                console.log('File selected for partner ' + id + ':', file.name);
            }
        });

        // Add delete button functionality
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var form = document.getElementById('partners-form');
            if (confirm('Delete this partner?')) {
                var deleteInput = document.getElementById('delete_partner_' + id);
                if (deleteInput && form) {
                    deleteInput.value = id;
                    form.submit();
                }
            }
        });

        // Form submission debugging
        $('#partners-form').on('submit', function(e) {
            console.log('Partners form submitting...');
        });

        function addPartner() {
            try {
                var container = document.getElementById('partners-container');
                var addButton = container.lastElementChild;

                console.log('Adding new partner with ID:', nextId);

                if (!container) {
                    console.error('Partners container not found!');
                    return;
                }

                if (!addButton) {
                    console.error('Add button not found!');
                    return;
                }

                var div = document.createElement('div');
                div.className = 'bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 value-card group/card relative animate-fade-in-down';

                // Build HTML using string concatenation to avoid template literal issues
                var partnerId = nextId;
                div.innerHTML =
                    '<button type="button"' +
                    'class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"' +
                    'data-id="' + partnerId + '" title="Delete this partner">' +
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' +
                    '</svg>' +
                    '</button>' +
                    '<input type="hidden" name="delete_partner_' + partnerId + '" id="delete_partner_' + partnerId + '" value="">' +
                    '<div class="mb-6">' +
                    '<label class="text-[10px] uppercase font-black tracking-widest text-[#007bff] block mb-3">Partner Logo</label>' +
                    '<input type="file"' +
                    'name="partner_logo_' + partnerId + '" ' +
                    'id="partner_logo_' + partnerId + '" ' +
                    'class="dropify"' +
                    'accept="image/*"' +
                    'data-height="120">' +
                    '<input type="hidden"' +
                    'name="partners[' + partnerId + '][logo]"' +
                    'id="partner_logo_url_' + partnerId + '"' +
                    'value="">' +
                    '</div>' +
                    '<div>' +
                    '<input type="text" name="partners[' + partnerId + '][name]"' +
                    'class="w-full text-lg font-bold text-white bg-transparent focus:border-[#007bff] focus:ring-0 p-2 placeholder:text-gray-600 transition-colors"' +
                    'placeholder="Partner Name">' +
                    '</div>';

                container.insertBefore(div, addButton);

                // Initialize Dropify for the new file input
                var newDropify = div.querySelector('.dropify');
                if (newDropify && typeof $.fn.dropify === 'function') {
                    setTimeout(function() {
                        $(newDropify).dropify({
                            showRemove: true,
                            showErrors: true,
                            errorsPosition: 'outside',
                            messages: {
                                'default': 'Drag and drop a file here or click',
                                'replace': 'Drag and drop or click to replace',
                                'remove': 'Remove',
                                'error': 'Ooops, something wrong happened.'
                            }
                        });
                        console.log('New Dropify element initialized');
                    }, 100);
                }

                // Add delete button functionality for the new card
                var deleteButton = div.querySelector('.delete-button');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        var id = this.getAttribute('data-id');
                        var form = document.getElementById('partners-form');
                        if (confirm('Delete this partner?')) {
                            var deleteInput = document.getElementById('delete_partner_' + id);
                            if (deleteInput && form) {
                                deleteInput.value = id;
                                form.submit();
                            }
                        }
                    });
                }

                // Focus on the name input field
                setTimeout(function() {
                    var nameInput = div.querySelector('input[type="text"]');
                    if (nameInput) {
                        nameInput.focus();
                        console.log('Name input focused');
                    }
                }, 100);

                nextId++;
            } catch (error) {
                console.error('Error adding new partner:', error);
                alert('There was an error adding a new partner. Please check the console for details.');
            }
        }
    </script>
</x-layouts.app>
