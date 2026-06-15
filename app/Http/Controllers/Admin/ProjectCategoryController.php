<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of project categories.
     */
    public function index(): View
    {
        $categories = ProjectCategory::ordered()->paginate(10);
        return view('admin.project-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new project category.
     */
    public function create(): View
    {
        return view('admin.project-categories.create');
    }

    /**
     * Store a newly created project category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-categories', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        ProjectCategory::create($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category created successfully.');
    }

    /**
     * Show the form for editing the specified project category.
     */
    public function edit(ProjectCategory $projectCategory): View
    {
        return view('admin.project-categories.edit', compact('projectCategory'));
    }

    /**
     * Update the specified project category in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('project-categories', 'public');
            $validated['image'] = '/storage/' . $path;

            // Delete old image
            if ($projectCategory->image && file_exists(public_path($projectCategory->image))) {
                unlink(public_path($projectCategory->image));
            }
        }

        $projectCategory->update($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category updated successfully.');
    }

    /**
     * Remove the specified project category from storage.
     */
    public function destroy(ProjectCategory $projectCategory): RedirectResponse
    {
        // Delete category image
        if ($projectCategory->image && file_exists(public_path($projectCategory->image))) {
            unlink(public_path($projectCategory->image));
        }

        $projectCategory->delete();

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category deleted successfully.');
    }

    /**
     * Update the order of project categories.
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:project_categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['categories'] as $categoryData) {
            ProjectCategory::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Categories order updated successfully.');
    }
}
