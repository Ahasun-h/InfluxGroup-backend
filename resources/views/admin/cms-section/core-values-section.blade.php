<x-layouts.app title="Core Values Management">

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Core-Values Section Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website Core-Values section from here</p>
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          Home Page
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          About Page
                    </span>
                </div>
            </div>

            <form action="{{ route('admin.core-values.update') }}" method="POST" id="core-values-form">
                @csrf
                @method('PUT')

                <!-- Section Header Editor -->
                <div class="bg-[#121828] border border-[#1a1f2e] rounded-lg p-8 md:p-12 mb-8">
                    <div class="text-center mb-8">
                        <input type="text" name="title" value="{{ $content['title'] }}"
                               class="w-full text-4xl md:text-5xl font-black uppercase tracking-wider text-white text-center bg-transparent focus:border-[#007bff] focus:ring-0 p-4 placeholder:text-gray-600 transition-colors"
                               placeholder="CORE VALUES">


                        <textarea name="subtitle" rows="2"
                                  class="w-full text-gray-400 text-lg text-center bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-gray-600"
                                  placeholder="The principles that guide everything we do">{{ $content['subtitle'] }}</textarea>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="values-container">
                            @foreach($values as $value)
                                <div
                                    class="bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 value-card group/card relative">
                                    <!-- Delete Button -->
                                    <button type="button"
                                            class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"
                                            data-id="{{ $value['id'] }}" title="Delete this value">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="delete_value_{{ $value['id'] }}"
                                           id="delete_value_{{ $value['id'] }}" value="">

                                    <!-- Icon Input Section -->
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <label
                                                class="text-[10px] uppercase font-black tracking-widest text-[#007bff]">Icon
                                                Preview</label>
                                            <div class="w-16 h-16 bg-[#007bff]/10 rounded-lg flex items-center justify-center overflow-hidden icon-preview-container"
                                                 id="icon-preview-{{ $value['id'] }}" style="transition: 0.15s ease-out;">
                                                <div id="icon-container-{{ $value['id'] }}"
                                                     class="w-8 h-8 text-[#007bff] flex items-center justify-center">
                                                    {!! $value['icon'] !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative">
                                            <textarea name="values[{{ $value['id'] }}][icon]"
                                                      id="icon-input-{{ $value['id'] }}" rows="3"
                                                      class="w-full bg-[#121828] text-gray-300 text-xs p-3 rounded-lg border border-[#1a1f2e] focus:border-[#007bff] focus:ring-1 focus:ring-[#007bff] focus:outline-none resize-none font-mono"
                                                      placeholder="Paste your SVG code here..."
                                                      oninput="updateIconPreview({{ $value['id'] }}, this.value)">{!! $value['icon'] !!}</textarea>

                                            <div class="absolute top-2 right-2 text-[8px] text-gray-600 font-mono">SVG</div>
                                        </div>
                                    </div>

                                    <!-- Title Input -->
                                    <div class="mb-4">
                                        <input type="text" name="values[{{ $value['id'] }}][title]"
                                               value="{{ $value['title'] }}"
                                               class="w-full text-lg font-bold text-white bg-transparent focus:border-[#007bff] focus:ring-0 p-2 placeholder:text-gray-600 transition-colors"
                                               placeholder="Value Title">
                                    </div>

                                    <!-- Description Textarea -->
                                    <div>
                                        <textarea name="values[{{ $value['id'] }}][description]" rows="4"
                                                  class="w-full text-gray-400 text-sm leading-relaxed bg-transparent focus:border-[#007bff] focus:ring-0 p-2 resize-none placeholder:text-gray-600 transition-colors"
                                                  placeholder="Value description...">{{ $value['description'] }}</textarea>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Value Button -->
                            <button type="button" onclick="addValue()"
                                    class="border-2 border-dashed border-[#1a1f2e] rounded-lg flex flex-col items-center justify-center p-8 hover:border-[#007bff] hover:bg-[#007bff]/5 transition-all group min-h-[350px] value-card">
                                <div
                                    class="w-16 h-16 rounded-full bg-[#121828] text-gray-500 flex items-center justify-center group-hover:bg-[#007bff] group-hover:text-white transition-all mb-4 shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-black uppercase tracking-widest text-gray-500 group-hover:text-[#007bff] transition-colors">
                                    Add New Value
                                </span>
                                <span class="text-xs text-gray-600 mt-2 group-hover:text-gray-500 transition-colors">
                                    Click to add a new core value
                                </span>
                            </button>
                        </div>


                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="flex items-center justify-between bg-[#121828] border border-[#1a1f2e] p-6 rounded-lg shadow-lg">
                    <div class="flex items-center gap-3 text-gray-400 text-sm">
                        <svg class="w-5 h-5 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>All changes are saved instantly and reflected on the frontend</span>
                    </div>

                    <button type="submit"
                            class="group inline-flex items-center gap-3 px-8 py-4px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">
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
            </style>
    </x-slot:styles>

    <x-slot:scripts>
        <script>
                let nextId = {{ count($values) + 1 }};

                // Update icon preview from SVG input
                function updateIconPreview(id, svgValue) {
                    const container = document.getElementById(`icon-container-${id}`);
                    const preview = document.getElementById(`icon-preview-${id}`);

                    if (container && svgValue.trim()) {
                        try {
                            // Update the preview with the SVG
                            container.innerHTML = svgValue;

                            // Ensure SVG elements within the container are properly sized
                            const svg = container.querySelector('svg');
                            if (svg) {
                                svg.style.width = '100%';
                                svg.style.height = '100%';
                                svg.style.maxWidth = '2rem';
                                svg.style.maxHeight = '2rem';
                                svg.style.overflow = 'visible';
                            }

                            // Add animation to show the change
                            if (preview) {
                                preview.style.transform = 'scale(0.95)';
                                preview.style.opacity = '0.7';
                                setTimeout(() => {
                                    preview.style.transform = 'scale(1)';
                                    preview.style.opacity = '1';
                                }, 150);
                            }
                        } catch (error) {
                            console.error('Error updating icon preview:', error);
                            // Set default icon if there's an error
                            container.innerHTML = '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        }
                    }
                }

                function addValue() {
                    try {
                        const container = document.getElementById('values-container');
                        const addButton = container.lastElementChild;

                        console.log('Adding new value with ID:', nextId);
                        console.log('Container:', container);
                        console.log('Add button:', addButton);

                        if (!container) {
                            console.error('Values container not found!');
                            return;
                        }

                        if (!addButton) {
                            console.error('Add button not found!');
                            return;
                        }

                        const div = document.createElement('div');
                        div.className = 'bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 value-card group/card relative animate-fade-in-down';
                        div.innerHTML = `
                <!-- Delete Button -->
                <button type="button"
                    class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white delete-button"
                    data-id="${nextId}"
                    title="Delete this value">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <input type="hidden" name="delete_value_${nextId}" id="delete_value_${nextId}" value="">

                <!-- Icon Input Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-[10px] uppercase font-black tracking-widest text-[#007bff]">Icon Preview</label>
                        <div class="w-16 h-16 bg-[#007bff]/10 rounded-lg flex items-center justify-center overflow-hidden icon-preview-container"
                             id="icon-preview-${nextId}" style="transition: 0.15s ease-out;">
                            <div id="icon-container-${nextId}" class="w-8 h-8 text-[#007bff] flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <textarea
                            name="values[${nextId}][icon]"
                            id="icon-input-${nextId}"
                            rows="3"
                            class="w-full bg-[#121828] text-gray-300 text-xs p-3 rounded-lg border border-[#1a1f2e] focus:border-[#007bff] focus:ring-1 focus:ring-[#007bff] focus:outline-none resize-none font-mono"
                            placeholder="Paste your SVG code here..."
                            oninput="updateIconPreview(${nextId}, this.value)"><svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></textarea>

                        <div class="absolute top-2 right-2 text-[8px] text-gray-600 font-mono">SVG</div>
                    </div>
                </div>

                <!-- Title Input -->
                <div class="mb-4">
                    <input type="text" name="values[${nextId}][title]"
                        class="w-full text-lg font-bold text-white bg-transparent focus:border-[#007bff] focus:ring-0 p-2 placeholder:text-gray-600 transition-colors"
                        placeholder="Value Title">
                </div>

                <!-- Description Textarea -->
                <div>
                    <textarea name="values[${nextId}][description]" rows="4"
                        class="w-full text-gray-400 text-sm leading-relaxed bg-transparent focus:border-[#007bff] focus:ring-0 p-2 resize-none placeholder:text-gray-600 transition-colors"
                        placeholder="Value description..."></textarea>
                </div>
                </div>
            `;

                        container.insertBefore(div, addButton);

                        console.log('New value card added:', div);
                        console.log('Updated nextId:', nextId + 1);

                        // Add delete button functionality for the new card
                        const deleteButton = div.querySelector('.delete-button');
                        if (deleteButton) {
                            deleteButton.addEventListener('click', function (e) {
                                e.preventDefault();
                                const id = this.getAttribute('data-id');
                                const form = document.getElementById('core-values-form');
                                if (confirm('Delete this core value?')) {
                                    const deleteInput = document.getElementById(`delete_value_${id}`);
                                    if (deleteInput && form) {
                                        deleteInput.value = id;
                                        form.submit();
                                    }
                                }
                            });
                        }

                        // Focus on the title input field
                        setTimeout(() => {
                            const titleInput = div.querySelector('input[type="text"]');
                            if (titleInput) {
                                titleInput.focus();
                                console.log('Title input focused');
                            } else {
                                console.error('Title input not found!');
                            }
                        }, 100);

                        nextId++;
                    } catch (error) {
                        console.error('Error adding new value:', error);
                        alert('There was an error adding a new value. Please check the console for details.');
                    }
                }

                // Initialize icon previews with proper sizing
                document.addEventListener('DOMContentLoaded', function () {
                    // Add transitions to icon previews
                    const previews = document.querySelectorAll('[id^="icon-preview-"]');
                    previews.forEach(preview => {
                        preview.style.transition = 'all 0.15s ease-out';
                    });

                    // Ensure all existing SVG icons are properly sized
                    const containers = document.querySelectorAll('[id^="icon-container-"]');
                    containers.forEach(container => {
                        const svg = container.querySelector('svg');
                        if (svg) {
                            svg.style.width = '100%';
                            svg.style.height = '100%';
                            svg.style.maxWidth = '2rem';
                            svg.style.maxHeight = '2rem';
                            svg.style.overflow = 'visible';
                        }
                    });

                    // Add form submission debugging
                    const form = document.getElementById('core-values-form');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            console.log('Form submitting...');
                            const formData = new FormData(form);
                            console.log('Form data:', Object.fromEntries(formData));

                            // Check if values are present
                            const values = [];
                            for (let [key, value] of formData.entries()) {
                                if (key.startsWith('values[')) {
                                    values.push({ key, value });
                                }
                            }
                            console.log('Values found:', values);
                        });
                    }

                    // Add delete button functionality
                    const deleteButtons = document.querySelectorAll('.delete-button');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function (e) {
                            e.preventDefault();
                            const id = this.getAttribute('data-id');
                            if (confirm('Delete this core value?')) {
                                // Set the delete value and submit the form
                                const deleteInput = document.getElementById(`delete_value_${id}`);
                                if (deleteInput) {
                                    deleteInput.value = id;
                                    form.submit();
                                }
                            }
                        });
                    });
                });
            </script>
    </x-slot:scripts>

</x-layouts.app>
