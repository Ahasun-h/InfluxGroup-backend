<x-layouts.app title="Homepage Content Management">
    <div class="space-y-8 pb-10">
        <!-- Add CSRF token and API endpoints for JavaScript -->
        <script>
            window.HOMEPAGE_ADMIN = {
                routes: {
                    services: "{{ route('admin.homepage.services') }}",
                    servicesStore: "{{ route('admin.homepage.services.store') }}",
                    servicesDelete: "{{ route('admin.homepage.services.delete', '__id__') }}",
                    projects: "{{ route('admin.homepage.projects') }}",
                    projectsStore: "{{ route('admin.homepage.projects.store') }}",
                    projectsDelete: "{{ route('admin.homepage.projects.delete', '__id__') }}",
                    projectsToggleFeatured: "{{ route('admin.homepage.projects.toggle-featured', '__id__') }}",
                    testimonials: "{{ route('admin.homepage.testimonials') }}",
                    testimonialsStore: "{{ route('admin.homepage.testimonials.store') }}",
                    testimonialsDelete: "{{ route('admin.homepage.testimonials.delete', '__id__') }}",
                    testimonialsToggleFeatured: "{{ route('admin.homepage.testimonials.toggle-featured', '__id__') }}",
                },
                csrf: "{{ csrf_token() }}"
            };
        </script>
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Homepage Content Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website homepage content from here</p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                Company Settings
            </a>
        </div>

        <form method="POST" action="{{ route('admin.homepage.update') }}" class="space-y-8">
            @csrf

            <!-- Hero Section -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Hero Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Main homepage banner content</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Hero Title</label>
                        <input type="text" name="hero[title]" value="{{ $homepage['hero']['title'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="Building Bangladesh's Future">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Hero Subtitle</label>
                        <input type="text" name="hero[subtitle]" value="{{ $homepage['hero']['subtitle'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="Leading infrastructure development since 1980">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="hero[description]" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="We deliver world-class construction and engineering solutions...">{{ $homepage['hero']['description'] ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CTA Button Text</label>
                            <input type="text" name="hero[cta_text]" value="{{ $homepage['hero']['cta_text'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="View Our Projects">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CTA Link</label>
                            <input type="text" name="hero[cta_link]" value="{{ $homepage['hero']['cta_link'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="/projects">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Background Image URL</label>
                        <input type="text" name="hero[background_image]" value="{{ $homepage['hero']['background_image'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="/images/hero-bg.jpg">
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="hero[show_contact_form]" value="1" {{ ($homepage['hero']['show_contact_form'] ?? false) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                        <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Show Contact Form in Hero</label>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Statistics Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Key company metrics to display</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Projects Completed</label>
                        <input type="number" name="stats[projects_completed]" value="{{ $homepage['stats']['projects_completed'] ?? 0 }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Years Experience</label>
                        <input type="number" name="stats[years_experience]" value="{{ $homepage['stats']['years_experience'] ?? 0 }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Happy Clients</label>
                        <input type="number" name="stats[happy_clients]" value="{{ $homepage['stats']['happy_clients'] ?? 0 }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Awards Won</label>
                        <input type="number" name="stats[awards_won]" value="{{ $homepage['stats']['awards_won'] ?? 0 }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Section Titles -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Section Titles & Descriptions</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Customize section headings throughout the homepage</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Services Section Title</label>
                            <input type="text" name="services_title" value="{{ $homepage['services_title'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Services Section Subtitle</label>
                            <input type="text" name="services_subtitle" value="{{ $homepage['services_subtitle'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Projects Section Title</label>
                            <input type="text" name="projects_title" value="{{ $homepage['projects_title'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Projects Section Subtitle</label>
                            <input type="text" name="projects_subtitle" value="{{ $homepage['projects_subtitle'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Testimonials Section Title</label>
                            <input type="text" name="testimonials_title" value="{{ $homepage['testimonials_title'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Testimonials Section Subtitle</label>
                            <input type="text" name="testimonials_subtitle" value="{{ $homepage['testimonials_subtitle'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Call-to-Action Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bottom section CTA content</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CTA Title</label>
                        <input type="text" name="cta_section[title]" value="{{ $homepage['cta_section']['title'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="Ready to Start Your Project?">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">CTA Description</label>
                        <textarea name="cta_section[description]" rows="2"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="Contact us today to discuss...">{{ $homepage['cta_section']['description'] ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Button Text</label>
                            <input type="text" name="cta_section[button_text]" value="{{ $homepage['cta_section']['button_text'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="Get in Touch">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Button Link</label>
                            <input type="text" name="cta_section[button_link]" value="{{ $homepage['cta_section']['button_link'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="/contact">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Statement / Trust Section -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Brand Statement / Trust Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Main brand statement and authority section</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Section Title (Main Heading)</label>
                        <input type="text" name="brand_statement[title]" value="{{ $homepage['brand_statement']['title'] ?? 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="ESTABLISHED AUTHORITY IN HEAVY ENGINEERING">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This is the main heading displayed in the section</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Highlighted Word</label>
                        <input type="text" name="brand_statement[highlighted_word]" value="{{ $homepage['brand_statement']['highlighted_word'] ?? 'AUTHORITY' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="AUTHORITY">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">The word that will be highlighted in blue color</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description Text</label>
                        <textarea name="brand_statement[description]" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="Following the legacy of JRC and Energypac...">{{ $homepage['brand_statement']['description'] ?? 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Section Image URL</label>
                        <input type="text" name="brand_statement[image_url]" value="{{ $homepage['brand_statement']['image_url'] ?? 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                            placeholder="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Overlay Box Title</label>
                            <input type="text" name="brand_statement[overlay_title]" value="{{ $homepage['brand_statement']['overlay_title'] ?? 'Core Reliability' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="Core Reliability">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Overlay Box Text</label>
                            <input type="text" name="brand_statement[overlay_text]" value="{{ $homepage['brand_statement']['overlay_text'] ?? 'Zero Downtime Operation Protocols' }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                placeholder="Zero Downtime Operation Protocols">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision Section -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Mission & Vision Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Company mission and vision statements</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Mission -->
                    <div class="bg-gray-50 dark:bg-surface-700 p-6 rounded-xl">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Mission
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Mission Title</label>
                                <input type="text" name="mission_vision[mission][title]" value="{{ $homepage['mission_vision']['mission']['title'] ?? 'Our Mission' }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                    placeholder="Our Mission">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Mission Description</label>
                                <textarea name="mission_vision[mission][description]" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                    placeholder="To deliver reliable, efficient, and sustainable power solutions...">{{ $homepage['mission_vision']['mission']['description'] ?? 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Mission Key Points</label>
                                <div class="space-y-2" id="mission-points-container">
                                    @foreach(($homepage['mission_vision']['mission']['points'] ?? [
                                        'Powering Bangladesh\'s development through innovative energy solutions',
                                        'Ensuring energy security for future generations',
                                        'Building sustainable infrastructure nationwide'
                                    ]) as $index => $point)
                                        <div class="flex gap-2">
                                            <input type="text" name="mission_vision[mission][points][]" value="{{ $point }}"
                                                class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                                placeholder="Enter mission point">
                                            @if($index > 0)
                                            <button type="button" onclick="this.parentElement.remove()" class="px-3 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="addMissionPoint()" class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-200 transition-colors text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Point
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Vision -->
                    <div class="bg-gray-50 dark:bg-surface-700 p-6 rounded-xl">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Vision
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Vision Title</label>
                                <input type="text" name="mission_vision[vision][title]" value="{{ $homepage['mission_vision']['vision']['title'] ?? 'Our Vision' }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                    placeholder="Our Vision">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Vision Description</label>
                                <textarea name="mission_vision[vision][description]" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                    placeholder="To be the leading engineering conglomerate...">{{ $homepage['mission_vision']['vision']['description'] ?? 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.' }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Vision Key Points</label>
                                <div class="space-y-2" id="vision-points-container">
                                    @foreach(($homepage['mission_vision']['vision']['points'] ?? [
                                        'Regional leadership in sustainable infrastructure development',
                                        'Global recognition for engineering excellence',
                                        'Pioneering renewable energy adoption'
                                    ]) as $index => $point)
                                        <div class="flex gap-2">
                                            <input type="text" name="mission_vision[vision][points][]" value="{{ $point }}"
                                                class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                                placeholder="Enter vision point">
                                            @if($index > 0)
                                            <button type="button" onclick="this.parentElement.remove()" class="px-3 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="addVisionPoint()" class="mt-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-xl font-semibold hover:bg-purple-200 transition-colors text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Point
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Management Section -->
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Services Section Items</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manage services displayed on homepage</p>
                        </div>
                    </div>
                    <button type="button" onclick="openServiceModal()" class="px-4 py-2 bg-brand-500 text-white rounded-lg font-semibold hover:bg-brand-600 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Service
                    </button>
                </div>

                <!-- Services List -->
                <div id="services-list" class="space-y-4">
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Loading services...
                    </div>
                </div>
            </div>

            <!-- Projects Management Section -->
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Projects Section Items</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manage featured projects displayed on homepage</p>
                        </div>
                    </div>
                    <button type="button" onclick="openProjectModal()" class="px-4 py-2 bg-brand-500 text-white rounded-lg font-semibold hover:bg-brand-600 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Project
                    </button>
                </div>

                <!-- Projects List -->
                <div id="projects-list" class="space-y-4">
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Loading projects...
                    </div>
                </div>
            </div>

            <!-- Testimonials Management Section -->
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Testimonials Section Items</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manage customer testimonials displayed on homepage</p>
                        </div>
                    </div>
                    <button type="button" onclick="openTestimonialModal()" class="px-4 py-2 bg-brand-500 text-white rounded-lg font-semibold hover:bg-brand-600 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Testimonial
                    </button>
                </div>

                <!-- Testimonials List -->
                <div id="testimonials-list" class="space-y-4">
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        Loading testimonials...
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-brand-600 to-brand-700 text-white rounded-xl font-bold hover:from-brand-700 hover:to-brand-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Save Homepage Content
                </button>
            </div>
        </form>

        <!-- Quick Links -->
        <div class="glass-card p-8 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Manage Projects</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Featured projects for homepage</p>
                    </div>
                </a>

                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Manage Services</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Services section content</p>
                    </div>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Manage Testimonials</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Customer reviews section</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Service Modal -->
    <div id="service-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="service-modal-title" class="text-2xl font-bold text-gray-900 dark:text-white">Add Service</h3>
            </div>
            <form id="service-form" class="p-6 space-y-4">
                <input type="hidden" name="id" id="service-id">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Service Title</label>
                    <input type="text" name="title" id="service-title" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Icon (optional)</label>
                    <input type="text" name="icon" id="service-icon" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white" placeholder="bolt">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="service-description" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white"></textarea>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeServiceModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="submit" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Service</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Project Modal -->
    <div id="project-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="project-modal-title" class="text-2xl font-bold text-gray-900 dark:text-white">Add Project</h3>
            </div>
            <form id="project-form" class="p-6 space-y-4">
                <input type="hidden" name="id" id="project-id">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Project Title</label>
                    <input type="text" name="title" id="project-title" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Location</label>
                        <input type="text" name="location" id="project-location" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <input type="text" name="category" id="project-category" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" id="project-status" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                            <option value="completed">Completed</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Completion (%)</label>
                        <input type="number" name="completion" id="project-completion" min="0" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Value ($)</label>
                        <input type="number" name="value" id="project-value" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="featured" id="project-featured" class="w-5 h-5 rounded border-gray-300 text-brand-600">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Featured on Homepage</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
                    <input type="text" name="image" id="project-image" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeProjectModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="submit" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Testimonial Modal -->
    <div id="testimonial-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="testimonial-modal-title" class="text-2xl font-bold text-gray-900 dark:text-white">Add Testimonial</h3>
            </div>
            <form id="testimonial-form" class="p-6 space-y-4">
                <input type="hidden" name="id" id="testimonial-id">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
                    <input type="text" name="name" id="testimonial-name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Position</label>
                        <input type="text" name="position" id="testimonial-position" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Company</label>
                        <input type="text" name="company" id="testimonial-company" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Testimonial Content</label>
                    <textarea name="content" id="testimonial-content" rows="4" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Rating (1-5)</label>
                        <input type="number" name="rating" id="testimonial-rating" min="1" max="5" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="featured" id="testimonial-featured" class="w-5 h-5 rounded border-gray-300 text-brand-600">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Featured on Homepage</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeTestimonialModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="submit" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Helper functions for dynamic points
        function addMissionPoint() {
            const container = document.getElementById('mission-points-container');
            const newPoint = document.createElement('div');
            newPoint.className = 'flex gap-2';
            newPoint.innerHTML = `
                <input type="text" name="mission_vision[mission][points][]"
                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                    placeholder="Enter mission point">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(newPoint);
        }

        function addVisionPoint() {
            const container = document.getElementById('vision-points-container');
            const newPoint = document.createElement('div');
            newPoint.className = 'flex gap-2';
            newPoint.innerHTML = `
                <input type="text" name="mission_vision[vision][points][]"
                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                    placeholder="Enter vision point">
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(newPoint);
        }

        // API helper functions
        async function apiCall(url, method = 'GET', data = null) {
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': HOMEPAGE_ADMIN.csrf,
                }
            };

            if (data) {
                options.body = JSON.stringify(data);
            }

            const response = await fetch(url, options);
            return await response.json();
        }

        // Load all data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadServices();
            loadProjects();
            loadTestimonials();
        });

        // SERVICES FUNCTIONS
        async function loadServices() {
            const container = document.getElementById('services-list');
            try {
                const response = await apiCall(HOMEPAGE_ADMIN.routes.services);
                if (response.success && response.data.length > 0) {
                    container.innerHTML = response.data.map(service => `
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-surface-700 rounded-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white">${service.title}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">${service.description.substring(0, 100)}...</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="editService(${service.id})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteService(${service.id})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="text-center py-8 text-gray-500 dark:text-gray-400">No services found. Click "Add Service" to create one.</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="text-center py-8 text-red-500">Error loading services</div>';
            }
        }

        function openServiceModal(service = null) {
            const modal = document.getElementById('service-modal');
            const form = document.getElementById('service-form');
            const title = document.getElementById('service-modal-title');

            if (service) {
                title.textContent = 'Edit Service';
                document.getElementById('service-id').value = service.id;
                document.getElementById('service-title').value = service.title;
                document.getElementById('service-icon').value = service.icon || '';
                document.getElementById('service-description').value = service.description;
            } else {
                title.textContent = 'Add Service';
                form.reset();
                document.getElementById('service-id').value = '';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeServiceModal() {
            const modal = document.getElementById('service-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editService(id) {
            // Fetch service data and open modal
            fetch(HOMEPAGE_ADMIN.routes.services)
                .then(res => res.json())
                .then(response => {
                    const service = response.data.find(s => s.id === id);
                    if (service) openServiceModal(service);
                });
        }

        async function deleteService(id) {
            if (!confirm('Are you sure you want to delete this service?')) return;

            const url = HOMEPAGE_ADMIN.routes.servicesDelete.replace('__id__', id);
            await apiCall(url, 'DELETE');
            loadServices();
        }

        document.getElementById('service-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            await apiCall(HOMEPAGE_ADMIN.routes.servicesStore, 'POST', data);
            closeServiceModal();
            loadServices();
        });

        // PROJECTS FUNCTIONS
        async function loadProjects() {
            const container = document.getElementById('projects-list');
            try {
                const response = await apiCall(HOMEPAGE_ADMIN.routes.projects);
                if (response.success && response.data.length > 0) {
                    container.innerHTML = response.data.map(project => `
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-surface-700 rounded-xl">
                            <div class="flex items-center gap-4">
                                <img src="${project.image || '/placeholder-project.jpg'}" alt="${project.title}" class="w-16 h-16 rounded-lg object-cover">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-gray-900 dark:text-white">${project.title}</h4>
                                        <span class="px-2 py-1 text-xs font-bold rounded ${project.featured ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                            ${project.featured ? 'Featured' : 'Standard'}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">${project.location} • ${project.category}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="toggleProjectFeatured(${project.id})" class="p-2 ${project.featured ? 'text-green-600' : 'text-gray-600'} hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </button>
                                <button onclick="editProject(${project.id})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteProject(${project.id})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="text-center py-8 text-gray-500 dark:text-gray-400">No projects found. Click "Add Project" to create one.</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="text-center py-8 text-red-500">Error loading projects</div>';
            }
        }

        function openProjectModal(project = null) {
            const modal = document.getElementById('project-modal');
            const form = document.getElementById('project-form');
            const title = document.getElementById('project-modal-title');

            if (project) {
                title.textContent = 'Edit Project';
                document.getElementById('project-id').value = project.id;
                document.getElementById('project-title').value = project.title;
                document.getElementById('project-location').value = project.location;
                document.getElementById('project-category').value = project.category;
                document.getElementById('project-status').value = project.status;
                document.getElementById('project-completion').value = project.completion || '';
                document.getElementById('project-value').value = project.value || '';
                document.getElementById('project-featured').checked = project.featured;
                document.getElementById('project-image').value = project.image || '';
            } else {
                title.textContent = 'Add Project';
                form.reset();
                document.getElementById('project-id').value = '';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeProjectModal() {
            const modal = document.getElementById('project-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editProject(id) {
            fetch(HOMEPAGE_ADMIN.routes.projects)
                .then(res => res.json())
                .then(response => {
                    const project = response.data.find(p => p.id === id);
                    if (project) openProjectModal(project);
                });
        }

        async function deleteProject(id) {
            if (!confirm('Are you sure you want to delete this project?')) return;

            const url = HOMEPAGE_ADMIN.routes.projectsDelete.replace('__id__', id);
            await apiCall(url, 'DELETE');
            loadProjects();
        }

        async function toggleProjectFeatured(id) {
            const url = HOMEPAGE_ADMIN.routes.projectsToggleFeatured.replace('__id__', id);
            await apiCall(url, 'POST');
            loadProjects();
        }

        document.getElementById('project-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            data.featured = document.getElementById('project-featured').checked;

            await apiCall(HOMEPAGE_ADMIN.routes.projectsStore, 'POST', data);
            closeProjectModal();
            loadProjects();
        });

        // TESTIMONIALS FUNCTIONS
        async function loadTestimonials() {
            const container = document.getElementById('testimonials-list');
            try {
                const response = await apiCall(HOMEPAGE_ADMIN.routes.testimonials);
                if (response.success && response.data.length > 0) {
                    container.innerHTML = response.data.map(testimonial => `
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-surface-700 rounded-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-gray-900 dark:text-white">${testimonial.name}</h4>
                                        <span class="px-2 py-1 text-xs font-bold rounded ${testimonial.featured ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                            ${testimonial.featured ? 'Featured' : 'Standard'}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">${testimonial.position ? testimonial.position + ' • ' : ''}${testimonial.company || ''}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="toggleTestimonialFeatured(${testimonial.id})" class="p-2 ${testimonial.featured ? 'text-green-600' : 'text-gray-600'} hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </button>
                                <button onclick="editTestimonial(${testimonial.id})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteTestimonial(${testimonial.id})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="text-center py-8 text-gray-500 dark:text-gray-400">No testimonials found. Click "Add Testimonial" to create one.</div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="text-center py-8 text-red-500">Error loading testimonials</div>';
            }
        }

        function openTestimonialModal(testimonial = null) {
            const modal = document.getElementById('testimonial-modal');
            const form = document.getElementById('testimonial-form');
            const title = document.getElementById('testimonial-modal-title');

            if (testimonial) {
                title.textContent = 'Edit Testimonial';
                document.getElementById('testimonial-id').value = testimonial.id;
                document.getElementById('testimonial-name').value = testimonial.name;
                document.getElementById('testimonial-position').value = testimonial.position || '';
                document.getElementById('testimonial-company').value = testimonial.company || '';
                document.getElementById('testimonial-content').value = testimonial.content;
                document.getElementById('testimonial-rating').value = testimonial.rating || '';
                document.getElementById('testimonial-featured').checked = testimonial.featured;
            } else {
                title.textContent = 'Add Testimonial';
                form.reset();
                document.getElementById('testimonial-id').value = '';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTestimonialModal() {
            const modal = document.getElementById('testimonial-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editTestimonial(id) {
            fetch(HOMEPAGE_ADMIN.routes.testimonials)
                .then(res => res.json())
                .then(response => {
                    const testimonial = response.data.find(t => t.id === id);
                    if (testimonial) openTestimonialModal(testimonial);
                });
        }

        async function deleteTestimonial(id) {
            if (!confirm('Are you sure you want to delete this testimonial?')) return;

            const url = HOMEPAGE_ADMIN.routes.testimonialsDelete.replace('__id__', id);
            await apiCall(url, 'DELETE');
            loadTestimonials();
        }

        async function toggleTestimonialFeatured(id) {
            const url = HOMEPAGE_ADMIN.routes.testimonialsToggleFeatured.replace('__id__', id);
            await apiCall(url, 'POST');
            loadTestimonials();
        }

        document.getElementById('testimonial-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            data.featured = document.getElementById('testimonial-featured').checked;

            await apiCall(HOMEPAGE_ADMIN.routes.testimonialsStore, 'POST', data);
            closeTestimonialModal();
            loadTestimonials();
        });
    </script>
</x-layouts.app>