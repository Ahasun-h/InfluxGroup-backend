<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerOpportunitie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CareersController extends Controller
{
    /**
     * Display the careers management page
     */
    public function index(Request $request): View
    {
        try {
            // Check if user wants to see deleted items
            $showDeleted = $request->query('show_deleted') == '1';

            if ($showDeleted) {
                // Show only deleted items
                $jobs = \DB::table('career_opportunities')
                    ->whereNotNull('deleted_at')  // Only deleted items
                    ->orderBy('created_at', 'desc')
                    ->get();

                \Log::info('Retrieved deleted jobs:', [
                    'total_count' => $jobs->count(),
                    'source' => 'deleted_items_only'
                ]);
            } else {
                // Show only active jobs (exclude soft-deleted ones by default)
                $jobs = \DB::table('career_opportunities')
                    ->whereNull('deleted_at')  // Exclude deleted items
                    ->orderBy('order')
                    ->orderBy('created_at', 'desc')
                    ->get();

                \Log::info('Retrieved active jobs from database:', [
                    'total_count' => $jobs->count(),
                    'active_count' => $jobs->where('is_active', 1)->count(),
                    'deleted_count' => 0, // Deleted items excluded by default
                    'job_ids' => $jobs->pluck('id')->toArray(),
                    'source' => 'active_jobs_only',
                    'jobs_with_deleted_status' => $jobs->map(function($job) {
                        return [
                            'id' => $job->id,
                            'title' => $job->title,
                            'is_active' => $job->is_active,
                            'deleted_at' => $job->deleted_at
                        ];
                    })->toArray()
                ]);
            }

            return view('admin.careers.index', [
                'jobs' => $jobs,
                'showDeleted' => $showDeleted
            ]);
        } catch (\Exception $e) {
            \Log::error('Careers page error: ' . $e->getMessage());
            \Log::error('Stack trace: ', ['trace' => $e->getTraceAsString()]);

            // Return empty collection on error to prevent page crash
            return view('admin.careers.index', [
                'jobs' => collect([]),
                'showDeleted' => false
            ]);
        }
    }

    /**
     * Show the form for creating a new job.
     */
    public function create(): View
    {
        return view('admin.careers.create');
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'department' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'type' => 'required|in:Full-time,Part-time,Contract,Internship',
                'expiry_date' => 'nullable|date', // Optional - only validated if migration is run
                'posted_date' => 'nullable|string|max:255',
                'experience' => 'nullable|string|max:255',
                'salary' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'requirements' => 'nullable|array',
                'responsibilities' => 'nullable|array',
                'benefits' => 'nullable|array',
                'order' => 'nullable|integer',
            ]);

            // Handle list inputs - filter empty values
            $validated['requirements'] = array_filter($request->input('requirements', []), function($value) {
                return !empty(trim($value));
            });

            $validated['responsibilities'] = array_filter($request->input('responsibilities', []), function($value) {
                return !empty(trim($value));
            });

            $validated['benefits'] = array_filter($request->input('benefits', []), function($value) {
                return !empty(trim($value));
            });

            // Re-index arrays
            $validated['requirements'] = array_values($validated['requirements']);
            $validated['responsibilities'] = array_values($validated['responsibilities']);
            $validated['benefits'] = array_values($validated['benefits']);

            $validated['created_by'] = auth()->id();
            $validated['updated_by'] = auth()->id();
            $validated['is_active'] = $request->input('is_active') == '1';
            $validated['order'] = (int) $request->input('order', 0);

            // Set default posted_date if not provided
            if (!$request->has('posted_date')) {
                $validated['posted_date'] = 'Recently posted';
            }

            $job = CareerOpportunitie::create($validated);

            return redirect()->route('admin.careers.index')
                ->with('success', 'Job "' . $job->title . '" created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Error creating job: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating job. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit($id): View
    {
        try {
            // Find the job, including soft-deleted ones
            $career = CareerOpportunitie::withTrashed()->findOrFail($id);

            \Log::info('Loading job for edit:', ['job_id' => $career->id, 'title' => $career->title]);

            return view('admin.careers.edit', [
                'job' => $career
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading job for edit: ' . $e->getMessage());
            return redirect()->route('admin.careers.index')
                ->with('error', 'Error loading job for editing.');
        }
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            // Find the job, including soft-deleted ones
            $career = CareerOpportunitie::withTrashed()->findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'department' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'type' => 'required|in:Full-time,Part-time,Contract,Internship',
                'expiry_date' => 'nullable|date',
                'posted_date' => 'nullable|string|max:255',
                'experience' => 'nullable|string|max:255',
                'salary' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'requirements' => 'nullable|array',
                'responsibilities' => 'nullable|array',
                'benefits' => 'nullable|array',
                'order' => 'nullable|integer',
            ]);

            // Handle list inputs - filter empty values and ensure arrays
            $requirements = $request->input('requirements', []);
            if (!is_array($requirements)) {
                $requirements = [];
            }
            $validated['requirements'] = array_values(array_filter($requirements, function($value) {
                return !empty(trim($value ?? ''));
            }));

            $responsibilities = $request->input('responsibilities', []);
            if (!is_array($responsibilities)) {
                $responsibilities = [];
            }
            $validated['responsibilities'] = array_values(array_filter($responsibilities, function($value) {
                return !empty(trim($value ?? ''));
            }));

            $benefits = $request->input('benefits', []);
            if (!is_array($benefits)) {
                $benefits = [];
            }
            $validated['benefits'] = array_values(array_filter($benefits, function($value) {
                return !empty(trim($value ?? ''));
            }));

            $validated['updated_by'] = auth()->id();
            $validated['is_active'] = $request->input('is_active') == '1';
            $validated['order'] = (int) $request->input('order', $career->order);

            // Perform the update
            $career->update($validated);

            return redirect()->route('admin.careers.index')
                ->with('success', 'Job "' . $validated['title'] . '" updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating job: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        try {
            // Find the job, including soft-deleted ones
            $career = CareerOpportunitie::withTrashed()->findOrFail($id);

            // Check if this is a permanent delete request
            if ($request->input('force_delete') == '1') {
                // Permanently delete the job
                $title = $career->title;
                $career->forceDelete(); // This permanently removes the record

                return redirect()->route('admin.careers.index')
                    ->with('success', 'Job "' . $title . '" permanently deleted.');
            } else {
                // Soft delete
                $title = $career->title;
                $result = $career->delete();

                return redirect()->route('admin.careers.index')
                    ->with('success', 'Job "' . $title . '" deleted successfully.');
            }

        } catch (\Exception $e) {
            \Log::error('Error deleting job: ' . $e->getMessage());
            return redirect()->route('admin.careers.index')
                ->with('error', 'Error deleting job. Please try again.');
        }
    }

    /**
     * Restore a soft-deleted job.
     */
    public function restore($id): JsonResponse
    {
        try {
            // Find the soft-deleted job
            $career = CareerOpportunitie::withTrashed()->findOrFail($id);

            if (!$career->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job is not deleted.'
                ], 400);
            }

            $career->restore();

            return response()->json([
                'success' => true,
                'message' => 'Job restored successfully.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error restoring job: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error restoring job.'
            ], 500);
        }
    }

    /**
     * Update the order of jobs.
     */
    public function updateOrder(Request $request): JsonResponse
    {
        try {
            $order = $request->input('order', []);

            foreach ($order as $index => $id) {
                CareerOpportunitie::where('id', $id)->update(['order' => $index]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Jobs order updated successfully.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating jobs order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating jobs order.'
            ], 500);
        }
    }

    /**
     * Toggle job active status.
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            // Find the job, including soft-deleted ones
            $career = CareerOpportunitie::withTrashed()->findOrFail($id);

            $career->update([
                'is_active' => !$career->is_active,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job status updated successfully.',
                'is_active' => $career->is_active
            ]);

        } catch (\Exception $e) {
            \Log::error('Error toggling job status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating job status.'
            ], 500);
        }
    }

    /**
     * Convert textarea content to array (one line per item)
     */
    private function convertToArray($value): array
    {
        if (is_array($value)) {
            return array_filter(array_map('trim', $value));
        }

        if (is_string($value)) {
            return array_filter(array_map('trim', explode("\n", $value)));
        }

        return [];
    }

    /**
     * Debug method to diagnose career issues
     */
    public function debug()
    {
        try {
            $debug = [];

            // Check database connection
            try {
                $debug['database_connection'] = 'OK';
                $debug['database_name'] = DB::connection()->getDatabaseName();
            } catch (\Exception $e) {
                $debug['database_connection'] = 'FAILED: ' . $e->getMessage();
            }

            // Check if table exists
            try {
                $debug['table_exists'] = Schema::hasTable('career_opportunities');
            } catch (\Exception $e) {
                $debug['table_exists'] = 'FAILED: ' . $e->getMessage();
            }

            // Check table structure
            try {
                if (Schema::hasTable('career_opportunities')) {
                    $debug['table_columns'] = Schema::getColumnListing('career_opportunities');
                }
            } catch (\Exception $e) {
                $debug['table_columns'] = 'FAILED: ' . $e->getMessage();
            }

            // Count records
            try {
                $debug['total_jobs'] = CareerOpportunitie::count();
                $debug['active_jobs'] = CareerOpportunitie::where('is_active', true)->count();
                $debug['inactive_jobs'] = CareerOpportunitie::where('is_active', false)->count();
            } catch (\Exception $e) {
                $debug['job_count'] = 'FAILED: ' . $e->getMessage();
            }

            // Get sample jobs
            try {
                $debug['sample_jobs'] = CareerOpportunitie::latest()->take(3)->get()->toArray();
            } catch (\Exception $e) {
                $debug['sample_jobs'] = 'FAILED: ' . $e->getMessage();
            }

            // Check recent logs
            try {
                $logFile = storage_path('logs/laravel.log');
                if (file_exists($logFile)) {
                    $debug['recent_logs'] = array_slice(array_reverse(explode("\n", file_get_contents($logFile))), 0, 20);
                } else {
                    $debug['recent_logs'] = 'No log file found';
                }
            } catch (\Exception $e) {
                $debug['recent_logs'] = 'FAILED: ' . $e->getMessage();
            }

            return response()->json($debug);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
