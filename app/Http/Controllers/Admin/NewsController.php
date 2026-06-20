<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NewsController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index(): View
    {
        $news = News::with('category')->latest()->paginate(10);
        $categories = Category::newsArea()->active()->get();
        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(): View
    {
        $categories = Category::newsArea()->active()->get();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'read_time' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['featured'] = $request->has('featured') ? 1 : 0;
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;
        $validated['order'] = $request->order ?? 0;

        // Set published_at if publishing for the first time
        if ($request->has('is_published') && empty($request->published_at)) {
            $validated['published_at'] = now();
        }

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('news/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news): View
    {
        $categories = Category::newsArea()->active()->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'read_time' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['featured'] = $request->has('featured') ? 1 : 0;
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;
        $validated['order'] = $request->order ?? 0;

        // Set published_at if publishing for the first time
        if ($request->has('is_published') && !$news->published_at) {
            $validated['published_at'] = now();
        }

        // Set category display name from selected category
        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $validated['category'] = $category->name;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = '/storage/' . $path;

            // Delete old image
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = $news->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('news/gallery', 'public');
                $galleryPaths[] = '/storage/' . $path;
            }
            $validated['gallery'] = $galleryPaths;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news): RedirectResponse
    {
        // Delete image
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        // Delete gallery images
        if ($news->gallery) {
            foreach ($news->gallery as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    /**
     * Remove a gallery image from the news article.
     */
    public function removeGalleryImage(News $news, Request $request): RedirectResponse
    {
        $request->validate([
            'image_index' => 'required|integer|min:0',
        ]);

        $galleryImages = $news->gallery ?? [];
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
            $news->update(['gallery' => $newGallery]);

            return redirect()->back()
                ->with('success', 'Gallery image removed successfully.');
        }

        return redirect()->back()
            ->with('error', 'Invalid image index.');
    }

    /**
     * Remove the news article image.
     */
    public function removeImage(News $news): RedirectResponse
    {
        // Delete image file from storage
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        // Remove image from database
        $news->update(['image' => null]);

        return redirect()->back()
            ->with('success', 'Image removed successfully.');
    }
}