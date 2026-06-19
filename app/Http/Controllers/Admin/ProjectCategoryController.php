<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $categories = Category::projectArea()->ordered()->paginate(10);
        return view('admin.project-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new project category.
     * Note: Using modal in index page instead
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('admin.project-categories.index');
    }

    /**
     * Store a newly created project category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Debug: Log incoming request data
        \Log::info('Project Category Store Request', [
            'request_data' => $request->all(),
            'has_is_active' => $request->has('is_active'),
            'is_active_value' => $request->input('is_active'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;
        $validated['service_area'] = 'project';

        \Log::info('Project Category Validated Data', ['validated' => $validated]);

        Category::create($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category created successfully.');
    }

    /**
     * Show the form for editing the specified project category.
     * Note: Using modal in index page instead
     */
    public function edit(Category $projectCategory): RedirectResponse
    {
        return redirect()->route('admin.project-categories.index');
    }

    /**
     * Update the specified project category in storage.
     */
    public function update(Request $request, Category $projectCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;

        $projectCategory->update($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Project category updated successfully.');
    }

    /**
     * Remove the specified project category from storage.
     */
    public function destroy(Category $projectCategory): RedirectResponse
    {
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
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['categories'] as $categoryData) {
            Category::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'Categories order updated successfully.');
    }
}
