<x-layouts.app title="Convert Quote Request to Quotation">
    <x-slot:styles>
        <style>
            .item-row {
                transition: all 0.2s ease;
            }
            .item-row:hover {
                background-color: rgba(0, 102, 204, 0.05);
            }
        </style>
    </x-slot:styles>

    <div class="space-y-8 pb-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Convert to Quotation
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Create quotation from quote request #{{ $quoteRequest->id }}</p>
            </div>
            <a href="{{ route('admin.quote-requests.show', $quoteRequest) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
        </div>

        <!-- Quote Request Summary -->
        <div class="glass-card p-6 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Quote Request Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Client:</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Email:</p>
                            <p class="text-gray-900 dark:text-white">{{ $quoteRequest->email }}</p>
                        </div>
                        @if($quoteRequest->company)
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Company:</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quoteRequest->company }}</p>
                            </div>
                        @endif
                        @if($quoteRequest->phone)
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Phone:</p>
                                <p class="text-gray-900 dark:text-white">{{ $quoteRequest->phone }}</p>
                            </div>
                        @endif
                    </div>
                    @if($quoteRequest->requirements)
                        <div class="mt-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Requirements:</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $quoteRequest->requirements }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('admin.quote-requests.store-quotation', $quoteRequest) }}" method="POST" id="quotationForm">
            @csrf

            <!-- Client Information (Pre-filled) -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Client Information</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pre-filled from quote request</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
                        <input type="text" name="client_name" value="{{ $quoteRequest->name }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="client_email" value="{{ $quoteRequest->email }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                        <input type="text" name="client_phone" value="{{ $quoteRequest->phone }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company</label>
                        <input type="text" name="client_company" value="{{ $quoteRequest->company }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Quotation Details -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Quotation Details</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Set quotation parameters</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Quotation Number</label>
                        <input type="text" value="{{ \App\Models\Quotation::generateQuotationNumber() }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Quotation Date *</label>
                        <input type="date" name="quotation_date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Valid Until</label>
                        <input type="date" name="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Currency *</label>
                        <select name="currency" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" {{ $currency === 'USD' ? 'selected' : '' }}>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tax (%)</label>
                        <input type="number" name="tax_percentage" value="0" min="0" max="100" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Discount (%)</label>
                        <input type="number" name="discount_percentage" value="0" min="0" max="100" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>

            <!-- Line Items -->
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Line Items</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Add products or services based on the requirements</p>
                        </div>
                    </div>
                    <button type="button" onclick="addItem()" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl font-semibold transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Item
                    </button>
                </div>

                <div id="itemsContainer" class="space-y-4">
                    <!-- Items will be added here dynamically -->
                </div>

                <div id="noItems" class="text-center py-12 bg-gray-50 dark:bg-surface-800 rounded-xl">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No items added</h3>
                    <p class="text-gray-500 dark:text-gray-400">Add line items based on the client's requirements above</p>
                </div>
            </div>

            <!-- Notes & Terms -->
            <div class="glass-card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Notes & Terms</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Additional information</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                        <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none" placeholder="Any additional notes for the client..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Terms & Conditions</label>
                        <textarea name="terms_and_conditions" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none" placeholder="Terms and conditions..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.quote-requests.show', $quoteRequest) }}" class="px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-surface-700 transition-all">
                    Cancel
                </a>
                <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg shadow-brand-500/30">
                    Create & Send Quotation
                </button>
            </div>
        </form>
    </div>

    <script>
        let itemCount = 0;

        function addItem() {
            itemCount++;
            const container = document.getElementById('itemsContainer');
            const noItems = document.getElementById('noItems');

            if (noItems) {
                noItems.style.display = 'none';
            }

            const itemHtml = `
                <div class="item-row bg-white dark:bg-surface-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700" id="item-${itemCount}">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Item #${itemCount}</h3>
                        <button type="button" onclick="removeItem(${itemCount})" class="text-red-500 hover:text-red-600 p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                            <textarea name="items[${itemCount}][description]" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all resize-none" placeholder="Item description..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Quantity *</label>
                            <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" required oninput="calculateItemTotal(${itemCount})" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Unit Price *</label>
                            <input type="number" name="items[${itemCount}][unit_price]" value="0" min="0" step="0.01" required oninput="calculateItemTotal(${itemCount})" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Total</label>
                            <input type="text" id="total-${itemCount}" value="0.00" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-surface-700 text-gray-900 dark:text-white font-semibold">
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', itemHtml);
        }

        function removeItem(id) {
            const item = document.getElementById(`item-${id}`);
            if (item) {
                item.remove();
            }

            const container = document.getElementById('itemsContainer');
            if (container.children.length === 0) {
                const noItems = document.getElementById('noItems');
                if (noItems) {
                    noItems.style.display = 'block';
                }
            }
        }

        function calculateItemTotal(id) {
            const quantity = parseFloat(document.querySelector(\`input[name="items[\${id}][quantity]"]\`).value) || 0;
            const unitPrice = parseFloat(document.querySelector(\`input[name="items[\${id}][unit_price]"]\`).value) || 0;
            const total = quantity * unitPrice;

            document.getElementById(\`total-\${id}\`).value = total.toFixed(2);
        }

        // Add first item on page load
        document.addEventListener('DOMContentLoaded', function() {
            addItem();
        });
    </script>
</x-layouts.app>