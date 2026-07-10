<x-layouts.app title="Add Customer">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Add New Customer</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Create a new customer profile</p>
            </div>
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-surface-700 hover:bg-gray-200 dark:hover:bg-surface-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Customers
            </a>
        </div>

        <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Contact Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                    placeholder="John Doe">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                    placeholder="john@example.com">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                    placeholder="+1 234 567 8900">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company</label>
                                <input type="text" name="company" id="company" value="{{ old('company') }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                    placeholder="Acme Corp">
                                <x-input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                placeholder="123 Main St, City, Country">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Additional Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="industry" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Industry</label>
                                <input type="text" name="industry" id="industry" value="{{ old('industry') }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                    placeholder="Technology">
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>

                            <div>
                                <label for="source" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Source</label>
                                <select name="source" id="source"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="">Select Source</option>
                                    <option value="lead" {{ old('source') === 'lead' ? 'selected' : '' }}>Lead</option>
                                    <option value="quote_request" {{ old('source') === 'quote_request' ? 'selected' : '' }}>Quote Request</option>
                                    <option value="direct" {{ old('source') === 'direct' ? 'selected' : '' }}>Direct</option>
                                    <option value="referral" {{ old('source') === 'referral' ? 'selected' : '' }}>Referral</option>
                                </select>
                                <x-input-error :messages="$errors->get('source')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all"
                                placeholder="Additional notes about this customer...">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Assignment -->
                    <div class="glass-card p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status & Assignment</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="blocked" {{ old('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <label for="assigned_to" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Assign To</label>
                                <select name="assigned_to" id="assigned_to"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Create Customer
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
