<x-layouts.app title="Core Values Management">
    <div class="max-w-7xl mx-auto pb-20">
        <!-- Header/Actions -->
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-2xl font-display font-black uppercase italic text-industrial-dark dark:text-white">
                    Core <span class="text-industrial-blue">Values</span>
                </h1>
                <p class="text-sm text-slate-500 uppercase tracking-widest font-bold mt-1">Foundational Principles</p>
            </div>

            @if(session('success'))
                <div
                    class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-lg border border-green-100 animate-fade-in-down">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif
        </div>

        <form action="{{ route('admin.core-values.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hero Edit Section -->
            <div class="bg-industrial-dark p-12 rounded-3xl mb-12 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-industrial-blue/20 to-transparent"></div>
                <div class="relative z-10 max-w-2xl mx-auto text-center">
                    <input type="text" name="title" value="{{ $content['title'] }}"
                        class="w-full text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-white text-center bg-transparent border-none focus:ring-0 p-0 placeholder:text-white/20"
                        placeholder="CORE VALUES">

                    <textarea name="subtitle" rows="2"
                        class="w-full text-slate-400 text-lg text-center bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-slate-600"
                        placeholder="The principles that guide everything we do">{{ $content['subtitle'] }}</textarea>
                </div>
            </div>

            <!-- Values Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12" id="values-container">
                @foreach($values as $value)
                    <div
                        class="glass-panel p-8 rounded-2xl relative group/card border border-slate-100 dark:border-surface-700 bg-white dark:bg-surface-800 transition-all hover:-translate-y-2">
                        <!-- Delete Action -->
                        <button type="submit" name="delete_value" value="{{ $value['id'] }}"
                            class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity shadow-lg"
                            onclick="return confirm('Delete this core value?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-4">
                                <select name="values[{{ $value['id'] }}][icon]"
                                    class="bg-industrial-blue/10 text-industrial-blue p-2 rounded-lg border-none text-xs font-black focus:ring-1 focus:ring-industrial-blue">
                                    <option value="ShieldCheck" {{ $value['icon'] == 'ShieldCheck' ? 'selected' : '' }}>Shield
                                    </option>
                                    <option value="Award" {{ $value['icon'] == 'Award' ? 'selected' : '' }}>Award</option>
                                    <option value="Users" {{ $value['icon'] == 'Users' ? 'selected' : '' }}>Users</option>
                                    <option value="TrendingUp" {{ $value['icon'] == 'TrendingUp' ? 'selected' : '' }}>Trend
                                    </option>
                                    <option value="Zap" {{ $value['icon'] == 'Zap' ? 'selected' : '' }}>Zap</option>
                                </select>
                            </div>
                            <input type="text" name="values[{{ $value['id'] }}][title]" value="{{ $value['title'] }}"
                                class="w-full text-xl font-bold mb-3 text-industrial-dark dark:text-white bg-transparent border-none focus:ring-0 p-0 placeholder:text-slate-300"
                                placeholder="Value Title">
                            <textarea name="values[{{ $value['id'] }}][description]" rows="4"
                                class="w-full text-slate-500 dark:text-slate-400 text-sm leading-relaxed bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-slate-300"
                                placeholder="Value description...">{{ $value['description'] }}</textarea>
                        </div>
                    </div>
                @endforeach

                <!-- Add New Action -->
                <button type="button" onclick="addValue()"
                    class="border-2 border-dashed border-slate-200 dark:border-surface-700 rounded-2xl flex flex-col items-center justify-center p-8 hover:border-industrial-blue hover:bg-industrial-blue/5 transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-slate-50 dark:bg-surface-800 text-slate-400 flex items-center justify-center group-hover:bg-industrial-blue group-hover:text-white transition-all mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-industrial-blue transition-colors">Add
                        New Value</span>
                </button>
            </div>

            <!-- Deploy Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="group relative inline-flex items-center gap-4 px-12 py-5 bg-industrial-blue text-white rounded-2xl font-display font-black uppercase italic tracking-widest text-lg shadow-2xl shadow-industrial-blue/30 hover:bg-industrial-dark transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Deploy Changes
                    </span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                    </div>
                </button>
            </div>
        </form>
    </div>

    <style>
        .font-display {
            font-family: 'Outfit', sans-serif;
        }

        .text-industrial-blue {
            color: #0055ff;
        }

        .bg-industrial-blue {
            background-color: #0055ff;
        }

        .text-industrial-dark {
            color: #1a1a1a;
        }

        .bg-industrial-dark {
            background-color: #1a1a1a;
        }

        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>

    <script>
        let nextId = {{ count($values) + 1 }};

        function addValue() {
            const container = document.getElementById('values-container');
            const addButton = container.lastElementChild;

            const div = document.createElement('div');
            div.className = 'glass-panel p-8 rounded-2xl relative group/card border border-slate-100 dark:border-surface-700 bg-white dark:bg-surface-800 transition-all hover:-translate-y-2 animate-fade-in-down';
            div.innerHTML = `
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-4">
                <select name="values[${nextId}][icon]" class="bg-industrial-blue/10 text-industrial-blue p-2 rounded-lg border-none text-xs font-black focus:ring-1 focus:ring-industrial-blue">
                    <option value="ShieldCheck">Shield</option>
                    <option value="Award">Award</option>
                    <option value="Users">Users</option>
                    <option value="TrendingUp">Trend</option>
                    <option value="Zap">Zap</option>
                </select>
            </div>
            <input type="text" name="values[${nextId}][title]" class="w-full text-xl font-bold mb-3 text-industrial-dark dark:text-white bg-transparent border-none focus:ring-0 p-0 placeholder:text-slate-300" placeholder="Value Title">
            <textarea name="values[${nextId}][description]" rows="4" class="w-full text-slate-500 dark:text-slate-400 text-sm leading-relaxed bg-transparent border-none focus:ring-0 p-0 resize-none placeholder:text-slate-300" placeholder="Value description..."></textarea>
        </div>
    `;

            container.insertBefore(div, addButton);
            div.querySelector('input').focus();
            nextId++;
        }
    </script>
</x-layouts.app>