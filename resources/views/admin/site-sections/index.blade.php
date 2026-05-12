<x-layouts.app title="Site Sections Management">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Site Sections</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Manage all your website sections from one place</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.hero.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-surface-600 transition-colors font-semibold">
                    Legacy Hero
                </a>
                <a href="{{ route('admin.brand-statements.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-surface-600 transition-colors font-semibold">
                    Legacy Brand Statement
                </a>
            </div>
        </div>

        <!-- Sections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($sections as $section)
                <div class="glass-card p-6 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $section->status === 'publish' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                {{ $section->status === 'publish' ? 'Published' : 'Draft' }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $section->title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $section->section_key }}</p>
                        </div>
                        <div class="text-2xl font-display font-bold text-gray-300 dark:text-gray-600">
                            {{ $section->order }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Type: <span class="font-medium">{{ ucfirst($section->type) }}</span>
                        </div>
                        <div class="flex gap-2">
                            @if($section->section_key === 'hero_section' || $section->section_key === 'brand_statement')
                                <a href="{{ route('admin.' . $section->section_key . '.index') }}" class="px-3 py-1 bg-brand-100 dark:bg-brand-900 text-brand-700 dark:text-brand-300 rounded text-sm font-medium hover:bg-brand-200 dark:hover:bg-brand-800 transition-colors">
                                    Edit (Legacy)
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($section->status === 'publish')
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-surface-600">
                            <a href="#" class="text-sm text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 font-medium">
                                View on website →
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Info Box -->
        <div class="glass-card p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">🎯 New Content Management System</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                This is your new unified content management system. All website sections are managed from this central location.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span class="text-gray-700 dark:text-gray-300"><strong>Publish:</strong> Visible on website</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-700 dark:text-gray-300"><strong>Draft:</strong> Hidden from website</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-brand-500 rounded-full"></span>
                    <span class="text-gray-700 dark:text-gray-300"><strong>Order:</strong> Display priority</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
