<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of quote requests.
     */
    public function index(Request $request): View
    {
        $query = QuoteRequest::with('quotation');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by name, email, or company
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('company', 'like', '%' . $searchTerm . '%');
            });
        }

        $quoteRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => QuoteRequest::count(),
            'pending' => QuoteRequest::where('status', 'pending')->count(),
            'contacted' => QuoteRequest::where('status', 'contacted')->count(),
            'quoted' => QuoteRequest::where('status', 'quoted')->count(),
            'converted' => QuoteRequest::where('status', 'converted')->count(),
        ];

        return view('admin.quote-requests.index', compact('quoteRequests', 'stats'));
    }

    /**
     * Display the specified quote request.
     */
    public function show(QuoteRequest $quoteRequest): View
    {
        $quoteRequest->load('quotation');

        return view('admin.quote-requests.show', compact('quoteRequest'));
    }

    /**
     * Show the form for converting quote request to quotation.
     */
    public function convert(QuoteRequest $quoteRequest): View
    {
        if ($quoteRequest->quotation_id) {
            return redirect()->route('admin.quote-requests.show', $quoteRequest->id)
                ->with('info', 'This quote request has already been converted to a quotation.');
        }

        $currencies = ['USD', 'EUR', 'GBP', 'BDT', 'INR'];
        $products = \App\Models\Product::active()->get();

        return view('admin.quote-requests.convert', compact('quoteRequest', 'currencies', 'products'));
    }

    /**
     * Convert quote request to quotation.
     */
    public function storeQuotation(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        if ($quoteRequest->quotation_id) {
            return redirect()->route('admin.quote-requests.show', $quoteRequest->id)
                ->with('error', 'This quote request has already been converted to a quotation.');
        }

        $request->validate([
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

        // Create quotation from quote request
        $quotation = Quotation::create([
            'quotation_number' => Quotation::generateQuotationNumber(),
            'client_name' => $quoteRequest->name,
            'client_email' => $quoteRequest->email,
            'client_phone' => $quoteRequest->phone,
            'client_company' => $quoteRequest->company,
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

        // Update quote request
        $quoteRequest->update([
            'quotation_id' => $quotation->id,
            'status' => 'quoted',
            'quoted_at' => now(),
        ]);

        // Send quotation email to client
        try {
            \Mail::to($quoteRequest->email)
                ->send(new \App\Mail\QuotationGenerated($quotation));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send quotation email: ' . $e->getMessage());
        }

        return redirect()->route('admin.quote-requests.show', $quoteRequest->id)
            ->with('success', 'Quotation created successfully and sent to the client.');
    }

    /**
     * Update quote request status.
     */
    public function updateStatus(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,quoted,converted,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $quoteRequest->admin_notes,
        ];

        // Update timestamps based on status
        if ($request->status === 'contacted' && !$quoteRequest->contacted_at) {
            $updateData['contacted_at'] = now();
        }
        if ($request->status === 'quoted' && !$quoteRequest->quoted_at) {
            $updateData['quoted_at'] = now();
        }
        if ($request->status === 'converted') {
            $updateData['quoted_at'] = $updateData['quoted_at'] ?? now();
        }

        $quoteRequest->update($updateData);

        return redirect()->route('admin.quote-requests.show', $quoteRequest->id)
            ->with('success', 'Quote request status updated successfully.');
    }

    /**
     * Remove the specified quote request from storage.
     */
    public function destroy(QuoteRequest $quoteRequest): RedirectResponse
    {
        $quoteRequest->delete();

        return redirect()->route('admin.quote-requests.index')
            ->with('success', 'Quote request deleted successfully.');
    }
}