<x-layouts.app title="Profile Settings">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-outfit">Profile Settings</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your account information and security preferences.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Info & Password -->
            <div class="lg:col-span-2 space-y-8">
                <div class="glass-card p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="glass-card p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Right Column: Danger Zone -->
            <div class="space-y-8">
                <div class="glass-card p-6 sm:p-8 border-red-100 dark:border-red-900/30">
                    <div class="max-w-xl text-red-600">
                        <h3 class="text-lg font-bold font-outfit mb-4">Danger Zone</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

