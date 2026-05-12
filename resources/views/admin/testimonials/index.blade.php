<x-layouts.app title="Testimonials">
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit tracking-tight">Testimonials</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage client feedback and reviews.</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1 active:translate-y-0 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Testimonial</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($testimonials as $testimonial)
            <div class="glass-card p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-500/10 flex items-center justify-center text-brand-500 font-bold">
                        {{ substr($testimonial->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $testimonial->name }}</p>
                        <p class="text-xs text-gray-500">{{ $testimonial->position }} @ {{ $testimonial->company }}</p>
                    </div>
                    <div class="ml-auto flex text-yellow-400">
                        @for($i = 0; $i < $testimonial->rating; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 italic">"{{ $testimonial->content }}"</p>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-100 dark:border-white/5">
                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-gray-400 hover:text-brand-500 transition-all">Edit</a>
                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-all">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 glass-card text-center text-gray-500">No testimonials found.</div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
