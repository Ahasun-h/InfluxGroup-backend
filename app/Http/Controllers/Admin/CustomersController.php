<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\StoreInteractionRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\CustomerInteraction;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomersController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        try {
            $query = Customer::with(['assignedTo', 'lead']);

            // Search filter
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('company', 'like', '%' . $search . '%');
                });
            }

            // Status filter
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Assigned to filter
            if ($request->has('assigned_to') && $request->assigned_to) {
                $query->where('assigned_to', $request->assigned_to);
            }

            // Source filter
            if ($request->has('source') && $request->source) {
                $query->where('source', $request->source);
            }

            $customers = $query->latest()->paginate(10);

            // Statistics
            $stats = [
                'total' => Customer::count(),
                'active' => Customer::active()->count(),
                'new_this_month' => Customer::whereMonth('created_at', now()->month)->count(),
                'total_lifetime_value' => Customer::sum('lifetime_value'),
            ];

            $users = User::all();

            Log::info('Admin accessing customers page', [
                'total_customers' => $stats['total']
            ]);

            return view('admin.customers.index', compact('customers', 'stats', 'users'));

        } catch (\Exception $e) {
            Log::error('Error loading customers page: ' . $e->getMessage());

            return view('admin.customers.index', [
                'customers' => collect([]),
                'stats' => [
                    'total' => 0,
                    'active' => 0,
                    'new_this_month' => 0,
                    'total_lifetime_value' => 0,
                ],
                'users' => collect([])
            ]);
        }
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.customers.create', compact('users'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'address' => $request->address,
                'industry' => $request->industry,
                'status' => $request->status,
                'source' => $request->source,
                'assigned_to' => $request->assigned_to,
                'notes' => $request->notes,
                'tags' => $request->tags,
                'first_contact_at' => now(),
                'last_contact_at' => now(),
            ]);

            Log::info('Customer created', [
                'customer_id' => $customer->id,
                'email' => $customer->email,
                'created_by' => auth()->id()
            ]);

            return redirect()->route('admin.customers.show', $customer)
                ->with('success', 'Customer created successfully.');

        } catch (\Exception $e) {
            Log::error('Error creating customer: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error creating customer. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        try {
            $customer->load(['assignedTo', 'lead', 'interactions.createdBy', 'quotations']);

            $interactions = $customer->interactions()->latest()->take(20)->get();

            $users = User::all();

            Log::info('Admin viewing customer details', [
                'customer_id' => $customer->id,
                'email' => $customer->email
            ]);

            return view('admin.customers.show', compact('customer', 'interactions', 'users'));

        } catch (\Exception $e) {
            Log::error('Error loading customer details: ' . $e->getMessage());

            return redirect()->route('admin.customers.index')
                ->with('error', 'Customer not found.');
        }
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        $users = User::all();
        return view('admin.customers.edit', compact('customer', 'users'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'address' => $request->address,
                'industry' => $request->industry,
                'status' => $request->status,
                'source' => $request->source,
                'assigned_to' => $request->assigned_to,
                'notes' => $request->notes,
                'tags' => $request->tags,
            ]);

            Log::info('Customer updated', [
                'customer_id' => $customer->id,
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('admin.customers.show', $customer)
                ->with('success', 'Customer updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating customer. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            Log::info('Customer deleted', [
                'customer_id' => $customer->id,
                'email' => $customer->email,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting customer: ' . $e->getMessage());

            return redirect()->route('admin.customers.index')
                ->with('error', 'Error deleting customer. Please try again.');
        }
    }

    /**
     * Convert a lead to a customer (AJAX).
     */
    public function convertLead(Request $request, Lead $lead)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,blocked',
                'source' => 'nullable|in:lead,quote_request,direct,referral',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            // Check if customer with this email already exists
            $existingCustomer = Customer::where('email', $lead->email)->first();

            if ($existingCustomer) {
                // Link lead to existing customer
                $lead->update([
                    'customer_id' => $existingCustomer->id,
                    'converted_to_customer_at' => now(),
                    'status' => 'converted',
                ]);

                Log::info('Lead linked to existing customer', [
                    'lead_id' => $lead->id,
                    'customer_id' => $existingCustomer->id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Lead linked to existing customer.',
                    'customer_id' => $existingCustomer->id
                ]);
            }

            // Create new customer from lead
            $customer = Customer::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'status' => $validated['status'],
                'source' => $validated['source'] ?? 'lead',
                'lead_id' => $lead->id,
                'assigned_to' => $validated['assigned_to'] ?? $lead->assigned_to,
                'first_contact_at' => $lead->created_at,
                'last_contact_at' => now(),
                'notes' => $lead->notes,
            ]);

            // Update lead
            $lead->update([
                'customer_id' => $customer->id,
                'converted_to_customer_at' => now(),
                'status' => 'converted',
            ]);

            Log::info('Lead converted to customer', [
                'lead_id' => $lead->id,
                'customer_id' => $customer->id,
                'converted_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead converted to customer successfully.',
                'customer_id' => $customer->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error converting lead to customer: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error converting lead to customer.'
            ], 500);
        }
    }

    /**
     * Add an interaction to a customer (AJAX).
     */
    public function addInteraction(StoreInteractionRequest $request, Customer $customer)
    {
        try {
            $interaction = $customer->addInteraction([
                'type' => $request->type,
                'subject' => $request->subject,
                'content' => $request->content,
                'created_by' => auth()->id(),
                'metadata' => $request->metadata,
            ]);

            Log::info('Customer interaction added', [
                'customer_id' => $customer->id,
                'interaction_type' => $request->type,
                'added_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interaction added successfully.',
                'interaction' => $interaction->load('createdBy')
            ]);

        } catch (\Exception $e) {
            Log::error('Error adding customer interaction: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error adding interaction.'
            ], 500);
        }
    }

    /**
     * Display customer-specific analytics.
     */
    public function analytics(Customer $customer)
    {
        try {
            $customer->load(['quotations', 'quoteRequests', 'leads']);

            // Customer analytics
            $analytics = [
                'total_quotations' => $customer->quotations->count(),
                'accepted_quotations' => $customer->quotations->where('status', 'accepted')->count(),
                'pending_quotations' => $customer->quotations->where('status', 'pending')->count(),
                'total_quotation_value' => $customer->quotations->where('status', 'accepted')->sum('total'),
                'quote_requests_count' => $customer->quoteRequests->count(),
                'leads_count' => $customer->leads->count(),
                'interactions_count' => $customer->interactions()->count(),
                'avg_time_to_convert' => $this->calculateAvgTimeToConvert($customer),
            ];

            return view('admin.customers.analytics', compact('customer', 'analytics'));

        } catch (\Exception $e) {
            Log::error('Error loading customer analytics: ' . $e->getMessage());

            return redirect()->route('admin.customers.show', $customer)
                ->with('error', 'Error loading customer analytics.');
        }
    }

    /**
     * Calculate average time to convert for customer.
     */
    protected function calculateAvgTimeToConvert(Customer $customer): ?string
    {
        $convertedLeads = $customer->leads()
            ->whereNotNull('converted_to_customer_at')
            ->get();

        if ($convertedLeads->isEmpty()) {
            return null;
        }

        $totalDays = $convertedLeads->sum(function ($lead) {
            return $lead->created_at->diffInDays($lead->converted_to_customer_at);
        });

        return round($totalDays / $convertedLeads->count(), 1) . ' days';
    }
}
