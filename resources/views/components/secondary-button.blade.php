<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white dark:bg-surface-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-xl font-bold text-sm shadow-sm hover:bg-gray-50 dark:hover:bg-surface-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800 disabled:opacity-25 transition-all duration-200']) }}>
    {{ $slot }}
</button>
