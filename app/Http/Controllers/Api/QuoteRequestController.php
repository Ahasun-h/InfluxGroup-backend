<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QuoteRequestController extends Controller
{
    /**
     * Submit a new quote request (public API).
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'requirements' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $quoteRequest = QuoteRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'requirements' => $request->requirements,
            'status' => 'pending',
        ]);

        // Send notification email to admin
        try {
            Mail::to(config('mail.admin_address', 'admin@influxgroup.com'))
                ->send(new \App\Mail\QuoteRequestSubmitted($quoteRequest));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send quote request email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Quote request submitted successfully',
            'data' => $quoteRequest
        ], 201);
    }

    /**
     * Get all quote requests (admin only).
     */
    public function index(Request $request)
    {
        $query = QuoteRequest::with('quotation');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('company', 'like', '%' . $searchTerm . '%');
            });
        }

        $quoteRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $quoteRequests
        ]);
    }

    /**
     * Get a specific quote request (admin only).
     */
    public function show(QuoteRequest $quoteRequest)
    {
        $quoteRequest->load('quotation');

        return response()->json([
            'success' => true,
            'data' => $quoteRequest
        ]);
    }

    /**
     * Update quote request status (admin only).
     */
    public function updateStatus(Request $request, QuoteRequest $quoteRequest)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,contacted,quoted,converted,closed',
            'admin_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $quoteRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $quoteRequest->admin_notes,
        ]);

        // Update timestamps based on status
        if ($request->status === 'contacted' && !$quoteRequest->contacted_at) {
            $quoteRequest->contacted_at = now();
        }
        if ($request->status === 'quoted' && !$quoteRequest->quoted_at) {
            $quoteRequest->quoted_at = now();
        }
        $quoteRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $quoteRequest
        ]);
    }

    /**
     * Convert quote request to quotation (admin only).
     */
    public function convertToQuotation(Request $request, QuoteRequest $quoteRequest)
    {
        $validator = Validator::make($request->all(), [
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date|after:quotation_date',
            'currency' => 'required|string|size:3',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

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
            'created_by' => auth()->id(),
        ]);

        // Update quote request
        $quoteRequest->update([
            'quotation_id' => $quotation->id,
            'status' => 'quoted',
            'quoted_at' => now(),
        ]);

        // Send quotation email to client
        try {
            Mail::to($quoteRequest->email)
                ->send(new \App\Mail\QuotationGenerated($quotation));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send quotation email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Quotation created successfully',
            'data' => [
                'quote_request' => $quoteRequest->load('quotation'),
                'quotation' => $quotation
            ]
        ], 201);
    }

    /**
     * Delete quote request (admin only).
     */
    public function destroy(QuoteRequest $quoteRequest)
    {
        $quoteRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quote request deleted successfully'
        ]);
    }
}
