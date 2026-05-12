<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'client' => 'nullable|string',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'completion' => 'nullable|string',
            'value' => 'nullable|string',
            'start_date' => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'scope' => 'nullable|array',
            'highlights' => 'nullable|array',
            'stats' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['featured'] = $request->has('featured');
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        if ($request->hasFile('additional_images')) {
            $images = [];
            foreach ($request->file('additional_images') as $file) {
                $path = $file->store('projects/gallery', 'public');
                $images[] = '/storage/' . $path;
            }
            $validated['images'] = $images;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'client' => 'nullable|string',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'completion' => 'nullable|string',
            'value' => 'nullable|string',
            'start_date' => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'scope' => 'nullable|array',
            'highlights' => 'nullable|array',
            'stats' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['featured'] = $request->has('featured');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        if ($request->hasFile('additional_images')) {
            $images = $project->images ?? [];
            foreach ($request->file('additional_images') as $file) {
                $path = $file->store('projects/gallery', 'public');
                $images[] = '/storage/' . $path;
            }
            $validated['images'] = $images;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
