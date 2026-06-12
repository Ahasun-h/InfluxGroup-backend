<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of product categories.
     */
    public function index(): View
    {
        $categories = ProductCategory::ordered()->get();
        return view('admin.product-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new product category.
     */
    public function create(): View
    {
        return view('admin.product-categories.create');
    }

    /**
     * Store a newly created product category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['order'] = $request->order ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            ProductCategory::create($validated);
            return redirect()->route('admin.product-categories.index')
                ->with('success', 'Product category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified product category.
     */
    public function edit(ProductCategory $productCategory): View
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    /**
     * Update the specified product category in storage.
     */
    public function update(Request $request, ProductCategory $productCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['order'] = $request->order ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $productCategory->update($validated);
            return redirect()->route('admin.product-categories.index')
                ->with('success', 'Product category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product category from storage.
     */
    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete category with products. Please reassign products first.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }

    /**
     * Update the order of categories.
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'categories' => 'required|array',
                'categories.*.id' => 'required|exists:product_categories,id',
                'categories.*.order' => 'required|integer|min:0',
            ]);

            foreach ($request->categories as $categoryData) {
                $category = ProductCategory::find($categoryData['id']);
                if ($category) {
                    $category->update(['order' => $categoryData['order']]);
                }
            }

            return redirect()->route('admin.product-categories.index')
                ->with('success', 'Categories order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Failed to update categories order: ' . $e->getMessage());
        }
    }
}