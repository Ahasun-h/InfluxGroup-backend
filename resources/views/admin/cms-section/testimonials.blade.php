<x-layouts.app title="Testimonials Management">
    <x-slot:styles>
        <style>
            .testimonial-card {
                transition: all 0.2s ease;
                border: 1px solid #e5e7eb;
            }

            .testimonial-card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }

            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                padding: 1rem;
            }

            .modal-overlay.active {
                display: flex;
            }

            .modal-content {
                background: white;
                dark:bg-surface-800;
                border-radius: 1rem;
                padding: 2rem;
                max-width: 600px;
                width: 100%;
                max-height: 90vh;
                overflow-y: auto;
                position: relative;
                z-index: 10000;
            }

            .rating-star {
                cursor: pointer;
                transition: color 0.2s;
            }

            .rating-star.active {
                color: #fbbf24;
            }

            .rating-star:not(.active) {
                color: #d1d5db;
            }

            .rating-star:hover {
                color: #fbbf24;
            }
        </style>
    </x-slot:styles>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Testimonials Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Manage client testimonials and section content</p>
            </div>
            <button onclick="window.openModal()" class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Testimonial
            </button>
        </div>

        <!-- Section Content -->
        <div class="glass-card p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Section Content</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Edit the testimonials section header content</p>
                </div>
            </div>

            <form action="{{ route('admin.testimonials.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle"
                            value="{{ old('subtitle', $sectionItems['testimonials_subtitle']->section_content ?? 'Testimonials') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                            placeholder="Testimonials">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $sectionItems['testimonials_title']->section_content ?? 'What Our Clients Say') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                            placeholder="What Our Clients Say">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none">{{ old('description', $sectionItems['testimonials_description']->section_content ?? 'Trusted by leading organizations across Bangladesh and beyond') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                        Save Section Content
                    </button>
                </div>
            </form>
        </div>

        <!-- Testimonials List -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Testimonials ({{ count($testimonialsData) }})</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage your client testimonials</p>
                    </div>
                </div>
            </div>

            @if(empty($testimonialsData))
                <div class="text-center py-16 bg-gray-50 dark:bg-surface-800 rounded-xl">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-200 dark:bg-surface-700 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No testimonials yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Add your first client testimonial to get started</p>
                    <button onclick="window.openModal()" class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                        + Add First Testimonial
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    @foreach($testimonialsData as $testimonial)
                        <div class="testimonial-card bg-white dark:bg-surface-800 rounded-xl p-6 relative">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($testimonial['rating'] ?? 5))
                                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <div class="flex gap-2">
                                    <button onclick='window.editTestimonial({{ json_encode($testimonial) }})' class="text-brand-500 hover:text-brand-600 p-1 rounded-lg hover:bg-brand-50 dark:hover:bg-brand-900/20 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial['id']) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-surface-700 rounded-lg p-4 mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed italic">
                                    "{{ $testimonial['content'] }}"
                                </p>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="font-semibold text-gray-900 dark:text-white">{{ $testimonial['name'] }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $testimonial['position'] }}</div>
                                <div class="text-xs text-brand-500 font-medium mt-1">{{ $testimonial['company'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="testimonialModal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white" id="modalTitle">Add Testimonial</h2>
                <button onclick="window.closeModal()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="testimonialForm" action="{{ route('admin.testimonials.store') }}" method="POST">
                @csrf
                <input type="hidden" id="testimonialId" name="testimonial_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Testimonial Content</label>
                        <textarea name="content" id="content" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none" required placeholder="Enter testimonial text..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" required placeholder="John Doe">
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Position</label>
                            <input type="text" name="position" id="position" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" required placeholder="CEO">
                        </div>
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company</label>
                        <input type="text" name="company" id="company" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" required placeholder="Company Name">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                        <div class="flex gap-2 items-center" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="hidden" {{ $i === 5 ? 'checked' : '' }}>
                                <label for="rating{{ $i }}" class="rating-star text-2xl" data-rating="{{ $i }}">
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="window.closeModal()" class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                        Save Testimonial
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Make functions globally available
        window.openModal = function() {
            const modal = document.getElementById('testimonialModal');
            if (modal) {
                modal.classList.add('active');
                document.getElementById('modalTitle').textContent = 'Add Testimonial';
                document.getElementById('testimonialForm').action = '{{ route('admin.testimonials.store') }}';
                document.getElementById('testimonialForm').reset();
                document.getElementById('testimonialId').value = '';
                // Reset to 5 stars
                document.querySelectorAll('input[name="rating"]').forEach(input => {
                    input.checked = input.value === '5';
                });
                window.updateStars(5);
            }
        };

        window.closeModal = function() {
            const modal = document.getElementById('testimonialModal');
            if (modal) {
                modal.classList.remove('active');
            }
        };

        window.editTestimonial = function(testimonial) {
            const modal = document.getElementById('testimonialModal');
            if (modal) {
                modal.classList.add('active');
                document.getElementById('modalTitle').textContent = 'Edit Testimonial';
                document.getElementById('testimonialForm').action = '{{ route('admin.testimonials.update-testimonial', ':id') }}'.replace(':id', testimonial.id);
                document.getElementById('testimonialId').value = testimonial.id;
                document.getElementById('content').value = testimonial.content;
                document.getElementById('name').value = testimonial.name;
                document.getElementById('position').value = testimonial.position;
                document.getElementById('company').value = testimonial.company;

                // Set rating
                document.querySelectorAll('input[name="rating"]').forEach(input => {
                    input.checked = parseInt(input.value) === parseInt(testimonial.rating);
                });
                window.updateStars(parseInt(testimonial.rating));
            }
        };

        window.updateStars = function(rating) {
            document.querySelectorAll('.rating-star').forEach(star => {
                const starRating = parseInt(star.dataset.rating);
                if (starRating <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        };

        // Initialize event listeners when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal when clicking outside
            const modal = document.getElementById('testimonialModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        window.closeModal();
                    }
                });

                // Handle star rating clicks
                document.querySelectorAll('.rating-star').forEach(star => {
                    star.addEventListener('click', function(e) {
                        e.preventDefault();
                        const rating = parseInt(this.dataset.rating);
                        window.updateStars(rating);
                        document.getElementById('rating' + rating).checked = true;
                    });
                });

                // Initialize stars with default rating
                window.updateStars(5);
            }

            // Handle ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    window.closeModal();
                }
            });
        });
    </script>
</x-layouts.app>