<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAndSolution;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ServiceAndSolutionController extends Controller
{
    /**
     * Display a listing of services and solutions.
     */
    public function index(): View
    {
        $items = ServiceAndSolution::with('category')->latest()->paginate(10);
        $categories = Category::where('service_area', 'service')->active()->get();
        return view('admin.services-and-solutions.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new service/solution.
     */
    public function create(): View
    {
        $categories = Category::where('service_area', 'service')->active()->get();
        return view('admin.services-and-solutions.create', compact('categories'));
    }

    /**
     * Store a newly created service/solution in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:service,solution',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'icon' => 'nullable|string',
            'features' => 'nullable|array',
            'process' => 'nullable|array',
            'duration' => 'nullable|string',
            'availability' => 'nullable|string',
            'components' => 'nullable|array',
            'applications' => 'nullable|array',
            'benefits' => 'nullable|array',
            'industries' => 'nullable|array',
            'stats' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['order'] = $request->order ?? 0;

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services-and-solutions', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('services-and-solutions/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        ServiceAndSolution::create($validated);

        return redirect()->route('admin.services-and-solutions.index')
            ->with('success', 'Item created successfully.');
    }

    /**
     * Show the form for editing the specified service/solution.
     */
    public function edit(ServiceAndSolution $item): View
    {
        $categories = Category::where('service_area', 'service')->active()->get();
        return view('admin.services-and-solutions.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified service/solution in storage.
     */
    public function update(Request $request, ServiceAndSolution $item): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:service,solution',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'overview' => 'nullable|string',
            'icon' => 'nullable|string',
            'features' => 'nullable|array',
            'process' => 'nullable|array',
            'duration' => 'nullable|string',
            'availability' => 'nullable|string',
            'components' => 'nullable|array',
            'applications' => 'nullable|array',
            'benefits' => 'nullable|array',
            'industries' => 'nullable|array',
            'stats' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['order'] = $request->order ?? 0;

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services-and-solutions', 'public');
            $validated['image'] = '/storage/' . $path;

            // Delete old image
            if ($item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = $item->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('services-and-solutions/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        $item->update($validated);

        return redirect()->route('admin.services-and-solutions.index')
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified service/solution from storage.
     */
    public function destroy(ServiceAndSolution $item): RedirectResponse
    {
        // Delete image
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        // Delete gallery images
        if ($item->gallery) {
            foreach ($item->gallery as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
        }

        $item->delete();

        return redirect()->route('admin.services-and-solutions.index')
            ->with('success', 'Item deleted successfully.');
    }

    /**
     * Remove a gallery image from the service/solution.
     */
    public function removeGalleryImage(ServiceAndSolution $item, Request $request): RedirectResponse
    {
        $request->validate([
            'image_index' => 'required|integer|min:0',
        ]);

        $galleryImages = $item->gallery ?? [];
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
            $item->update(['gallery' => $newGallery]);

            return redirect()->back()
                ->with('success', 'Gallery image removed successfully.');
        }

        return redirect()->back()
            ->with('error', 'Invalid image index.');
    }

    /**
     * Remove the service/solution image.
     */
    public function removeImage(ServiceAndSolution $item): RedirectResponse
    {
        // Delete image file from storage
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        // Remove image from database
        $item->update(['image' => null]);

        return redirect()->back()
            ->with('success', 'Image removed successfully.');
    }
}