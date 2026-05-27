<x-layouts.app title="Core Values Management">
    @php
        // Define SVG icons for dropdown options
        $svgIcons = [
            'shield' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
            'award' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8l-4 4m0 0l4 4m-4-4h12M8 12H4M12 2v4M12 18v4M8 8l4-4M16 8l-4 4"></path></svg>',
            'users' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'trending' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'zap' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
            'target' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l4 4m0-4l-4 4m4-4v12m0 0l-4-4m4 4h12m-12 0a5 5 0 110-10 5 5 0 010 10z"></path></svg>',
            'star' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>',
            'heart' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>'
        ];

        // Function to get current icon key from stored value
        function getCurrentIconKey($iconValue, $svgIcons) {
            if (empty($iconValue)) {
                return 'shield';
            }

            // If it's already an icon name, return it
            if (isset($svgIcons[$iconValue])) {
                return $iconValue;
            }

            // Check if it's old icon name format
            $oldToNew = [
                'ShieldCheck' => 'shield',
                'Award' => 'award',
                'Users' => 'users',
                'TrendingUp' => 'trending',
                'Zap' => 'zap',
                'Target' => 'target'
            ];

            if (isset($oldToNew[$iconValue])) {
                return $oldToNew[$iconValue];
            }

            // If it's SVG code, find matching icon
            foreach ($svgIcons as $key => $svg) {
                if (trim($iconValue) === trim($svg)) {
                    return $key;
                }
            }

            return 'shield'; // default
        }

        // Function to get SVG from stored value
        function getIconFromValue($iconValue, $svgIcons) {
            if (empty($iconValue)) {
                return $svgIcons['shield'];
            }

            // If it's already SVG code, return it
            if (strpos($iconValue, '<svg') !== false) {
                return $iconValue;
            }

            // Convert old icon names to new keys
            $oldToNew = [
                'ShieldCheck' => 'shield',
                'Award' => 'award',
                'Users' => 'users',
                'TrendingUp' => 'trending',
                'Zap' => 'zap',
                'Target' => 'target'
            ];

            $key = $oldToNew[$iconValue] ?? $iconValue;

            return $svgIcons[$key] ?? $svgIcons['shield'];
        }
    @endphp

    <div class="min-h-screen bg-[#0a0e17] py-20 px-4 md:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->


            <form action="{{ route('admin.core-values.update') }}" method="POST">
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
                                    class="bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 transition-all group/card relative">
                                    <!-- Delete Button -->
                                    <button type="submit" name="delete_value" value="{{ $value['id'] }}"
                                        class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white"
                                        onclick="return confirm('Delete this core value?')" title="Delete this value">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <!-- Icon Display & Selector -->
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="w-12 h-12 bg-[#007bff]/10 rounded-lg flex items-center justify-center" id="icon-preview-{{ $value['id'] }}">
                                            <div id="icon-container-{{ $value['id'] }}" class="w-6 h-6 text-[#007bff]">
                                                {!! getIconFromValue($value['icon'], $svgIcons) !!}
                                            </div>
                                        </div>

                                        <select name="values[{{ $value['id'] }}][icon]"
                                                id="icon-select-{{ $value['id'] }}"
                                                onchange="updateIconPreview({{ $value['id'] }}, this.value)"
                                                class="bg-[#007bff]/10 text-[#007bff] p-2 rounded border border-[#1a1f2e] text-xs font-black focus:ring-1 focus:ring-[#007bff] focus:outline-none focus:border-[#007bff] cursor-pointer">
                                            @foreach($svgIcons as $key => $svg)
                                                <option value="{{ $svg }}" {{ getCurrentIconKey($value['icon'], $svgIcons) === $key ? 'selected' : '' }}>
                                                    {{ ucfirst($key) }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                class="border-2 border-dashed border-[#1a1f2e] rounded-lg flex flex-col items-center justify-center p-8 hover:border-[#007bff] hover:bg-[#007bff]/5 transition-all group min-h-[280px]">
                                <div
                                    class="w-14 h-14 rounded-full bg-[#121828] text-gray-500 flex items-center justify-center group-hover:bg-[#007bff] group-hover:text-white transition-all mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-xs font-black uppercase tracking-widest text-gray-500 group-hover:text-[#007bff] transition-colors">
                                    Add New Value
                                </span>
                            </button>
                        </div>
                       

                    </div>
                </div>

                <!-- Values Grid Editor -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-black uppercase tracking-wider text-white">
                            Value <span class="text-[#007bff]">Items</span>
                        </h3>
                        <span
                            class="text-xs text-gray-400 uppercase tracking-widest bg-[#121828] px-3 py-1 rounded">{{ count($values) }}
                            Items</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="values-container">


                        
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between bg-[#121828] border border-[#1a1f2e] p-6 rounded-lg">
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
    </style>

    <script>
        let nextId = {{ count($values) + 1 }};

        function addValue() {
            const container = document.getElementById('values-container');
            const addButton = container.lastElementChild;

            const div = document.createElement('div');
            div.className = 'bg-[#121828] border border-[#1a1f2e] rounded-lg p-6 hover:border-[#007bff]/50 transition-all group/card relative animate-fade-in-down';
            div.innerHTML = `
                <!-- Delete Button -->
                <button type="submit" name="delete_value" value="${nextId}"
                    class="absolute top-3 right-3 w-7 h-7 bg-red-900/30 text-red-400 rounded flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity hover:bg-red-500 hover:text-white"
                    onclick="return confirm('Delete this core value?')"
                    title="Delete this value">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Icon Display & Selector -->
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-[#007bff]/10 rounded-lg flex items-center justify-center" id="icon-preview-${nextId}">
                        <div id="icon-container-${nextId}" class="w-6 h-6 text-[#007bff]">
                            <svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>

                    <select name="values[${nextId}][icon]"
                            id="icon-select-${nextId}"
                            onchange="updateIconPreview(${nextId}, this.value)"
                            class="bg-[#007bff]/10 text-[#007bff] p-2 rounded border border-[#1a1f2e] text-xs font-black focus:ring-1 focus:ring-[#007bff] focus:outline-none focus:border-[#007bff] cursor-pointer">
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>' selected>Shield</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8l-4 4m0 0l4 4m-4-4h12M8 12H4M12 2v4M12 18v4M8 8l4-4M16 8l-4 4"></path></svg>'>Award</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'>Users</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'>Trending</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'>Zap</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l4 4m0-4l-4 4m4-4v12m0 0l-4-4m4 4h12m-12 0a5 5 0 110-10 5 5 0 010 10z"></path></svg>'>Target</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'>Star</option>
                        <option value='<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>'>Heart</option>
                    </select>
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
            `;

            container.insertBefore(div, addButton);
            div.querySelector('input').focus();
            nextId++;
        }

        // Function to update icon preview when dropdown changes
        function updateIconPreview(id, svgValue) {
            const container = document.getElementById(`icon-container-${id}`);
            const preview = document.getElementById(`icon-preview-${id}`);

            if (container && preview && svgValue) {
                // Update the preview with the selected SVG
                container.innerHTML = svgValue;

                // Add animation to show the change
                preview.style.transform = 'scale(0.95)';
                preview.style.opacity = '0.7';
                setTimeout(() => {
                    preview.style.transform = 'scale(1)';
                    preview.style.opacity = '1';
                }, 150);
            }
        }

        // Initialize icon previews with smooth transitions
        document.addEventListener('DOMContentLoaded', function () {
            // Add transitions to icon previews
            const previews = document.querySelectorAll('[id^="icon-preview-"]');
            previews.forEach(preview => {
                preview.style.transition = 'all 0.15s ease-out';
            });
        });
    </script>
</x-layouts.app>