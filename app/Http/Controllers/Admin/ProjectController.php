<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with('category')->latest()->paginate(10);
        $categories = Category::projectArea()->active()->get();
        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::projectArea()->active()->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'client' => 'nullable|string',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'completion' => 'nullable|string',
            'value' => 'nullable|numeric',
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

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

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

    public function edit(Project $project): View
    {
        $categories = Category::projectArea()->active()->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'client' => 'nullable|string',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'completion' => 'nullable|string',
            'value' => 'nullable|numeric',
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

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

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

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
