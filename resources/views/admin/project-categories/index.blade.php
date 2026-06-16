<x-layouts.app title="Manage Project Categories">
    <div class="space-y-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.projects.index') }}" class="p-2 rounded-xl bg-white dark:bg-surface-800 border border-gray-100 dark:border-white/10 text-gray-500 hover:text-brand-500 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Project Categories</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Manage project categories for better organization.</p>
                </div>
            </div>
            <button onclick="openModal('create')" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Category</span>
            </button>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
            <div class="glass-card overflow-hidden group h-full flex flex-col">
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-brand-500 to-brand-700">
                    <div class="w-full h-full flex items-center justify-center text-white/30">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold @if($category->is_active) bg-green-500 text-white @else bg-gray-500 text-white @endif">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="p-6 space-y-4 flex-1 flex flex-col">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit truncate">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-white/10 mt-auto">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Order: {{ $category->order }}
                        </span>
                        <div class="flex items-center gap-2">
                            <button onclick="openModal('edit', {{ $category->id }}, '{{ $category->name }}', '{{ $category->description ?? '' }}', {{ $category->is_active ? 'true' : 'false' }}, {{ $category->order }})" class="text-brand-500 hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2h2.828l2.758-2.758a2 2 0 012.828 0z"></path>
                                </svg>
                            </button>
                            <form action="{{ route('admin.project-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 011-1h2a1 1 0 011 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-surface-800 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Categories Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first project category.</p>
                <button onclick="openModal('create')" class="inline-flex items-center px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition">
                    Create Category
                </button>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4" style="display: none !important;">
        <div class="bg-white dark:bg-surface-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 dark:border-white/10">
                <div class="flex items-center justify-between">
                    <h2 id="modalTitle" class="text-xl font-bold text-gray-900 dark:text-white font-outfit">Create Category</h2>
                    <button onclick="closeModal()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-surface-800 transition">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <form id="categoryForm" action="{{ route('admin.project-categories.store') }}" method="POST" class="p-6 space-y-4">
                <input type="hidden" id="categoryId" name="id">
                <input type="hidden" id="formMethod" name="_method" value="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Display Order</label>
                        <input type="number" name="order" id="order" value="0" min="0"
                            class="w-full px-4 py-2.5 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-white/10 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 outline-none transition-all dark:text-white placeholder-gray-400">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox" name="is_active" id="is_active" checked
                            class="w-5 h-5 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <label for="is_active" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active</label>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 dark:border-white/10 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-gray-100 dark:bg-surface-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-surface-600 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0">
                        <span id="submitButtonText">Create Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            function openModal(mode, id = null, name = '', description = '', isActive = true, order = 0) {
                console.log('Opening modal in mode:', mode);
                const modal = document.getElementById('categoryModal');
                const title = document.getElementById('modalTitle');
                const submitBtnText = document.getElementById('submitButtonText');
                const categoryId = document.getElementById('categoryId');
                const formMethod = document.getElementById('formMethod');
                const form = document.getElementById('categoryForm');

                // Reset form
                form.reset();

                if (mode === 'create') {
                    title.textContent = 'Create Project Category';
                    submitBtnText.textContent = 'Create Category';
                    categoryId.value = '';
                    formMethod.value = 'POST';
                    form.action = "{{ route('admin.project-categories.store') }}";
                    form.method = 'POST';
                    document.getElementById('is_active').checked = true;
                    document.getElementById('order').value = '0';
                } else if (mode === 'edit') {
                    title.textContent = 'Edit Project Category';
                    submitBtnText.textContent = 'Update Category';
                    categoryId.value = id;
                    formMethod.value = 'PUT';
                    form.action = "{{ route('admin.project-categories.update', ':id') }}".replace(':id', id);
                    form.method = 'POST';
                    document.getElementById('name').value = name;
                    document.getElementById('description').value = description;
                    document.getElementById('is_active').checked = isActive;
                    document.getElementById('order').value = order;
                }

                modal.style.display = 'flex';
                modal.classList.remove('hidden');
                console.log('Modal opened:', modal.style.display);
            }

            function closeModal() {
                console.log('Closing modal');
                const modal = document.getElementById('categoryModal');
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });

            // Close modal on backdrop click
            document.addEventListener('click', function(e) {
                const modal = document.getElementById('categoryModal');
                if (e.target === modal) {
                    closeModal();
                }
            });
        </script>
    </x-slot:scripts>

</x-layouts.app>
