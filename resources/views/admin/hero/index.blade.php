<x-layouts.app title="Hero Section Management">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css">
    <!-- Dropify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Hero Section Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website hero section from here</p>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
            </div>

            <!-- Hero Preview -->
            <section class="relative min-h-screen flex items-center pt-24 md:pt-20 pb-32 md:pb-40 overflow-hidden rounded-xl border border-gray-200 dark:border-surface-600">
                <!-- Background Image Edit Button -->
                <button onclick="event.preventDefault(); event.stopPropagation(); openBackgroundModal();" class="absolute top-4 right-4 z-50 w-12 h-12 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center text-white transition-all shadow-lg hover:scale-110 border-2 border-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </button>

                <!-- Background Image -->
                <div class="absolute inset-0 z-0">
                    <img id="hero-background-image" src="{{ $hero->background_image ? asset($hero->background_image) : asset('hero-placeholder.svg') }}" onerror="this.src='https://placehold.co/1920x1080/1e3a5a/ffffff?text=Hero+Background'" class="w-full h-full object-cover scale-105" alt="Power Infrastructure">
                    <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark via-industrial-dark/80 to-transparent"></div>
                    <div class="absolute inset-0 bg-industrial-dark/40"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="flex items-center gap-3 mb-6 md:mb-8">
                            <div class="h-px w-8 md:w-12 bg-industrial-blue"></div>
                            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-xs editable-badge" data-field="badge">
                                {{ $hero->badge ?? 'Leaders in Energy & Infrastructure' }}
                            </span>
                            <button onclick="editField('badge')" class="p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </div>

                        <h1 class="text-3xl sm:text-4xl md:text-[4em] font-display font-black uppercase italic leading-[1.1] mb-8 text-white drop-shadow-[0_5px_15px_rgba(0,0,0,0.5)] editable-title" data-field="title">
                            {{ $hero->title ?? 'POWERING BANGLADESH SINCE 1980' }}
                            <button onclick="editField('title')" class="ml-2 p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </h1>

                        <p class="text-sm md:text-base text-slate-200 max-w-lg mb-8 md:mb-10 leading-relaxed font-medium editable-description" data-field="description">
                            {{ $hero->description ?? 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.' }}
                            <button onclick="editField('description')" class="ml-2 p-1 text-white/50 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </p>

                        <div class="flex flex-wrap gap-4 md:gap-5">
                            @foreach($hero->cta_buttons ?? [] as $cta)
                                @if($cta['type'] === 'primary')
                                    <!-- Primary CTA Button -->
                                    <div class="relative group">
                                        <a href="{{ $cta['link'] ?? '/projects' }}" class="bg-industrial-blue text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs flex items-center gap-3 hover:bg-industrial-red transition-all shadow-2xl hover:scale-105 active:scale-95 editable-cta" data-field="cta_button_text">
                                            {{ $cta['text'] ?? 'EXPLORE CATALOG' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide w-4 h-4">
                                                <path d="m9 18 6-6-6-6"></path>
                                            </svg>
                                        </a>
                                        <button onclick="editCtaButton('cta_button_text', 'cta_button_link')" class="absolute -top-2 -right-2 w-6 h-6 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @elseif($cta['type'] === 'secondary')
                                    <!-- Secondary CTA Button -->
                                    <div class="relative group">
                                        <a href="{{ $cta['link'] ?? '/about' }}" class="bg-white/5 border-2 border-white/20 text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs backdrop-blur-md hover:bg-white/20 transition-all hover:border-white editable-secondary" data-field="secondary_button_text">
                                            {{ $cta['text'] ?? 'CORPORATE PROFILE' }}
                                        </a>
                                        <button onclick="editCtaButton('secondary_button_text', 'secondary_button_link')" class="absolute -top-2 -right-2 w-6 h-6 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="hidden lg:grid grid-cols-2 gap-4 relative z-10">
                        <div class="glass-panel p-6 rounded-xl transform translate-y-8 hover:-translate-y-2 transition-all duration-500 cursor-pointer group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-industrial-blue mb-4 group-hover:scale-110 transition-transform">
                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            <h3 class="font-bold mb-2">Safety Core</h3>
                            <p class="text-[10px] text-slate-400">Class 5 risk mitigation integrated.</p>
                        </div>

                        <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-industrial-blue mb-4 group-hover:rotate-90 transition-transform duration-700">
                                <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <h3 class="font-bold mb-2">Turnkey EPC</h3>
                            <p class="text-[10px] text-slate-400">End-to-end project management.</p>
                        </div>

                        <div class="col-span-2 glass-panel p-6 rounded-xl flex items-center justify-between hover:bg-industrial-blue/10 transition-colors">
                            <div>
                                <h3 class="text-2xl font-display font-black flex items-center gap-2"> ISO <span class="text-[10px] text-industrial-blue bg-industrial-blue/10 px-2 py-0.5 rounded uppercase">9001:2015</span></h3>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Certified Compliance</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide w-8 h-8 text-industrial-blue animate-pulse">
                                <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Quick Category Bar -->
                <div class="absolute bottom-0 w-full bg-white/5 backdrop-blur-3xl border-t border-white/10 overflow-x-auto">
                    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10 min-w-[600px] md:min-w-0">
                        @foreach($hero->sorted_categories ?? [] as $category)
                            <div class="py-6 md:py-8 px-0 group cursor-pointer hover:bg-white/5 transition-colors relative">
                                <button onclick="editCategory({{ $category['order'] }})" class="absolute top-2 right-2 w-5 h-5 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 flex items-center justify-center">
                                        @if(!empty($category['icon']))
                                            <div class="text-industrial-blue group-hover:text-industrial-red transition-colors">{!! $category['icon'] !!}</div>
                                        @else
                                            <svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-[8px] md:text-[10px] text-slate-500 font-black uppercase tracking-widest editable-cat{{ $category['order'] }}-subtitle" data-field="cat{{ $category['order'] }}_subtitle">
                                            {{ $category['subtitle'] ?? '45+ Models' }}
                                        </div>
                                        <div class="font-display font-black uppercase text-base md:text-xl group-hover:text-industrial-blue transition-colors leading-tight editable-cat{{ $category['order'] }}-title" data-field="cat{{ $category['order'] }}_title">
                                            {{ $category['title'] ?? 'Transformers' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Dashboard</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Back to main dashboard</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
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

    <!-- Background Image Edit Modal -->
    <div id="background-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Background Image</h3>
                <button onclick="closeBackgroundModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="background-form" action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Upload New Image</label>
                    <input type="file" name="background_image_dropify" id="background_image_dropify" class="dropify" accept="image/*">
                    <input type="hidden" name="background_image" id="background_image_url" value="{{ $hero->background_image ?? '' }}">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Or Enter Image URL</label>
                    <input type="text" id="background_url_input" value="{{ $hero->background_image ? asset($hero->background_image) : asset('hero-placeholder.svg') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="/hero.png">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeBackgroundModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="submit" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Update Background</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden form for field updates -->
    <form id="hero-form" action="{{ route('admin.hero.update') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="badge" value="{{ $hero->badge ?? '' }}">
        <input type="hidden" name="title" value="{{ $hero->title ?? '' }}">
        <input type="hidden" name="description" value="{{ $hero->description ?? '' }}">
        <input type="hidden" name="cta_button_text" value="{{ $hero->cta_button_text ?? '' }}">
        <input type="hidden" name="cta_button_link" value="{{ $hero->cta_button_link ?? '' }}">
        <input type="hidden" name="secondary_button_text" value="{{ $hero->secondary_button_text ?? '' }}">
        <input type="hidden" name="secondary_button_link" value="{{ $hero->secondary_button_link ?? '' }}">
        <input type="hidden" name="background_image" value="{{ $hero->background_image ?? '' }}">
        <input type="hidden" name="cat1_title" value="{{ $hero->cat1_title ?? 'Transformers' }}">
        <input type="hidden" name="cat1_subtitle" value="{{ $hero->cat1_subtitle ?? '45+ Models' }}">
        <input type="hidden" name="cat1_icon" value="{{ $hero->cat1_icon ?? '' }}">
        <input type="hidden" name="cat1_link" value="{{ $hero->cat1_link ?? '' }}">
        <input type="hidden" name="cat2_title" value="{{ $hero->cat2_title ?? 'Switchgear' }}">
        <input type="hidden" name="cat2_subtitle" value="{{ $hero->cat2_subtitle ?? '120+ Models' }}">
        <input type="hidden" name="cat2_icon" value="{{ $hero->cat2_icon ?? '' }}">
        <input type="hidden" name="cat2_link" value="{{ $hero->cat2_link ?? '' }}">
        <input type="hidden" name="cat3_title" value="{{ $hero->cat3_title ?? 'Renewables' }}">
        <input type="hidden" name="cat3_subtitle" value="{{ $hero->cat3_subtitle ?? '12GW Models' }}">
        <input type="hidden" name="cat3_icon" value="{{ $hero->cat3_icon ?? '' }}">
        <input type="hidden" name="cat3_link" value="{{ $hero->cat3_link ?? '' }}">
        <input type="hidden" name="cat4_title" value="{{ $hero->cat4_title ?? 'Automation' }}">
        <input type="hidden" name="cat4_subtitle" value="{{ $hero->cat4_subtitle ?? '80+ Models' }}">
        <input type="hidden" name="cat4_icon" value="{{ $hero->cat4_icon ?? '' }}">
        <input type="hidden" name="cat4_link" value="{{ $hero->cat4_link ?? '' }}">
        <input type="hidden" name="is_active" value="1">
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
                    <label id="field-label" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Field Value</label>
                    <textarea id="field-input" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeFieldModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveField()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save</button>
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
                    <input type="text" id="cta-button-text" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="EXPLORE CATALOG">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Button Link</label>
                    <input type="text" id="cta-button-link" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="/projects">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeCtaModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveCtaButton()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Button</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Edit Modal -->
    <div id="category-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="category-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Category</h3>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-category">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" id="category-title" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Subtitle</label>
                    <input type="text" id="category-subtitle" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Icon SVG Code</label>
                    <textarea id="category-icon" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent font-mono text-xs" placeholder="<svg>...</svg>"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Paste SVG code here or choose from presets below</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Choose Icon Preset</label>
                    <div class="grid grid-cols-6 gap-2 mt-2">
                        <button type="button" onclick="selectIcon('zap')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="selectIcon('settings')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                        <button type="button" onclick="selectIcon('wind')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.8 19.6A2 2 0 1 0 14 16H2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.8 4.4A2 2 0 1 1 11 8H2"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="selectIcon('cpu')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 2v2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 17h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20v2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2v2"></path>
                                <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                <rect x="8" y="8" width="8" height="8" rx="1"></rect>
                            </svg>
                        </button>
                        <button type="button" onclick="selectIcon('shield')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="selectIcon('activity')" class="p-3 border border-gray-200 dark:border-surface-600 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900 transition-colors">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeCategoryModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveCategory()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Category</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Debug: Check if required libraries are loaded
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Dropify loaded:', typeof $.fn.dropify !== 'undefined');

        // Initialize Dropify after a short delay to ensure library is fully loaded
        setTimeout(function() {
            if (typeof $.fn.dropify === 'function' && $('.dropify').length) {
                console.log('Initializing Dropify on page load...');
                initializeDropify();
            }
        }, 500);

        // Background modal functions
        function openBackgroundModal() {
            console.log('Opening background modal');
            const modal = document.getElementById('background-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                console.log('Modal opened successfully');

                // Set current background image in the URL input
                const currentBgImage = document.getElementById('hero-background-image').src;
                const urlInput = document.getElementById('background_url_input');
                if (urlInput && currentBgImage) {
                    urlInput.value = currentBgImage;
                    document.getElementById('background_image_url').value = currentBgImage;
                }

                // Initialize Dropify when modal opens (element is now visible)
                initializeDropify();
            } else {
                console.error('Background modal not found');
            }
        }

        // Separate function to initialize Dropify
        function initializeDropify() {
            // Check if Dropify is available and element exists
            if (typeof $.fn.dropify === 'function' && $('.dropify').length && !$('.dropify').data('dropify')) {
                $('.dropify').dropify({
                    defaultFile: '{{ $hero->background_image ? asset($hero->background_image) : '' }}',
                    showRemove: true,
                    showErrors: true,
                    errorsPosition: 'overlay',
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

        function updateBackgroundImage(imageUrl) {
            // Update the preview
            const bgImage = document.getElementById('hero-background-image');
            if (bgImage) {
                bgImage.src = imageUrl;
            }
            // Update the hidden form field
            const hiddenInput = document.getElementById('background_image_url');
            if (hiddenInput) {
                hiddenInput.value = imageUrl;
            }
            // Update the URL input
            const urlInput = document.getElementById('background_url_input');
            if (urlInput) {
                urlInput.value = imageUrl;
            }
        }

        function closeBackgroundModal() {
            const modal = document.getElementById('background-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Handle background URL input changes
        document.addEventListener('DOMContentLoaded', function() {
            const urlInput = document.getElementById('background_url_input');
            if (urlInput) {
                urlInput.addEventListener('input', function(e) {
                    updateBackgroundImage(e.target.value);
                });
            }

            // Handle background form submission
            const bgForm = document.getElementById('background-form');
            if (bgForm) {
                bgForm.addEventListener('submit', function(e) {
                    // Update the preview with the new image URL before submission
                    const newImageUrl = document.getElementById('background_image_url').value;
                    if (newImageUrl) {
                        updateBackgroundImage(newImageUrl);
                    }
                    // Form will submit normally to the server
                });
            }
        });

        // Close background modal on outside click
        document.addEventListener('DOMContentLoaded', function() {
            const bgModal = document.getElementById('background-modal');
            if (bgModal) {
                bgModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeBackgroundModal();
                    }
                });
            }
        });

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

            const titles = {
                'cta_button_text': 'Edit Primary Button',
                'secondary_button_text': 'Edit Secondary Button'
            };

            title.textContent = titles[textField] || 'Edit Button';

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
            const linkElement = textElement?.closest('a');
            if (linkElement) {
                linkElement.href = buttonLink;
            }

            // Update the form values
            document.querySelector(`input[name="${textField}"]`).value = buttonText;
            document.querySelector(`input[name="${linkField}"]`).value = buttonLink;

            closeCtaModal();

            // Auto-submit the form
            document.getElementById('hero-form').submit();
        }

        // Close CTA modal on outside click
        document.addEventListener('DOMContentLoaded', function() {
            const ctaModal = document.getElementById('cta-modal');
            if (ctaModal) {
                ctaModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCtaModal();
                    }
                });
            }
        });

        // Field editing functions
        function editField(fieldName) {
            const modal = document.getElementById('field-modal');
            const input = document.getElementById('field-input');
            const title = document.getElementById('field-modal-title');
            const label = document.getElementById('field-label');
            const fieldNameInput = document.getElementById('current-field-name');

            fieldNameInput.value = fieldName;

            const titles = {
                'badge': 'Edit Badge Text',
                'title': 'Edit Main Title',
                'description': 'Edit Description',
                'cta_button_text': 'Edit CTA Button Text',
                'secondary_button_text': 'Edit Secondary Button Text',
                'cat1_title': 'Edit Category 1 Title',
                'cat1_subtitle': 'Edit Category 1 Subtitle',
                'cat2_title': 'Edit Category 2 Title',
                'cat2_subtitle': 'Edit Category 2 Subtitle',
                'cat3_title': 'Edit Category 3 Title',
                'cat3_subtitle': 'Edit Category 3 Subtitle',
                'cat4_title': 'Edit Category 4 Title',
                'cat4_subtitle': 'Edit Category 4 Subtitle'
            };

            const labels = {
                'badge': 'Badge Text',
                'title': 'Main Title',
                'description': 'Description',
                'cta_button_text': 'CTA Button Text',
                'secondary_button_text': 'Secondary Button Text',
                'cat1_title': 'Category 1 Title',
                'cat1_subtitle': 'Category 1 Subtitle',
                'cat2_title': 'Category 2 Title',
                'cat2_subtitle': 'Category 2 Subtitle',
                'cat3_title': 'Category 3 Title',
                'cat3_subtitle': 'Category 3 Subtitle',
                'cat4_title': 'Category 4 Title',
                'cat4_subtitle': 'Category 4 Subtitle'
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
            const formInput = document.querySelector(`#hero-form [name="${fieldName}"]`);
            if (formInput) {
                formInput.value = value;
            }

            closeFieldModal();

            // Auto-submit the form
            document.getElementById('hero-form').submit();
        }

        // Close modal on outside click
        document.addEventListener('DOMContentLoaded', function() {
            const fieldModal = document.getElementById('field-modal');
            if (fieldModal) {
                fieldModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeFieldModal();
                    }
                });
            }

            const categoryModal = document.getElementById('category-modal');
            if (categoryModal) {
                categoryModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCategoryModal();
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

        // Icon SVG presets
        const iconPresets = {
            'zap': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
            'settings': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path><circle cx="12" cy="12" r="3"></circle></svg>',
            'wind': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.8 19.6A2 2 0 1 0 14 16H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.8 4.4A2 2 0 1 1 11 8H2"></path></svg>',
            'cpu': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>',
            'shield': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>',
            'activity': '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path></svg>'
        };

        // Category editing functions
        function editCategory(categoryId) {
            const modal = document.getElementById('category-modal');
            const titleInput = document.getElementById('category-title');
            const subtitleInput = document.getElementById('category-subtitle');
            const iconInput = document.getElementById('category-icon');
            const categoryInput = document.getElementById('current-category');
            const modalTitle = document.getElementById('category-modal-title');

            // Convert numeric ID to cat1, cat2, etc.
            const catId = 'cat' + categoryId;
            categoryInput.value = catId;

            const titles = {
                'cat1': 'Edit Category 1',
                'cat2': 'Edit Category 2',
                'cat3': 'Edit Category 3',
                'cat4': 'Edit Category 4'
            };

            modalTitle.textContent = titles[catId] || 'Edit Category';

            // Get current values using the correct catId format
            titleInput.value = document.querySelector(`[data-field="${catId}_title"]`)?.textContent || '';
            subtitleInput.value = document.querySelector(`[data-field="${catId}_subtitle"]`)?.textContent || '';
            iconInput.value = document.querySelector(`input[name="${catId}_icon"]`)?.value || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCategoryModal() {
            const modal = document.getElementById('category-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function selectIcon(iconName) {
            document.getElementById('category-icon').value = iconPresets[iconName];
        }

        function saveCategory() {
            const catId = document.getElementById('current-category').value; // Already in cat1, cat2 format
            const title = document.getElementById('category-title').value;
            const subtitle = document.getElementById('category-subtitle').value;
            const icon = document.getElementById('category-icon').value;

            // Update the preview
            const titleElement = document.querySelector(`[data-field="${catId}_title"]`);
            const subtitleElement = document.querySelector(`[data-field="${catId}_subtitle"]`);

            if (titleElement) titleElement.textContent = title;
            if (subtitleElement) subtitleElement.textContent = subtitle;

            // Update the form values with null checks
            const titleInput = document.querySelector(`input[name="${catId}_title"]`);
            const subtitleInput = document.querySelector(`input[name="${catId}_subtitle"]`);
            const iconInput = document.querySelector(`input[name="${catId}_icon"]`);

            if (titleInput) titleInput.value = title;
            if (subtitleInput) subtitleInput.value = subtitle;
            if (iconInput) iconInput.value = icon;

            closeCategoryModal();

            // Auto-submit the form
            document.getElementById('hero-form').submit();
        }

        // Handle Dropify events (using event delegation since element is in modal)
        $(document).ready(function() {
            // Use event delegation for Dropify events
            $(document).on('dropify.afterClear', '.dropify', function(event, element) {
                document.getElementById('background_image_url').value = '';
            });

            $(document).on('dropify.fileSelected', '.dropify', function(event, element) {
                const input = element.input[0];
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    // Create a temporary URL for preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update the preview with the uploaded file using the helper function
                        updateBackgroundImage(e.target.result);
                    };
                    reader.readAsDataURL(file);
                    // Set a placeholder value for the form submission
                    document.getElementById('background_image_url').value = '/temp-uploads/' + file.name;
                }
            });
        });
    </script>
</x-layouts.app>