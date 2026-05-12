<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Auth</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased selection:bg-brand-500 selection:text-white relative overflow-hidden bg-gray-50 dark:bg-surface-900 min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Background Gradient Effects -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-brand-500/10 blur-[120px] animate-[float_6s_ease-in-out_infinite_alternate]"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] rounded-full bg-purple-500/10 blur-[100px] animate-[float_8s_ease-in-out_infinite_alternate-reverse]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md animate-[fadeInUp_0.5s_ease-out]">
        <div class="mb-8 flex justify-center">
            <a href="/" class="flex items-center gap-2">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-3xl font-bold font-outfit text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400 dark:from-brand-300 dark:to-brand-500">
                    Influx
                </span>
            </a>
        </div>

        <div class="glass-card w-full p-8 relative overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
