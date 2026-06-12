<x-layouts.app title="Contact Section Management">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Contact Section Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website contact information from here</p>
            </div>
            <a href="{{ route('admin.cms-section.home-hero-section') }}"
               class="px-4 py-2 bg-gray-100 dark:bg-surface-800 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Hero Section
            </a>
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">See how your contact information will appear</p>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        Contact Page
                    </span>
                </div>
            </div>

            <!-- Contact Preview -->
            <div class="bg-white dark:bg-surface-800 rounded-xl border border-gray-200 dark:border-surface-600 p-8">
                <h2 class="text-3xl font-display font-black uppercase italic mb-8 text-gray-900 dark:text-white">
                    Contact <span class="text-industrial-blue">Information</span>
                </h2>

                <div class="space-y-8 mb-12">
                    <!-- Phone Section -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Phone</h3>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_phone_1']->section_content ?? '+880 2 987 6543' }}</p>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_phone_2']->section_content ?? '+880 1XXX-XXXXXX' }}</p>
                        </div>
                        <button onclick="editContactInfo('phone')" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Email Section -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Email</h3>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_email_1']->section_content ?? 'info@influxgroup.com' }}</p>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_email_2']->section_content ?? 'sales@influxgroup.com' }}</p>
                        </div>
                        <button onclick="editContactInfo('email')" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Office Hours Section -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Office Hours</h3>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_office_hours_weekdays']->section_content ?? 'Saturday - Thursday: 9:00 AM - 6:00 PM' }}</p>
                            <p class="text-slate-600 dark:text-slate-400">{{ $contactItems['contact_office_hours_friday']->section_content ?? 'Friday: Closed' }}</p>
                        </div>
                        <button onclick="editContactInfo('office_hours')" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Office Locations -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Our Offices</h3>
                    <button onclick="addNewOffice()" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-semibold transition-all flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Office
                    </button>
                </div>
                <div class="space-y-6" id="offices-container">
                    @foreach($offices as $office)
                    <div class="bg-industrial-light dark:bg-surface-700 p-6 rounded-lg group" data-office-id="{{ $office['order'] }}">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12h4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 8h4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 21v-3a2 2 0 0 0-4 0v3"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-7h-2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"></path>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg mb-1 text-gray-900 dark:text-white">{{ $office['city'] }}</h4>
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">{{ $office['type'] }}</p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">{{ $office['address'] }}</p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $office['phone'] }}</p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $office['email'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="editOffice({{ $office['order'] }})" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteOffice({{ $office['order'] }})" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-red-100 dark:hover:bg-red-900 rounded-lg transition-all">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Empty State -->
                @if($offices->isEmpty())
                <div id="empty-state" class="text-center py-12 bg-gray-50 dark:bg-surface-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-surface-600">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No Offices Added Yet</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Add your first office location to get started</p>
                    <button onclick="addNewOffice()" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-semibold transition-all inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add First Office
                    </button>
                </div>
                @endif

                <!-- Map Section -->
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-surface-600">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Google Map Location</h3>
                        <button onclick="editMap()" class="p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Edit Map
                        </button>
                    </div>
                    <div class="h-96 bg-slate-200 dark:bg-surface-700 rounded-lg overflow-hidden">
                        <iframe
                            src="{{ $contactItems['contact_map_embed_url']->section_content ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd' }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            class="rounded-lg"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Support Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Emergency Support Section</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage emergency contact information</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Preview -->
            <div class="bg-industrial-dark rounded-xl p-12 text-center">
                <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8 text-white">
                    {!! $contactItems['emergency_title']->section_content ?? 'Emergency <span class="text-industrial-red">Support</span>' !!}
                </h2>
                <p class="text-xl mb-12 text-slate-300">
                    {{ $contactItems['emergency_description']->section_content ?? '24/7 emergency support available for critical power infrastructure issues' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ $contactItems['emergency_primary_link']->section_content ?? 'tel:+88029876543' }}" class="bg-industrial-red hover:bg-red-700 text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>
                        </svg>
                        {{ $contactItems['emergency_primary_text']->section_content ?? 'Emergency Line' }}
                    </a>
                    <a href="{{ $contactItems['emergency_secondary_link']->section_content ?? 'mailto:support@influxgroup.com' }}" class="bg-white text-industrial-dark hover:bg-industrial-light px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        </svg>
                        {{ $contactItems['emergency_secondary_text']->section_content ?? 'Email Support' }}
                    </a>
                </div>
            </div>

            <!-- Edit Emergency Button -->
            <div class="mt-6 text-center">
                <button onclick="editEmergency()" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-semibold transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit Emergency Section
                </button>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="glass-card p-8 bg-gradient-to-r from-brand-50 to-blue-50 dark:from-brand-500/10 dark:to-blue-500/10">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.cms-section.home-hero-section') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-surface-800 rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">Hero Section</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage hero content</p>
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

    <!-- Hidden form for updates -->
    <form id="contact-form" action="{{ route('admin.cms-section.contact-section.update') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="phone_1" value="{{ $contactItems['contact_phone_1']->section_content ?? '' }}">
        <input type="hidden" name="phone_2" value="{{ $contactItems['contact_phone_2']->section_content ?? '' }}">
        <input type="hidden" name="email_1" value="{{ $contactItems['contact_email_1']->section_content ?? '' }}">
        <input type="hidden" name="email_2" value="{{ $contactItems['contact_email_2']->section_content ?? '' }}">
        <input type="hidden" name="office_hours_weekdays" value="{{ $contactItems['contact_office_hours_weekdays']->section_content ?? '' }}">
        <input type="hidden" name="office_hours_friday" value="{{ $contactItems['contact_office_hours_friday']->section_content ?? '' }}">
        <input type="hidden" name="map_embed_url" value="{{ $contactItems['contact_map_embed_url']->section_content ?? '' }}">
        <input type="hidden" name="deleted_offices" id="deleted-offices" value="">
        <input type="hidden" name="next_office_id" id="next-office-id" value="{{ $offices->isNotEmpty() ? max($offices->pluck('order')->toArray()) + 1 : 1 }}">

        <!-- Emergency Support hidden inputs -->
        <input type="hidden" name="emergency_title" value="{{ $contactItems['emergency_title']->section_content ?? 'Emergency <span class=\'text-industrial-red\'>Support</span>' }}">
        <input type="hidden" name="emergency_description" value="{{ $contactItems['emergency_description']->section_content ?? '24/7 emergency support available for critical power infrastructure issues' }}">
        <input type="hidden" name="emergency_primary_text" value="{{ $contactItems['emergency_primary_text']->section_content ?? 'Emergency Line' }}">
        <input type="hidden" name="emergency_primary_link" value="{{ $contactItems['emergency_primary_link']->section_content ?? 'tel:+88029876543' }}">
        <input type="hidden" name="emergency_secondary_text" value="{{ $contactItems['emergency_secondary_text']->section_content ?? 'Email Support' }}">
        <input type="hidden" name="emergency_secondary_link" value="{{ $contactItems['emergency_secondary_link']->section_content ?? 'mailto:support@influxgroup.com' }}">

        <!-- Office inputs container (dynamically managed) -->
        <div id="office-form-inputs">
            @foreach($offices as $office)
            <div class="office-input-group" data-office-id="{{ $office['order'] }}">
                <input type="hidden" name="office_{{ $office['order'] }}_city" value="{{ $office['city'] }}">
                <input type="hidden" name="office_{{ $office['order'] }}_type" value="{{ $office['type'] }}">
                <input type="hidden" name="office_{{ $office['order'] }}_address" value="{{ $office['address'] }}">
                <input type="hidden" name="office_{{ $office['order'] }}_phone" value="{{ $office['phone'] }}">
                <input type="hidden" name="office_{{ $office['order'] }}_email" value="{{ $office['email'] }}">
            </div>
            @endforeach
        </div>
    </form>

    <!-- Contact Info Edit Modal -->
    <div id="contact-info-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 id="contact-info-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Edit Contact Information</h3>
            </div>
            <form id="contact-info-form" class="p-6 space-y-4">
                <input type="hidden" id="current-contact-info-type">

                <div id="phone-inputs" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Phone Number 1</label>
                        <input type="text" id="phone_1" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="+880 2 987 6543">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Phone Number 2</label>
                        <input type="text" id="phone_2" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="+880 1XXX-XXXXXX">
                    </div>
                </div>

                <div id="email-inputs" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email Address 1</label>
                        <input type="email" id="email_1" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="info@influxgroup.com">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email Address 2</label>
                        <input type="email" id="email_2" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="sales@influxgroup.com">
                    </div>
                </div>

                <div id="office-hours-inputs" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Weekday Hours</label>
                        <input type="text" id="office_hours_weekdays" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Saturday - Thursday: 9:00 AM - 6:00 PM">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Friday Hours</label>
                        <input type="text" id="office_hours_friday" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Friday: Closed">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeContactInfoModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveContactInfo()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Office Edit Modal -->
    <div id="office-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700 flex items-center justify-between">
                <h3 id="office-modal-title" class="text-xl font-bold text-gray-900 dark:text-white">Add New Office</h3>
                <button onclick="closeOfficeModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="current-office-id">
                <input type="hidden" id="is-new-office" value="false">

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">City <span class="text-red-500">*</span></label>
                    <input type="text" id="office_city" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="e.g., Dhaka">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Office Type</label>
                    <input type="text" id="office_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="e.g., Corporate Headquarters">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Address <span class="text-red-500">*</span></label>
                    <textarea id="office_address" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Full office address"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Phone <span class="text-red-500">*</span></label>
                    <input type="text" id="office_phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Office phone number">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="office_email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Office email">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeOfficeModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveOffice()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Office</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-md w-full mx-4">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Delete Office?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">This action will permanently delete this office location. This cannot be undone.</p>
                <input type="hidden" id="office-to-delete">
                <div class="flex justify-center gap-3">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button onclick="confirmDeleteOffice()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">Delete Office</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Edit Modal -->
    <div id="map-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-3xl w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Google Map Location</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Google Maps Embed URL</label>
                    <input type="text" id="map_embed_url_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent font-mono text-sm" placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-gray-500 mt-2">Paste your Google Maps embed URL here. You can get it from <a href="https://www.google.com/maps" target="_blank" class="text-brand-600 hover:text-brand-700">Google Maps</a> → Share → Embed a map</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Preview</label>
                    <div class="h-64 bg-slate-200 dark:bg-surface-700 rounded-lg overflow-hidden">
                        <iframe
                            id="map-preview"
                            src="{{ $contactItems['contact_map_embed_url']->section_content ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd' }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeMapModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveMap()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Update Map</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Support Edit Modal -->
    <div id="emergency-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200 dark:border-surface-700 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Emergency Support Section</h3>
                <button onclick="closeEmergencyModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Section Title (HTML allowed)</label>
                    <input type="text" id="emergency_title_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Emergency <span class='text-industrial-red'>Support</span>">
                    <p class="text-xs text-gray-500 mt-1">You can use HTML tags like &lt;span&gt; for styling</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea id="emergency_description_input" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="24/7 emergency support available for critical power infrastructure issues"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Primary Button Text</label>
                        <input type="text" id="emergency_primary_text_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Emergency Line">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Primary Button Link</label>
                        <input type="text" id="emergency_primary_link_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="tel:+88029876543">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Secondary Button Text</label>
                        <input type="text" id="emergency_secondary_text_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="Email Support">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Secondary Button Link</label>
                        <input type="text" id="emergency_secondary_link_input" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent" placeholder="mailto:support@influxgroup.com">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEmergencyModal()" class="px-6 py-3 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">Cancel</button>
                    <button type="button" onclick="saveEmergency()" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-semibold hover:bg-brand-600 transition-all">Save Emergency Section</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            // Contact info editing functions
            function editContactInfo(type) {
                const modal = document.getElementById('contact-info-modal');
                const title = document.getElementById('contact-info-modal-title');
                const typeInput = document.getElementById('current-contact-info-type');
                const phoneInputs = document.getElementById('phone-inputs');
                const emailInputs = document.getElementById('email-inputs');
                const officeHoursInputs = document.getElementById('office-hours-inputs');

                typeInput.value = type;

                // Hide all input groups first
                phoneInputs.classList.add('hidden');
                emailInputs.classList.add('hidden');
                officeHoursInputs.classList.add('hidden');

                const titles = {
                    'phone': 'Edit Phone Numbers',
                    'email': 'Edit Email Addresses',
                    'office_hours': 'Edit Office Hours'
                };

                title.textContent = titles[type] || 'Edit Contact Information';

                if (type === 'phone') {
                    phoneInputs.classList.remove('hidden');
                    document.getElementById('phone_1').value = document.querySelector('input[name="phone_1"]').value;
                    document.getElementById('phone_2').value = document.querySelector('input[name="phone_2"]').value;
                } else if (type === 'email') {
                    emailInputs.classList.remove('hidden');
                    document.getElementById('email_1').value = document.querySelector('input[name="email_1"]').value;
                    document.getElementById('email_2').value = document.querySelector('input[name="email_2"]').value;
                } else if (type === 'office_hours') {
                    officeHoursInputs.classList.remove('hidden');
                    document.getElementById('office_hours_weekdays').value = document.querySelector('input[name="office_hours_weekdays"]').value;
                    document.getElementById('office_hours_friday').value = document.querySelector('input[name="office_hours_friday"]').value;
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeContactInfoModal() {
                const modal = document.getElementById('contact-info-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function saveContactInfo() {
                const type = document.getElementById('current-contact-info-type').value;

                if (type === 'phone') {
                    document.querySelector('input[name="phone_1"]').value = document.getElementById('phone_1').value;
                    document.querySelector('input[name="phone_2"]').value = document.getElementById('phone_2').value;
                } else if (type === 'email') {
                    document.querySelector('input[name="email_1"]').value = document.getElementById('email_1').value;
                    document.querySelector('input[name="email_2"]').value = document.getElementById('email_2').value;
                } else if (type === 'office_hours') {
                    document.querySelector('input[name="office_hours_weekdays"]').value = document.getElementById('office_hours_weekdays').value;
                    document.querySelector('input[name="office_hours_friday"]').value = document.getElementById('office_hours_friday').value;
                }

                closeContactInfoModal();
                document.getElementById('contact-form').submit();
            }

            // Office editing functions
            let isNewOffice = false;

            function editOffice(officeId) {
                const modal = document.getElementById('office-modal');
                const title = document.getElementById('office-modal-title');
                const idInput = document.getElementById('current-office-id');
                const isNewInput = document.getElementById('is-new-office');

                idInput.value = officeId;
                isNewInput.value = 'false';
                isNewOffice = false;
                title.textContent = 'Edit Office Location';

                // Populate current values
                const cityInput = document.querySelector('input[name="office_' + officeId + '_city"]');
                const typeInput = document.querySelector('input[name="office_' + officeId + '_type"]');
                const addressInput = document.querySelector('input[name="office_' + officeId + '_address"]');
                const phoneInput = document.querySelector('input[name="office_' + officeId + '_phone"]');
                const emailInput = document.querySelector('input[name="office_' + officeId + '_email"]');

                document.getElementById('office_city').value = cityInput ? cityInput.value : '';
                document.getElementById('office_type').value = typeInput ? typeInput.value : '';
                document.getElementById('office_address').value = addressInput ? addressInput.value : '';
                document.getElementById('office_phone').value = phoneInput ? phoneInput.value : '';
                document.getElementById('office_email').value = emailInput ? emailInput.value : '';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function addNewOffice() {
                const modal = document.getElementById('office-modal');
                const title = document.getElementById('office-modal-title');
                const isNewInput = document.getElementById('is-new-office');
                const nextOfficeId = document.getElementById('next-office-id').value;

                document.getElementById('current-office-id').value = nextOfficeId;
                isNewInput.value = 'true';
                isNewOffice = true;
                title.textContent = 'Add New Office';

                // Clear form fields
                document.getElementById('office_city').value = '';
                document.getElementById('office_type').value = '';
                document.getElementById('office_address').value = '';
                document.getElementById('office_phone').value = '';
                document.getElementById('office_email').value = '';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeOfficeModal() {
                const modal = document.getElementById('office-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                // Reset form
                document.getElementById('is-new-office').value = 'false';
                isNewOffice = false;
            }

            function saveOffice() {
                const officeId = document.getElementById('current-office-id').value;
                const isNew = document.getElementById('is-new-office').value === 'true';

                // Create or update form inputs
                let officeInputGroup = document.querySelector(`.office-input-group[data-office-id="${officeId}"]`);

                if (!officeInputGroup) {
                    // Create new input group
                    officeInputGroup = document.createElement('div');
                    officeInputGroup.className = 'office-input-group';
                    officeInputGroup.setAttribute('data-office-id', officeId);
                    document.getElementById('office-form-inputs').appendChild(officeInputGroup);

                    // Create new office card in preview
                    const officesContainer = document.getElementById('offices-container');
                    const emptyState = document.getElementById('empty-state');
                    if (emptyState) {
                        emptyState.remove();
                    }

                    const newOfficeCard = document.createElement('div');
                    newOfficeCard.className = 'bg-industrial-light dark:bg-surface-700 p-6 rounded-lg group';
                    newOfficeCard.setAttribute('data-office-id', officeId);
                    newOfficeCard.innerHTML = `
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12h4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 8h4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 21v-3a2 2 0 0 0-4 0v3"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"></path>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg mb-1 text-gray-900 dark:text-white" id="preview-city-${officeId}"></h4>
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-2" id="preview-type-${officeId}"></p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2" id="preview-address-${officeId}"></p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm" id="preview-phone-${officeId}"></p>
                                <p class="text-slate-600 dark:text-slate-400 text-sm" id="preview-email-${officeId}"></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="editOffice(${officeId})" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-surface-700 rounded-lg transition-all">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteOffice(${officeId})" class="opacity-0 group-hover:opacity-100 p-2 hover:bg-red-100 dark:hover:bg-red-900 rounded-lg transition-all">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                    officesContainer.appendChild(newOfficeCard);
                }

                // Update form inputs
                const cityField = document.querySelector(`input[name="office_${officeId}_city"]`);
                const typeField = document.querySelector(`input[name="office_${officeId}_type"]`);
                const addressField = document.querySelector(`input[name="office_${officeId}_address"]`);
                const phoneField = document.querySelector(`input[name="office_${officeId}_phone"]`);
                const emailField = document.querySelector(`input[name="office_${officeId}_email"]`);

                if (!cityField) {
                    // Create new input fields
                    officeInputGroup.innerHTML = `
                        <input type="hidden" name="office_${officeId}_city" value="">
                        <input type="hidden" name="office_${officeId}_type" value="">
                        <input type="hidden" name="office_${officeId}_address" value="">
                        <input type="hidden" name="office_${officeId}_phone" value="">
                        <input type="hidden" name="office_${officeId}_email" value="">
                    `;
                }

                // Update values
                document.querySelector(`input[name="office_${officeId}_city"]`).value = document.getElementById('office_city').value;
                document.querySelector(`input[name="office_${officeId}_type"]`).value = document.getElementById('office_type').value;
                document.querySelector(`input[name="office_${officeId}_address"]`).value = document.getElementById('office_address').value;
                document.querySelector(`input[name="office_${officeId}_phone"]`).value = document.getElementById('office_phone').value;
                document.querySelector(`input[name="office_${officeId}_email"]`).value = document.getElementById('office_email').value;

                // Update preview
                const previewCity = document.getElementById(`preview-city-${officeId}`);
                const previewType = document.getElementById(`preview-type-${officeId}`);
                const previewAddress = document.getElementById(`preview-address-${officeId}`);
                const previewPhone = document.getElementById(`preview-phone-${officeId}`);
                const previewEmail = document.getElementById(`preview-email-${officeId}`);

                if (previewCity) previewCity.textContent = document.getElementById('office_city').value;
                if (previewType) previewType.textContent = document.getElementById('office_type').value;
                if (previewAddress) previewAddress.textContent = document.getElementById('office_address').value;
                if (previewPhone) previewPhone.textContent = document.getElementById('office_phone').value;
                if (previewEmail) previewEmail.textContent = document.getElementById('office_email').value;

                // Update next office ID
                if (isNew) {
                    const currentNextId = parseInt(document.getElementById('next-office-id').value);
                    document.getElementById('next-office-id').value = currentNextId + 1;
                }

                closeOfficeModal();
                document.getElementById('contact-form').submit();
            }

            // Delete functions
            function deleteOffice(officeId) {
                const modal = document.getElementById('delete-modal');
                document.getElementById('office-to-delete').value = officeId;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeDeleteModal() {
                const modal = document.getElementById('delete-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function confirmDeleteOffice() {
                const officeId = document.getElementById('office-to-delete').value;
                const deletedOffices = document.getElementById('deleted-offices').value;

                // Add to deleted offices list
                document.getElementById('deleted-offices').value = deletedOffices ? deletedOffices + ',' + officeId : officeId;

                // Remove office card from preview
                const officeCard = document.querySelector(`[data-office-id="${officeId}"]`);
                if (officeCard) {
                    officeCard.remove();
                }

                // Remove form inputs
                const officeInputGroup = document.querySelector(`.office-input-group[data-office-id="${officeId}"]`);
                if (officeInputGroup) {
                    officeInputGroup.remove();
                }

                // Check if empty state should be shown
                const remainingOffices = document.querySelectorAll('#offices-container > div').length;
                if (remainingOffices === 0) {
                    // Show empty state
                    const officesContainer = document.getElementById('offices-container');
                    officesContainer.innerHTML = `
                        <div id="empty-state" class="text-center py-12 bg-gray-50 dark:bg-surface-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-surface-600">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No Offices Added Yet</h4>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Add your first office location to get started</p>
                            <button onclick="addNewOffice()" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl font-semibold transition-all inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add First Office
                            </button>
                        </div>
                    `;
                }

                closeDeleteModal();
                document.getElementById('contact-form').submit();
            }

            // Map editing functions
            function editMap() {
                const modal = document.getElementById('map-modal');
                const mapUrlInput = document.getElementById('map_embed_url_input');

                // Set current value
                mapUrlInput.value = document.querySelector('input[name="map_embed_url"]').value;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Add event listener for live preview
                mapUrlInput.addEventListener('input', function(e) {
                    document.getElementById('map-preview').src = e.target.value;
                });
            }

            function closeMapModal() {
                const modal = document.getElementById('map-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function saveMap() {
                const mapUrl = document.getElementById('map_embed_url_input').value;

                // Update the form value
                document.querySelector('input[name="map_embed_url"]').value = mapUrl;

                // Update all map iframes on the page
                document.querySelectorAll('iframe[src*="google.com/maps"]').forEach(function(iframe) {
                    iframe.src = mapUrl;
                });

                closeMapModal();
                document.getElementById('contact-form').submit();
            }

            // Emergency Support editing functions
            function editEmergency() {
                const modal = document.getElementById('emergency-modal');

                // Populate current values
                document.getElementById('emergency_title_input').value = document.querySelector('input[name="emergency_title"]').value;
                document.getElementById('emergency_description_input').value = document.querySelector('input[name="emergency_description"]').value;
                document.getElementById('emergency_primary_text_input').value = document.querySelector('input[name="emergency_primary_text"]').value;
                document.getElementById('emergency_primary_link_input').value = document.querySelector('input[name="emergency_primary_link"]').value;
                document.getElementById('emergency_secondary_text_input').value = document.querySelector('input[name="emergency_secondary_text"]').value;
                document.getElementById('emergency_secondary_link_input').value = document.querySelector('input[name="emergency_secondary_link"]').value;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeEmergencyModal() {
                const modal = document.getElementById('emergency-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function saveEmergency() {
                // Update form values
                document.querySelector('input[name="emergency_title"]').value = document.getElementById('emergency_title_input').value;
                document.querySelector('input[name="emergency_description"]').value = document.getElementById('emergency_description_input').value;
                document.querySelector('input[name="emergency_primary_text"]').value = document.getElementById('emergency_primary_text_input').value;
                document.querySelector('input[name="emergency_primary_link"]').value = document.getElementById('emergency_primary_link_input').value;
                document.querySelector('input[name="emergency_secondary_text"]').value = document.getElementById('emergency_secondary_text_input').value;
                document.querySelector('input[name="emergency_secondary_link"]').value = document.getElementById('emergency_secondary_link_input').value;

                closeEmergencyModal();
                document.getElementById('contact-form').submit();
            }

            // Close modals on outside click
            document.addEventListener('DOMContentLoaded', function () {
                const contactInfoModal = document.getElementById('contact-info-modal');
                const officeModal = document.getElementById('office-modal');
                const mapModal = document.getElementById('map-modal');
                const deleteModal = document.getElementById('delete-modal');
                const emergencyModal = document.getElementById('emergency-modal');

                if (contactInfoModal) {
                    contactInfoModal.addEventListener('click', function (e) {
                        if (e.target === this) {
                            closeContactInfoModal();
                        }
                    });
                }

                if (officeModal) {
                    officeModal.addEventListener('click', function (e) {
                        if (e.target === this) {
                            closeOfficeModal();
                        }
                    });
                }

                if (mapModal) {
                    mapModal.addEventListener('click', function (e) {
                        if (e.target === this) {
                            closeMapModal();
                        }
                    });
                }

                if (deleteModal) {
                    deleteModal.addEventListener('click', function (e) {
                        if (e.target === this) {
                            closeDeleteModal();
                        }
                    });
                }

                if (emergencyModal) {
                    emergencyModal.addEventListener('click', function (e) {
                        if (e.target === this) {
                            closeEmergencyModal();
                        }
                    });
                }

                // Show success message if any
                @if(session('success'))
                setTimeout(() => {
                    alert('{{ session('success') }}');
                }, 100);
                @endif
            });
        </script>
    </x-slot:scripts>
</x-layouts.app>
