<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmitted;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|string|in:general,projects,products,support,careers,other',
                'message' => 'required|string|min:10|max:5000',
            ]);

            if ($validator->fails()) {
                Log::info('Contact form validation failed:', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $request->except(['message'])
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Please check the form and try again.',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            // Create the lead
            $lead = Lead::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
            ]);

            Log::info('New lead created:', [
                'lead_id' => $lead->id,
                'name' => $lead->name,
                'email' => $lead->email,
                'subject' => $lead->subject
            ]);

            // Send email notification via SMTP
            try {
                $recipientEmail = config('mail.admin_address', config('mail.from.address'));
                Mail::to($recipientEmail)->send(new ContactFormSubmitted($lead));

                Log::info('Contact form email sent successfully:', [
                    'lead_id' => $lead->id,
                    'recipient' => $recipientEmail
                ]);
            } catch (\Exception $mailException) {
                Log::error('Failed to send contact form email:', [
                    'lead_id' => $lead->id,
                    'error' => $mailException->getMessage(),
                    'trace' => $mailException->getTraceAsString()
                ]);
                // Continue execution - email failure shouldn't prevent the lead from being saved
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'data' => [
                    'lead_id' => $lead->id
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the form. Please try again.'
            ], 500);
        }
    }

    /**
     * Get all leads for admin panel
     */
    public function index()
    {
        try {
            $leads = Lead::with('assignedTo')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $leads
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching leads:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error fetching leads'
            ], 500);
        }
    }

    /**
     * Get lead details
     */
    public function show($id)
    {
        try {
            $lead = Lead::with('assignedTo')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $lead
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lead not found'
            ], 404);
        }
    }

    /**
     * Update lead status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:new,contacted,qualified,converted,lost',
                'notes' => 'nullable|string',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            $lead->update([
                'status' => $request->status,
                'notes' => $request->notes ?? $lead->notes,
                'assigned_to' => $request->assigned_to ?? $lead->assigned_to,
                'contacted_at' => $request->status !== 'new' ? now() : $lead->contacted_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully',
                'data' => $lead->fresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating lead:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating lead'
            ], 500);
        }
    }

    /**
     * Delete lead
     */
    public function destroy($id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $lead->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lead deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting lead'
            ], 500);
        }
    }
}
