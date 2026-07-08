<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadsController extends Controller
{
    /**
     * Display the leads management page.
     */
    public function index()
    {
        try {
            $leads = Lead::with('assignedTo')
                ->orderBy('created_at', 'desc')
                ->get();

            // Statistics
            $stats = [
                'total' => $leads->count(),
                'new' => $leads->where('status', 'new')->count(),
                'contacted' => $leads->where('status', 'contacted')->count(),
                'qualified' => $leads->where('status', 'qualified')->count(),
                'converted' => $leads->where('status', 'converted')->count(),
                'lost' => $leads->where('status', 'lost')->count(),
            ];

            // Users for assignment dropdown
            $users = User::all();

            Log::info('Admin accessing leads page:', [
                'total_leads' => $stats['total'],
                'new_leads' => $stats['new']
            ]);

            return view('admin.leads.index', compact('leads', 'stats', 'users'));

        } catch (\Exception $e) {
            Log::error('Error loading leads page: ' . $e->getMessage());

            return view('admin.leads.index', [
                'leads' => collect([]),
                'stats' => [
                    'total' => 0,
                    'new' => 0,
                    'contacted' => 0,
                    'qualified' => 0,
                    'converted' => 0,
                    'lost' => 0,
                ],
                'users' => collect([])
            ]);
        }
    }

    /**
     * Display the specified lead.
     */
    public function show($id)
    {
        try {
            $lead = Lead::with('assignedTo')->findOrFail($id);

            // Users for assignment dropdown
            $users = User::all();

            Log::info('Admin viewing lead details:', [
                'lead_id' => $id,
                'lead_email' => $lead->email
            ]);

            return view('admin.leads.show', compact('lead', 'users'));

        } catch (\Exception $e) {
            Log::error('Error loading lead details: ' . $e->getMessage());

            return redirect()->route('admin.leads.index')
                ->with('error', 'Lead not found.');
        }
    }

    /**
     * Update the specified lead.
     */
    public function update(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:new,contacted,qualified,converted,lost',
                'notes' => 'nullable|string',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            $lead->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $lead->notes,
                'assigned_to' => $validated['assigned_to'] ?? $lead->assigned_to,
                'contacted_at' => $validated['status'] !== 'new' ? now() : $lead->contacted_at,
            ]);

            Log::info('Lead updated:', [
                'lead_id' => $id,
                'new_status' => $validated['status'],
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('admin.leads.show', $id)
                ->with('success', 'Lead updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating lead: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error updating lead. Please try again.');
        }
    }

    /**
     * Remove the specified lead.
     */
    public function destroy($id)
    {
        try {
            $lead = Lead::findOrFail($id);

            Log::info('Lead deleted:', [
                'lead_id' => $id,
                'lead_email' => $lead->email,
                'deleted_by' => auth()->id()
            ]);

            $lead->delete();

            return redirect()->route('admin.leads.index')
                ->with('success', 'Lead deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting lead: ' . $e->getMessage());

            return redirect()->route('admin.leads.index')
                ->with('error', 'Error deleting lead. Please try again.');
        }
    }

    /**
     * Update lead status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:new,contacted,qualified,converted,lost',
            ]);

            $lead->update([
                'status' => $validated['status'],
                'contacted_at' => $validated['status'] !== 'new' ? now() : null,
            ]);

            Log::info('Lead status updated:', [
                'lead_id' => $id,
                'new_status' => $validated['status'],
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating lead status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating status'
            ], 500);
        }
    }
}
