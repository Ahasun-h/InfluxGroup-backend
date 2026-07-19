<x-layouts.app title="Website Settings">
    <x-slot:styles>
        <!-- Load Dropify dependencies -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
        <script src="{{ asset('js/dropify.min.js') }}"></script>

        <style>
            /* Dropify custom styling for dark theme */
            .dropify-wrapper {
                background: #121828;
                border: 2px dashed #1a1f2e;
                border-radius: 0.75rem;
                transition: all 0.2s ease;
                overflow: hidden;
            }

            .dropify-wrapper:hover {
                border-color: #0d9488;
                background: rgba(13, 148, 136, 0.05);
            }

            .dropify-message {
                padding: 2rem 1rem;
                color: #9ca3af;
            }

            .dropify-message span {
                font-size: 0.7rem;
                font-weight: 500;
            }

            .dropify-preview {
                background: #0a0e17;
            }

            .dropify-clear {
                background: rgba(239, 68, 68, 0.9);
                color: white;
                border: none;
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
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
    </x-slot:styles>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Website Settings</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage your website appearance and content</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Settings -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Header Settings -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Header Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Header Logo -->
                            <div class="md:col-span-2">
                                <label for="header_logo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Header Logo (Light Mode)</label>
                                <input type="file" name="header_logo" id="header_logo" class="dropify" accept="image/*"
                                    @if($settings['header_logo'] ?? null) data-default-file="{{ asset('storage/' . $settings['header_logo']) }}" @endif />
                                <input type="hidden" name="old_header_logo" value="{{ $settings['header_logo'] ?? '' }}" />
                                <x-input-error :messages="$errors->get('header_logo')" class="mt-2" />
                                @if($settings['header_logo'] ?? null)
                                <form action="{{ route('admin.settings.delete-logo') }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-600">Remove current logo</button>
                                </form>
                                @endif
                            </div>

                            <!-- Header Logo Dark -->
                            <div class="md:col-span-2">
                                <label for="header_logo_dark" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Header Logo (Dark Mode Alternative)</label>
                                <input type="file" name="header_logo_dark" id="header_logo_dark" class="dropify" accept="image/*"
                                    @if($settings['header_logo_dark'] ?? null) data-default-file="{{ asset('storage/' . $settings['header_logo_dark']) }}" @endif />
                                <input type="hidden" name="old_header_logo_dark" value="{{ $settings['header_logo_dark'] ?? '' }}" />
                                <x-input-error :messages="$errors->get('header_logo_dark')" class="mt-2" />
                                @if($settings['header_logo_dark'] ?? null)
                                <form action="{{ route('admin.settings.delete-logo-dark') }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-600">Remove current dark logo</button>
                                </form>
                                @endif
                            </div>

                            <!-- Favicon -->
                            <div class="md:col-span-2">
                                <label for="favicon" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Favicon</label>
                                <input type="file" name="favicon" id="favicon" class="dropify" accept="image/*"
                                    @if($settings['favicon'] ?? null) data-default-file="{{ asset('storage/' . $settings['favicon']) }}" @endif />
                                <input type="hidden" name="old_favicon" value="{{ $settings['favicon'] ?? '' }}" />
                                <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                                @if($settings['favicon'] ?? null)
                                <form action="{{ route('admin.settings.delete-favicon') }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-600">Remove current favicon</button>
                                </form>
                                @endif
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Company Name</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="Your company name">
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <!-- Tagline -->
                            <div>
                                <label for="tagline" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tagline</label>
                                <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $settings['tagline'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="Your tagline">
                                <x-input-error :messages="$errors->get('tagline')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Contact Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $settings['phone'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="+880 2 987 6543">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $settings['email'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="info@company.com">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Address</label>
                                <textarea name="address" id="address" rows="2"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-none"
                                    placeholder="Your company address">{{ old('address', $settings['address'] ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Footer Settings -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Footer Company Information</h3>

                        <div class="space-y-4">
                            <!-- Company Description -->
                            <div>
                                <label for="footer_company_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Company Description</label>
                                <textarea name="footer_company_description" id="footer_company_description" rows="3"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-none"
                                    placeholder="Enter company description for footer">{{ old('footer_company_description', $footerData['company_description'] ?? '') }}</textarea>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This appears below the logo in the footer.</p>
                                <x-input-error :messages="$errors->get('footer_company_description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Footer Social Media Links -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Footer Social Media Links</h3>

                        <div class="space-y-4">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="footer_social_media_{{ $i }}_platform" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Platform {{ $i }}</label>
                                            <select
                                                id="footer_social_media_{{ $i }}_platform"
                                                name="footer_social_media_{{ $i }}_platform"
                                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                            >
                                                <option value="">Select platform</option>
                                                <option value="facebook" {{ ($footerData['social_media'][$i-1]['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                                <option value="linkedin" {{ ($footerData['social_media'][$i-1]['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                                <option value="youtube" {{ ($footerData['social_media'][$i-1]['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                                <option value="twitter" {{ ($footerData['social_media'][$i-1]['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                                <option value="instagram" {{ ($footerData['social_media'][$i-1]['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="footer_social_media_{{ $i }}_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Profile URL {{ $i }}</label>
                                            <input
                                                type="url"
                                                id="footer_social_media_{{ $i }}_url"
                                                name="footer_social_media_{{ $i }}_url"
                                                value="{{ $footerData['social_media'][$i-1]['url'] ?? '' }}"
                                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                                placeholder="https://{{ $footerData['social_media'][$i-1]['platform'] ?? 'facebook' }}.com/yourpage"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Footer Bottom Bar -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Footer Bottom Bar</h3>

                        <div class="space-y-4">
                            <!-- Copyright Text -->
                            <div>
                                <label for="footer_copyright_text" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Copyright Text</label>
                                <input type="text" name="footer_copyright_text" id="footer_copyright_text" value="{{ old('footer_copyright_text', $footerData['copyright_text'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="© 2026 INFLUX GROUP ENGINEERING. All rights reserved.">
                                <x-input-error :messages="$errors->get('footer_copyright_text')" class="mt-2" />
                            </div>

                            <!-- ISO Certification -->
                            <div>
                                <label for="footer_iso_certification" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">ISO Certification</label>
                                <input type="text" name="footer_iso_certification" id="footer_iso_certification" value="{{ old('footer_iso_certification', $footerData['iso_certification'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="ISO 9001:2015">
                                <x-input-error :messages="$errors->get('footer_iso_certification')" class="mt-2" />
                            </div>

                            <!-- Show ISO Badge -->
                            <div>
                                <div class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        id="show_iso_badge"
                                        name="show_iso_badge"
                                        value="1"
                                        {{ $footerData['show_iso_badge'] ? 'checked' : '' }}
                                        class="w-4 h-4 text-brand-500 rounded focus:ring-brand-500"
                                    >
                                    <label for="show_iso_badge" class="text-sm text-gray-700 dark:text-gray-300">
                                        Show ISO 9001:2015 badge in footer
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">SEO Settings</h3>

                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="Website meta title">
                                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white resize-none"
                                    placeholder="Website meta description">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Meta Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white"
                                    placeholder="keyword1, keyword2, keyword3">
                                <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3 sticky top-8">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Save Settings
                        </button>
                        <a href="{{ route('dashboard') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
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
            // Wait for jQuery and Dropify to load
            var checkJQuery = setInterval(function() {
                if (typeof jQuery !== 'undefined') {
                    clearInterval(checkJQuery);
                    var $ = jQuery;

                    // Wait for Dropify to load
                    var checkDropify = setInterval(function() {
                        if (typeof $.fn.dropify !== 'undefined') {
                            clearInterval(checkDropify);
                            console.log('Dropify loaded! Initializing...');

                            // Initialize Dropify for file inputs
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

                            console.log('Dropify initialized on settings form');
                        } else {
                            console.log('Waiting for Dropify to load...');
                        }
                    }, 200);
                } else {
                    console.log('Waiting for jQuery to load...');
                }
            }, 200);
        });
        </script>
    </x-slot:scripts>
</x-layouts.app>
