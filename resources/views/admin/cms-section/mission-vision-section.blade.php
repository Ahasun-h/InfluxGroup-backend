<x-layouts.app title="Mission & Vision Management">

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Mission & <span class="text-industrial-blue">Vision</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Customize your website Mission & Vision section from here</p>
            </div>
        </div>

        <!-- Live Preview Section -->
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Live Preview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Click on any text to edit it directly</p>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          Home Page
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                          About Page
                    </span>
                </div>
            </div>

            <form action="{{ route('admin.mission-vision.update') }}" method="POST" id="mv-form">
                @csrf
                @method('PUT')

                <!-- Section Design: Matches Home.vue exactly -->
                <section class="py-16 px-8 bg-white dark:bg-surface-800 rounded-3xl shadow-2xl border border-slate-100 dark:border-surface-700 transition-all duration-500">
                    <div class="grid md:grid-cols-2 gap-20">

                        <!-- Mission Item -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-4 mb-8 group">
                                <div class="w-12 h-12 rounded-xl bg-industrial-blue/10 flex items-center justify-center text-industrial-blue group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="mission[title]" value="{{ $mvItems['mission']['title'] }}"
                                           class="w-full text-3xl md:text-4xl font-display font-black uppercase italic dark:text-white bg-transparent border-none focus:ring-0 p-0 placeholder:text-slate-300"
                                           placeholder="OUR MISSION">
                                    <div class="h-1.5 w-24 bg-industrial-blue mt-2 rounded-full"></div>
                                </div>
                            </div>

                            <div class="relative group">
                                <label class="absolute -top-6 left-0 text-[10px] font-black uppercase tracking-widest text-industrial-blue opacity-0 group-hover:opacity-100 transition-opacity">Core Description</label>
                                <textarea name="mission[description]" rows="4"
                                          class="w-full text-base md:text-lg text-slate-600 dark:text-slate-300 leading-relaxed bg-transparent border-none focus:ring-0 p-0 resize-none"
                                          placeholder="Describe your mission...">{{ $mvItems['mission']['description'] }}</textarea>
                            </div>

                            <div class="space-y-4 pt-8 border-t border-slate-50 dark:border-surface-700">
                                <div class="flex items-center justify-between mb-4">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Strategic Points</label>
                                </div>

                                <ul id="mission-points-container" class="space-y-6">
                                    @foreach($mvItems['mission']['points'] as $index => $point)
                                        <li class="flex items-start gap-4 group/point relative">
                                            <div class="mt-1 w-6 h-6 rounded-full bg-industrial-blue/10 text-industrial-blue flex items-center justify-center flex-shrink-0 group-hover/point:bg-industrial-blue group-hover/point:text-white transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <input type="text" name="mission[points][]" value="{{ $point }}"
                                                   class="flex-1 text-slate-700 dark:text-slate-300 bg-transparent border-none focus:ring-0 p-0 text-base"
                                                   placeholder="Add a point...">
                                            <button type="button" onclick="this.parentElement.remove()"
                                                    class="opacity-0 group-hover/point:opacity-100 absolute -right-8 top-1/2 -translate-y-1/2 p-2 text-slate-300 hover:text-red-500 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <button type="button" onclick="addPoint('mission')"
                                        class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-industrial-blue hover:text-industrial-blue/80 transition-all bg-industrial-blue/5 px-4 py-2 rounded-lg hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Objective
                                </button>
                            </div>
                        </div>

                        <!-- Vision Item -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-4 mb-8 group">
                                <div class="w-12 h-12 rounded-xl bg-industrial-blue/10 flex items-center justify-center text-industrial-blue group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="vision[title]" value="{{ $mvItems['vision']['title'] }}"
                                           class="w-full text-3xl md:text-4xl font-display font-black uppercase italic dark:text-white bg-transparent border-none focus:ring-0 p-0 placeholder:text-slate-300"
                                           placeholder="OUR VISION">
                                    <div class="h-1.5 w-24 bg-industrial-blue mt-2 rounded-full"></div>
                                </div>
                            </div>

                            <div class="relative group">
                                <label class="absolute -top-6 left-0 text-[10px] font-black uppercase tracking-widest text-industrial-blue opacity-0 group-hover:opacity-100 transition-opacity">Future Roadmap</label>
                                <textarea name="vision[description]" rows="4"
                                          class="w-full text-base md:text-lg text-slate-600 dark:text-slate-300 leading-relaxed bg-transparent border-none focus:ring-0 p-0 resize-none"
                                          placeholder="Describe your vision...">{{ $mvItems['vision']['description'] }}</textarea>
                            </div>

                            <div class="space-y-4 pt-8 border-t border-slate-50 dark:border-surface-700">
                                <div class="flex items-center justify-between mb-4">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Future Milestones</label>
                                </div>

                                <ul id="vision-points-container" class="space-y-6">
                                    @foreach($mvItems['vision']['points'] as $index => $point)
                                        <li class="flex items-start gap-4 group/point relative">
                                            <div class="mt-1 w-6 h-6 rounded-full bg-industrial-blue/10 text-industrial-blue flex items-center justify-center flex-shrink-0 group-hover/point:bg-industrial-blue group-hover/point:text-white transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <input type="text" name="vision[points][]" value="{{ $point }}"
                                                   class="flex-1 text-slate-700 dark:text-slate-300 bg-transparent border-none focus:ring-0 p-0 text-base"
                                                   placeholder="Add a milestone...">
                                            <button type="button" onclick="this.parentElement.remove()"
                                                    class="opacity-0 group-hover/point:opacity-100 absolute -right-8 top-1/2 -translate-y-1/2 p-2 text-slate-300 hover:text-red-500 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <button type="button" onclick="addPoint('vision')"
                                        class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-industrial-blue hover:text-industrial-blue/80 transition-all bg-industrial-blue/5 px-4 py-2 rounded-lg hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Milestone
                                </button>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Save Action -->
                <div class="mt-12 flex justify-end">
                    <button type="submit"
                            class="group relative inline-flex items-center gap-4 px-12 py-5 bg-industrial-blue text-white rounded-2xl font-display font-black uppercase italic tracking-widest text-lg shadow-2xl shadow-industrial-blue/30 hover:bg-industrial-dark transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Push to Production
                    </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </button>
                </div>
            </form>

        </div>


    </div>

    <x-slot:styles>
        <style>
            .font-display { font-family: 'Outfit', sans-serif; }
            .text-industrial-blue { color: #0055ff; }
            .bg-industrial-blue { background-color: #0055ff; }
            .text-industrial-dark { color: #1a1a1a; }

            @keyframes fade-in-down {
                0% { opacity: 0; transform: translateY(-10px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-down { animation: fade-in-down 0.5s ease-out; }
        </style>
    </x-slot:styles>

    <x-slot:scripts>
        <script>
            function addPoint(type) {
                const container = document.getElementById(`${type}-points-container`);
                const li = document.createElement('li');
                li.className = 'flex items-start gap-4 group/point relative animate-fade-in-down';
                li.innerHTML = `
                <div class="mt-1 w-6 h-6 rounded-full bg-industrial-blue/10 text-industrial-blue flex items-center justify-center flex-shrink-0 group-hover/point:bg-industrial-blue group-hover/point:text-white transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <input type="text" name="${type}[points][]" class="flex-1 text-slate-700 dark:text-slate-300 bg-transparent border-none focus:ring-0 p-0 text-base" placeholder="Add a point...">
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-slate-300 hover:text-red-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
                container.appendChild(li);
                li.querySelector('input').focus();
            }
        </script>
    </x-slot:scripts>

</x-layouts.app>


