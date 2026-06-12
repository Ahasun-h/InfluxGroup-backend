<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $styles ?? '' }}

    <!-- Heroicons Script (Using unpkg for quick SVGs, though inline SVG is better, we will use inline SVGs) -->

    <script>
        // Simple dark mode toggle logic
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }

        // Apply theme on load
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{ $scripts ?? '' }}
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800 dark:bg-surface-900 dark:text-gray-100 selection:bg-brand-500 selection:text-white transition-colors duration-300" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden">
        </div>

        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content Wrapper -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Top Header -->
            <x-topbar />

            <!-- Main Content Area -->
            <main class="w-full grow p-4 md:p-8 lg:p-10 mt-2">
                <div class="max-w-8xl mx-auto w-full">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <footer class="max-w-8xl mx-auto w-full mt-10 pt-10 pb-6 border-t border-gray-100 dark:border-surface-700">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} Influx Group. All rights reserved.
                        </p>
                        <div class="flex items-center gap-6">
                            <a href="#" class="text-sm text-gray-500 hover:text-brand-500 transition-colors">Privacy Policy</a>
                            <a href="#" class="text-sm text-gray-500 hover:text-brand-500 transition-colors">Terms of Service</a>
                            <a href="#" class="text-sm text-gray-500 hover:text-brand-500 transition-colors">Help Center</a>
                        </div>
                    </div>
                </footer>
            </main>

        </div>
    </div>
</body>
</html>
