@props(['title', 'value', 'trend' => 'up', 'percentage', 'color' => 'brand'])

@php
    $trendColor = $trend === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
    $trendBg = $trend === 'up' ? 'bg-green-50 dark:bg-green-500/10' : 'bg-red-50 dark:bg-red-500/10';
    $trendIcon = $trend === 'up' 
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>';
        
    $iconColors = [
        'brand' => 'bg-brand-500/10 text-brand-600 dark:text-brand-400',
        'purple' => 'bg-purple-500/10 text-purple-600 dark:text-purple-400',
        'blue' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
        'orange' => 'bg-orange-500/10 text-orange-600 dark:text-orange-400',
    ];
    $iconColorClass = $iconColors[$color] ?? $iconColors['brand'];
@endphp

<div class="glass-card p-7 relative overflow-hidden group hover:scale-[1.02] transition-all duration-500 shadow-xl shadow-black/5">
    <!-- Decorative background glow -->
    <div class="absolute -right-10 -top-10 w-32 h-32 bg-{{ $color }}-500/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>

    <div class="flex justify-between items-start mb-6 relative z-10">
        <div>
            <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">{{ $title }}</p>
            <h3 class="text-3xl font-black text-gray-900 dark:text-white font-outfit tracking-tight">{{ $value }}</h3>
        </div>
        <div class="p-3.5 rounded-2xl {{ $iconColorClass }} border border-{{ $color }}-500/10 shadow-sm">
            {{ $slot }}
        </div>
    </div>
    
    <div class="flex items-center gap-3 relative z-10">
        <div class="flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-black {{ $trendColor }} {{ $trendBg }} border border-{{ $trend === 'up' ? 'green' : 'red' }}-500/10">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $trendIcon !!}
            </svg>
            <span>{{ $percentage }}%</span>
        </div>
        <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500">vs last month</span>
    </div>
</div>

