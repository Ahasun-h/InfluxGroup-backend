<x-layouts.app title="Edit Customer">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Edit Customer</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Update customer information</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-surface-700 hover:bg-gray-200 dark:hover:bg-surface-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Customer
                </a>
                <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-surface-700 hover:bg-gray-200 dark:hover:bg-surface-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    List All
                </a>
            </div>
        </div>

        <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Contact Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company</label>
                                <input type="text" name="company" id="company" value="{{ old('company', $customer->company) }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">{{ old('address', $customer->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="glass-card p-6 sm:p-8 space-y-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Additional Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="industry" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Industry</label>
                                <input type="text" name="industry" id="industry" value="{{ old('industry', $customer->industry) }}"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>

                            <div>
                                <label for="source" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Source</label>
                                <select name="source" id="source"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="">Select Source</option>
                                    <option value="lead" {{ old('source', $customer->source) === 'lead' ? 'selected' : '' }}>Lead</option>
                                    <option value="quote_request" {{ old('source', $customer->source) === 'quote_request' ? 'selected' : '' }}>Quote Request</option>
                                    <option value="direct" {{ old('source', $customer->source) === 'direct' ? 'selected' : '' }}>Direct</option>
                                    <option value="referral" {{ old('source', $customer->source) === 'referral' ? 'selected' : '' }}>Referral</option>
                                </select>
                                <x-input-error :messages="$errors->get('source')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">{{ old('notes', $customer->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Stats -->
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Customer Stats</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Lifetime Value</span>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($customer->lifetime_value, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Orders</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($customer->total_orders) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">First Contact</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $customer->first_contact_at?->format('M d, Y') ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Last Contact</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $customer->last_contact_at?->format('M d, Y') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Assignment -->
                    <div class="glass-card p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status & Assignment</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="blocked" {{ old('status', $customer->status) === 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <label for="assigned_to" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Assign To</label>
                                <select name="assigned_to" id="assigned_to"
                                    class="w-full px-4 py-3 bg-gray-50/50 dark:bg-surface-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $customer->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-2">
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Customer
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
