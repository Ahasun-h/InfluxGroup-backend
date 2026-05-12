<header class="sticky top-0 z-30 glass border-b px-4 md:px-8 lg:px-10 py-4 flex items-center justify-between transition-colors duration-300">
    <div class="flex items-center gap-4 flex-1">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Search Input -->
        <div class="hidden sm:flex items-center relative w-full max-w-md">
            <svg class="w-5 h-5 absolute left-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" placeholder="Search anything..." class="w-full pl-10 pr-4 py-2 bg-gray-100 border-none rounded-xl focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all text-sm outline-none placeholder-gray-400">
        </div>
    </div>

    <div class="flex items-center gap-4 sm:gap-6">
        <!-- Dark Mode Toggle -->
        <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-brand-500 transition-colors">
            <!-- Sun Icon (Hidden in dark mode) -->
            <svg class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <!-- Moon Icon (Hidden in light mode) -->
            <svg class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <!-- Notifications -->
        <button class="relative text-gray-500 hover:text-brand-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
        </button>

        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>

        <!-- User Profile -->
        <!-- User Profile -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 cursor-pointer group focus:outline-none">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin User') }}&background=14b8a6&color=fff" alt="User Profile" class="w-9 h-9 rounded-full ring-2 ring-transparent group-hover:ring-brand-500 transition-all">
                <div class="hidden sm:block text-left">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email ?? 'admin@influx.com' }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 hidden sm:block transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-surface-800 rounded-xl shadow-lg border border-gray-100 dark:border-white/10 py-1 z-50 hidden"
                 :class="{'hidden': !open}">
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-colors">
                    Profile
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
