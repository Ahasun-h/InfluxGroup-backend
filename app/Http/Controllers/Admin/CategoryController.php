<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request): View
    {
        $serviceArea = $request->query('area', 'all');
        $query = Category::query();

        if ($serviceArea !== 'all') {
            $query->where('service_area', $serviceArea);
        }

        $categories = $query->ordered()->get();

        // Get counts for each service area
        $counts = [
            'all' => Category::count(),
            'product' => Category::productArea()->count(),
            'project' => Category::projectArea()->count(),
            'service' => Category::serviceArea()->count(),
            'news' => Category::newsArea()->count(),
        ];

        return view('admin.categories.index', compact('categories', 'serviceArea', 'counts'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $serviceAreas = [
            'product' => 'Products',
            'project' => 'Projects',
            'service' => 'Services',
            'news' => 'News & Articles'
        ];

        return view('admin.categories.create', compact('serviceAreas'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_area' => 'required|in:product,project,service,news',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['order'] = $request->order ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            Category::create($validated);
            return redirect()->route('admin.categories.index', ['area' => $validated['service_area']])
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $serviceAreas = [
            'product' => 'Products',
            'project' => 'Projects',
            'service' => 'Services',
            'news' => 'News & Articles'
        ];

        return view('admin.categories.edit', compact('category', 'serviceAreas'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_area' => 'required|in:product,project,service,news',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['order'] = $request->order ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $category->update($validated);
            return redirect()->route('admin.categories.index', ['area' => $validated['service_area']])
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has related content
        $hasContent = false;
        $contentTypes = [];

        if ($category->products()->count() > 0) {
            $hasContent = true;
            $contentTypes[] = 'products';
        }

        if ($category->projects()->count() > 0) {
            $hasContent = true;
            $contentTypes[] = 'projects';
        }

        if ($category->services()->count() > 0) {
            $hasContent = true;
            $contentTypes[] = 'services';
        }

        if ($category->news()->count() > 0) {
            $hasContent = true;
            $contentTypes[] = 'news articles';
        }

        if ($hasContent) {
            return redirect()->route('admin.categories.index', ['area' => $category->service_area])
                ->with('error', 'Cannot delete category with ' . implode(', ', $contentTypes) . '. Please reassign content first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index', ['area' => $category->service_area])
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Update the order of categories.
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'categories' => 'required|array',
                'categories.*.id' => 'required|exists:categories,id',
                'categories.*.order' => 'required|integer|min:0',
            ]);

            foreach ($request->categories as $categoryData) {
                $category = Category::find($categoryData['id']);
                if ($category) {
                    $category->update(['order' => $categoryData['order']]);
                }
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Categories order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Failed to update categories order: ' . $e->getMessage());
        }
    }
}