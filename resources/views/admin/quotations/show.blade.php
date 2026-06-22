<x-layouts.app title="Quotation {{ $quotation->quotation_number }}">
    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">
                        {{ $quotation->quotation_number }}
                    </h1>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $quotation->status_badge_color }}">
                        {{ $quotation->status_label }}
                    </span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">
                    Created on {{ $quotation->created_at->format('F d, Y') }}
                    @if($quotation->creator)
                        by {{ $quotation->creator->name }}
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.quotations.pdf', $quotation) }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
                @if(in_array($quotation->status, ['draft', 'sent']))
                    <a href="{{ route('admin.quotations.edit', $quotation) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Quotation Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Client Information -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Client Information</h2>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->client_name }}</p>
                        </div>
                        @if($quotation->client_company)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Company</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->client_company }}</p>
                            </div>
                        @endif
                        @if($quotation->client_email)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                <p class="text-gray-900 dark:text-white">{{ $quotation->client_email }}</p>
                            </div>
                        @endif
                        @if($quotation->client_phone)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                <p class="text-gray-900 dark:text-white">{{ $quotation->client_phone }}</p>
                            </div>
                        @endif
                        @if($quotation->client_address)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                                <p class="text-gray-900 dark:text-white">{{ nl2br($quotation->client_address) }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Line Items -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Line Items</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-surface-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Description</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Unit Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($quotation->quotationItems as $index => $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->description }}</div>
                                            @if($item->specifications)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->specifications }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-900 dark:text-white">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900 dark:text-white">{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right font-semibold text-gray-900 dark:text-white">{{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($quotation->notes || $quotation->terms_and_conditions)
                <!-- Notes & Terms -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Additional Information</h2>
                    </div>

                    @if($quotation->notes)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes:</p>
                            <p class="text-gray-900 dark:text-white">{{ nl2br($quotation->notes) }}</p>
                        </div>
                    @endif

                    @if($quotation->terms_and_conditions)
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Terms & Conditions:</p>
                            <p class="text-gray-900 dark:text-white">{{ nl2br($quotation->terms_and_conditions) }}</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Right Column: Summary & Actions -->
            <div class="space-y-6">
                <!-- Quotation Details -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Details</h2>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Quotation Date</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->quotation_date->format('F d, Y') }}</p>
                        </div>
                        @if($quotation->valid_until)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Valid Until</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->valid_until->format('F d, Y') }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Currency</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->currency }}</p>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Totals</h2>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($quotation->subtotal, 2) }}</span>
                        </div>

                        @if($quotation->tax_percentage > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tax ({{ $quotation->tax_percentage }}%):</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($quotation->tax_amount, 2) }}</span>
                            </div>
                        @endif

                        @if($quotation->discount_percentage > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Discount ({{ $quotation->discount_percentage }}%):</span>
                                <span class="font-semibold text-green-600">-{{ number_format($quotation->discount_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="font-bold text-gray-900 dark:text-white">Total:</span>
                                <span class="font-bold text-xl text-brand-500">{{ number_format($quotation->total, 2) }} {{ $quotation->currency }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Management -->
                @if(in_array($quotation->status, ['draft', 'sent']))
                    <div class="glass-card p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Status</h2>
                        </div>

                        <form action="{{ route('admin.quotations.update-status', $quotation) }}" method="POST">
                            @csrf
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Update Status</label>
                                <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                                    <option value="draft" {{ $quotation->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ $quotation->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="accepted" {{ $quotation->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $quotation->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="expired" {{ $quotation->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                                <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-4 py-3 rounded-xl font-semibold transition-all mt-4">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Actions</h2>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('admin.quotations.pdf', $quotation) }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download PDF
                        </a>

                        @if(in_array($quotation->status, ['draft', 'sent']))
                            <a href="{{ route('admin.quotations.edit', $quotation) }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Quotation
                            </a>

                            <form action="{{ route('admin.quotations.duplicate', $quotation) }}" method="POST" class="inline" onsubmit="return confirm('Duplicate this quotation?');">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                    </svg>
                                    Duplicate Quotation
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.quotations.index') }}" class="flex items-center gap-2 w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>