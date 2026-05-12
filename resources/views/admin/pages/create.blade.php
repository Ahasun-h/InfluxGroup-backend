@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-editor {
            min-height: 400px !important;
            background-color: transparent !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.75rem !important;
            color: inherit !important;
            padding: 1rem !important;
        }
        .dark trix-toolbar .trix-button {
            background-color: #334155 !important;
            border-color: #475569 !important;
        }
        .dark trix-toolbar .trix-button--active {
            background-color: #14b8a6 !important;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush

<x-layouts.app title="Create Dynamic Page">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Create New Page</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Design a new information page for your site.</p>
            </div>
        </div>

        <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Page Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Privacy Policy"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-base focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Page Content (Rich Text)</label>
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" class="trix-content dark:text-white prose dark:prose-invert max-w-none"></trix-editor>
                        </div>
                    </div>
                </div>

                <!-- Settings Sidebar -->
                <div class="space-y-6">
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Publishing</h3>
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="glass-card p-6 sm:p-8 flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 px-4 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                            Create Page
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="w-full py-3 px-4 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-center hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                            Discard
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
