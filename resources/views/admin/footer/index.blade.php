<x-layouts.app title="Footer Management">
    <x-slot:styles>
        <style>
            .footer-section {
                @apply bg-white rounded-lg shadow-lg p-6 space-y-6;
            }
            .input-group {
                @apply space-y-4;
            }
            .input-group label {
                @apply block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5;
            }
            .input-group input[type="text"],
            .input-group input[type="url"] {
                @apply w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white;
            }
            .input-group input[type="checkbox"] {
                @apply w-4 h-4 text-brand-500 rounded focus:ring-brand-500;
            }
            .social-media-item {
                @apply bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl p-4;
            }
        </style>
    </x-slot:styles>

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Footer Management</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage footer content and social media links</p>
            </div>
        </div>

        <form action="{{ route('admin.footer.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Company Info Section -->
                    <div class="footer-section">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit mb-4">Company Information</h3>
                        <div class="input-group">
                            <label for="company_description">Company Description</label>
                            <textarea
                                id="company_description"
                                name="company_description"
                                rows="4"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white resize-y"
                                placeholder="Enter company description..."
                            >{{ $companyInfo->description ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This appears below the logo in the footer.</p>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="footer-section">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit mb-4">Social Media Links</h3>
                        <div class="space-y-4">
                            <!-- Social Media 1 -->
                            <div class="social-media-item">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="social_media_1_platform">Platform</label>
                                        <select
                                            id="social_media_1_platform"
                                            name="social_media_1_platform"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                        >
                                            <option value="">Select platform</option>
                                            <option value="facebook" {{ ($socialMedia[0]['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="linkedin" {{ ($socialMedia[0]['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="youtube" {{ ($socialMedia[0]['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            <option value="twitter" {{ ($socialMedia[0]['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="instagram" {{ ($socialMedia[0]['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="social_media_1_url">Profile URL</label>
                                        <input
                                            type="url"
                                            id="social_media_1_url"
                                            name="social_media_1_url"
                                            value="{{ $socialMedia[0]['url'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                            placeholder="https://facebook.com/yourpage"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media 2 -->
                            <div class="social-media-item">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="social_media_2_platform">Platform</label>
                                        <select
                                            id="social_media_2_platform"
                                            name="social_media_2_platform"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                        >
                                            <option value="">Select platform</option>
                                            <option value="facebook" {{ ($socialMedia[1]['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="linkedin" {{ ($socialMedia[1]['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="youtube" {{ ($socialMedia[1]['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            <option value="twitter" {{ ($socialMedia[1]['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="instagram" {{ ($socialMedia[1]['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="social_media_2_url">Profile URL</label>
                                        <input
                                            type="url"
                                            id="social_media_2_url"
                                            name="social_media_2_url"
                                            value="{{ $socialMedia[1]['url'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                            placeholder="https://linkedin.com/company/yourpage"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media 3 -->
                            <div class="social-media-item">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="social_media_3_platform">Platform</label>
                                        <select
                                            id="social_media_3_platform"
                                            name="social_media_3_platform"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                        >
                                            <option value="">Select platform</option>
                                            <option value="facebook" {{ ($socialMedia[2]['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="linkedin" {{ ($socialMedia[2]['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="youtube" {{ ($socialMedia[2]['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            <option value="twitter" {{ ($socialMedia[2]['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="instagram" {{ ($socialMedia[2]['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="social_media_3_url">Profile URL</label>
                                        <input
                                            type="url"
                                            id="social_media_3_url"
                                            name="social_media_3_url"
                                            value="{{ $socialMedia[2]['url'] ?? '' }}"
                                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                            placeholder="https://youtube.com/@yourchannel"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar Section -->
                <div class="space-y-6">
                    <div class="footer-section">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit mb-4">Bottom Bar</h3>
                        <div class="input-group">
                            <label for="copyright_text">Copyright Text</label>
                            <input
                                type="text"
                                id="copyright_text"
                                name="copyright_text"
                                value="{{ $bottomBar['copyright_text'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                placeholder="© 2026 INFLUX GROUP ENGINEERING. All Rights Reserved."
                            >
                        </div>
                        <div class="input-group">
                            <label for="iso_certification">ISO Certification</label>
                            <input
                                type="text"
                                id="iso_certification"
                                name="iso_certification"
                                value="{{ $bottomBar['iso_certification'] ?? '' }}"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none dark:text-white"
                                placeholder="ISO 9001:2015"
                            >
                        </div>
                        <div class="input-group">
                            <div class="flex items-center gap-3">
                                <input
                                    type="checkbox"
                                    id="show_iso_badge"
                                    name="show_iso_badge"
                                    value="1"
                                    {{ $bottomBar['show_iso_badge'] ? 'checked' : '' }}
                                    class="w-4 h-4 text-brand-500 rounded focus:ring-brand-500"
                                >
                                <label for="show_iso_badge" class="text-sm text-gray-700 dark:text-gray-300">
                                    Show ISO 9001:2015 badge in footer
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="glass-card p-6 sm:p-8 space-y-6">
                    <div class="bg-brand-50 dark:bg-brand-900/20 border border-brand-200 dark:border-brand-800 rounded-lg p-4">
                        <h4 class="font-bold text-brand-900 dark:text-brand-100 mb-2">ℹ️ Tips</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <li>• Company description appears below the logo</li>
                            <li>• Social links appear in the footer</li>
                            <li>• ISO badge appears in the bottom bar</li>
                            <li>• Use full URLs for social media (https://...)</li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Update Footer
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Back to Pages
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
