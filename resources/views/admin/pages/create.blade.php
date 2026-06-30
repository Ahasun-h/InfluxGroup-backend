<x-layouts.app  title="Create Dynamic Page">

    <x-slot:styles>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.css" rel="stylesheet" />
        <style>
            #editor-container {
                min-height: 400px;
                background-color: transparent !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 0.75rem !important;
                color: inherit !important;
            }
            #editor-container .ql-toolbar {
                background-color: #334155 !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 0.5rem 0.5rem 0 0 !important;
            }
            #editor-container .ql-toolbar .ql-stroke {
                stroke: white !important;
            }
            #editor-container .ql-toolbar .ql-fill {
                fill: white !important;
            }
            #editor-container .ql-toolbar button.ql-active {
                background-color: #14b8a6 !important;
                color: white !important;
            }
            #editor-container .ql-toolbar button:hover {
                background-color: rgba(20, 184, 166, 0.3) !important;
            }
            #editor-container .ql-container {
                border: none !important;
                font-size: 16px;
                color: inherit;
            }
            #editor-container .ql-editor {
                min-height: 400px !important;
                background-color: transparent !important;
                color: inherit !important;
                padding: 1rem !important;
            }
            #editor-container .ql-editor.ql-blank::before {
                color: rgba(255, 255, 255, 0.5) !important;
                font-style: normal;
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
                            <div id="editor-container">
                                <div id="editor">{{ old('content') ?: '<p>Hello World!</p><p>Some initial <strong>bold</strong> text</p>' }}</div>
                            </div>
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


    <x-slot:scripts>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var quill = new Quill('#editor', {
                    theme: 'snow',
                    placeholder: 'Compose your page content here...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'indent': '-1'}, { 'indent': '+1' }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                // Update hidden input when content changes
                quill.on('text-change', function(delta, oldDelta, source) {
                    if (source === 'user') {
                        var content = quill.root.innerHTML;
                        document.querySelector('#content').value = content;
                    }
                });

                // Set initial content from hidden input if exists
                const initialContent = document.querySelector('#content').value;
                if (initialContent) {
                    quill.root.innerHTML = initialContent;
                }
            });
        </script>
    </x-slot:scripts>
</x-layouts.app>
