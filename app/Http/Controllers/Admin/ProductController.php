<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): View
    {
        $products = Product::with('productCategory')->ordered()->paginate(10);
        $categories = ProductCategory::active()->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = ProductCategory::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Handle brochure upload
        if ($request->hasFile('brochure')) {
            $path = $request->file('brochure')->store('product-brochures', 'public');
            $validated['brochure'] = '/storage/' . $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = json_encode($galleryPaths);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = ProductCategory::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;

            // Delete old image
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
        }

        // Handle brochure upload
        if ($request->hasFile('brochure')) {
            $path = $request->file('brochure')->store('product-brochures', 'public');
            $validated['brochure'] = '/storage/' . $path;

            // Delete old brochure
            if ($product->brochure && file_exists(public_path($product->brochure))) {
                unlink(public_path($product->brochure));
            }
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = json_decode($product->gallery ?? '[]', true);
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = json_encode($galleryPaths);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete product image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Delete brochure
        if ($product->brochure && file_exists(public_path($product->brochure))) {
            unlink(public_path($product->brochure));
        }

        // Delete gallery images
        if ($product->gallery) {
            $galleryImages = json_decode($product->gallery, true);
            foreach ($galleryImages as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Remove a gallery image from the product.
     */
    public function removeGalleryImage(Product $product, Request $request): RedirectResponse
    {
        $request->validate([
            'image_index' => 'required|integer|min:0',
        ]);

        $galleryImages = json_decode($product->gallery ?? '[]', true);
        $index = $request->image_index;

        if (isset($galleryImages[$index])) {
            $imagePath = $galleryImages[$index];

            // Delete file from storage
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            // Remove from array
            unset($galleryImages[$index]);
            $product->update(['gallery' => json_encode(array_values($galleryImages))]);

            return redirect()->back()
                ->with('success', 'Gallery image removed successfully.');
        }

        return redirect()->back()
            ->with('error', 'Invalid image index.');
    }
}
