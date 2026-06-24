<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use PDF;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations.
     */
    public function index(Request $request): View
    {
        $query = Quotation::with(['creator', 'quotationItems']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by client name or quotation number
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('client_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('quotation_number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('client_company', 'like', '%' . $searchTerm . '%');
            });
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Quotation::count(),
            'draft' => Quotation::where('status', 'draft')->count(),
            'sent' => Quotation::where('status', 'sent')->count(),
            'accepted' => Quotation::where('status', 'accepted')->count(),
        ];

        // Get pending quote requests
        $pendingQuoteRequests = \App\Models\QuoteRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.quotations.index', compact('quotations', 'stats', 'pendingQuoteRequests'));
    }

    /**
     * Show the form for creating a new quotation.
     */
    public function create(): View
    {
        $products = Product::active()->get();
        $quotationNumber = Quotation::generateQuotationNumber();
        $currencies = ['USD', 'EUR', 'GBP', 'BDT', 'INR'];

        return view('admin.quotations.create', compact('products', 'quotationNumber', 'currencies'));
    }

    /**
     * Store a newly created quotation in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_company' => 'nullable|string|max:255',
            'client_address' => 'nullable|string',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date|after:quotation_date',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
        ]);

        $quotation = Quotation::create([
            'quotation_number' => Quotation::generateQuotationNumber(),
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_company' => $request->client_company,
            'client_address' => $request->client_address,
            'quotation_date' => $request->quotation_date,
            'valid_until' => $request->valid_until,
            'currency' => $request->currency,
            'tax_percentage' => $request->tax_percentage ?? 0,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'notes' => $request->notes,
            'terms_and_conditions' => $request->terms_and_conditions,
            'status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        // Add items to quotation
        foreach ($request->items as $index => $item) {
            $totalPrice = $item['quantity'] * $item['unit_price'];

            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'item_type' => $item['type'] ?? 'custom',
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $totalPrice,
                'specifications' => $item['specifications'] ?? null,
                'sort_order' => $index,
            ]);
        }

        // Calculate totals
        $quotation->calculateTotals()->save();

        return redirect()->route('admin.quotations.show', $quotation->id)
            ->with('success', 'Quotation created successfully.');
    }

    /**
     * Display the specified quotation.
     */
    public function show(Quotation $quotation): View
    {
        $quotation->load(['creator', 'quotationItems.product']);

        return view('admin.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation.
     */
    public function edit(Quotation $quotation): View
    {
        if ($quotation->status === 'accepted' || $quotation->status === 'rejected') {
            return redirect()->route('admin.quotations.show', $quotation->id)
                ->with('error', 'Cannot edit ' . $quotation->status . ' quotations.');
        }

        $quotation->load(['quotationItems.product']);
        $products = Product::active()->get();
        $currencies = ['USD', 'EUR', 'GBP', 'BDT', 'INR'];

        return view('admin.quotations.edit', compact('quotation', 'products', 'currencies'));
    }

    /**
     * Update the specified quotation in storage.
     */
    public function update(Request $request, Quotation $quotation): RedirectResponse
    {
        if ($quotation->status === 'accepted' || $quotation->status === 'rejected') {
            return redirect()->route('admin.quotations.show', $quotation->id)
                ->with('error', 'Cannot update ' . $quotation->status . ' quotations.');
        }

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_company' => 'nullable|string|max:255',
            'client_address' => 'nullable|string',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date|after:quotation_date',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
        ]);

        $quotation->update([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_company' => $request->client_company,
            'client_address' => $request->client_address,
            'quotation_date' => $request->quotation_date,
            'valid_until' => $request->valid_until,
            'currency' => $request->currency,
            'tax_percentage' => $request->tax_percentage ?? 0,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'notes' => $request->notes,
            'terms_and_conditions' => $request->terms_and_conditions,
        ]);

        // Delete existing items
        $quotation->quotationItems()->delete();

        // Add updated items
        foreach ($request->items as $index => $item) {
            $totalPrice = $item['quantity'] * $item['unit_price'];

            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'item_type' => $item['type'] ?? 'custom',
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $totalPrice,
                'specifications' => $item['specifications'] ?? null,
                'sort_order' => $index,
            ]);
        }

        // Recalculate totals
        $quotation->calculateTotals()->save();

        return redirect()->route('admin.quotations.show', $quotation->id)
            ->with('success', 'Quotation updated successfully.');
    }

    /**
     * Update quotation status.
     */
    public function updateStatus(Request $request, Quotation $quotation): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected,expired',
        ]);

        $quotation->update(['status' => $request->status]);

        return redirect()->route('admin.quotations.show', $quotation->id)
            ->with('success', 'Quotation status updated successfully.');
    }

    /**
     * Remove the specified quotation from storage.
     */
    public function destroy(Quotation $quotation): RedirectResponse
    {
        if ($quotation->status === 'accepted') {
            return redirect()->route('admin.quotations.index')
                ->with('error', 'Cannot delete accepted quotations.');
        }

        $quotation->quotationItems()->delete();
        $quotation->delete();

        return redirect()->route('admin.quotations.index')
            ->with('success', 'Quotation deleted successfully.');
    }

    /**
     * Generate PDF for the quotation.
     */
    public function generatePDF(Quotation $quotation)
    {
        $quotation->load(['creator', 'quotationItems.product']);

        $pdf = PDF::loadView('admin.quotations.pdf', compact('quotation'));

        return $pdf->download($quotation->quotation_number . '.pdf');
    }

    /**
     * Duplicate a quotation.
     */
    public function duplicate(Quotation $quotation): RedirectResponse
    {
        $quotation->load(['quotationItems']);

        $newQuotation = Quotation::create([
            'quotation_number' => Quotation::generateQuotationNumber(),
            'client_name' => $quotation->client_name,
            'client_email' => $quotation->client_email,
            'client_phone' => $quotation->client_phone,
            'client_company' => $quotation->client_company,
            'client_address' => $quotation->client_address,
            'quotation_date' => now(),
            'valid_until' => $quotation->valid_until,
            'currency' => $quotation->currency,
            'tax_percentage' => $quotation->tax_percentage,
            'discount_percentage' => $quotation->discount_percentage,
            'notes' => $quotation->notes,
            'terms_and_conditions' => $quotation->terms_and_conditions,
            'status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        // Copy items
        foreach ($quotation->quotationItems as $item) {
            QuotationItem::create([
                'quotation_id' => $newQuotation->id,
                'item_type' => $item->item_type,
                'product_id' => $item->product_id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'specifications' => $item->specifications,
                'sort_order' => $item->sort_order,
            ]);
        }

        // Calculate totals
        $newQuotation->calculateTotals()->save();

        return redirect()->route('admin.quotations.edit', $newQuotation->id)
            ->with('success', 'Quotation duplicated successfully.');
    }
}