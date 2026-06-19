<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
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
        $products = Product::with('category')->ordered()->paginate(10);
        $categories = Category::productArea()->active()->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::productArea()->active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:51200',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'order' => 'nullable|integer|min:0',
        ]);

        // Add slug
        $validated['slug'] = Str::slug($request->name);

        // Handle is_active checkbox (not sent when unchecked)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Set default order if not provided
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

        // Handle gallery images - store as array (Laravel will JSON encode automatically due to model casts)
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths; // Store as array, not JSON string
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
        $categories = Category::productArea()->active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'applications' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:51200',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
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

        // Handle gallery images - append to existing gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = $product->gallery ?? []; // Model casts handle JSON decode automatically
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths; // Store as array, not JSON string
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

        // Delete gallery images (Model casts handle JSON decode automatically)
        if ($product->gallery) {
            foreach ($product->gallery as $imagePath) {
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

        $galleryImages = $product->gallery ?? []; // Model casts handle JSON decode automatically
        $index = $request->image_index;

        if (isset($galleryImages[$index])) {
            $imagePath = $galleryImages[$index];

            // Delete file from storage
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            // Remove from array
            unset($galleryImages[$index]);
            $newGallery = array_values($galleryImages);
            $product->update(['gallery' => $newGallery]); // Store as array, not JSON string

            return redirect()->back()
                ->with('success', 'Gallery image removed successfully.');
        }

        return redirect()->back()
            ->with('error', 'Invalid image index.');
    }

    /**
     * Remove the brochure from the product.
     */
    public function removeBrochure(Product $product): RedirectResponse
    {
        // Delete brochure file from storage
        if ($product->brochure && file_exists(public_path($product->brochure))) {
            unlink(public_path($product->brochure));
        }

        // Remove brochure from database
        $product->update(['brochure' => null]);

        return redirect()->back()
            ->with('success', 'Brochure removed successfully.');
    }

    /**
     * Remove the product image.
     */
    public function removeImage(Product $product): RedirectResponse
    {
        // Delete image file from storage
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Remove image from database
        $product->update(['image' => null]);

        return redirect()->back()
            ->with('success', 'Product image removed successfully.');
    }
}
