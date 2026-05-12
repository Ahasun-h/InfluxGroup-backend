<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobOpeningController extends Controller
{
    public function index()
    {
        $jobs = JobOpening::latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['posted_date'] = now();
        
        JobOpening::create($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job opening posted successfully.');
    }

    public function edit(JobOpening $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobOpening $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($request->title);

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job opening updated successfully.');
    }

    public function destroy(JobOpening $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job opening removed.');
    }
}
