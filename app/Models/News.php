<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'category_id',
        'excerpt',
        'content',
        'author',
        'author_title',
        'publication_date',
        'featured',
        'read_time',
        'image',
        'gallery',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'order',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'gallery' => 'array',
        'is_published' => 'boolean',
        'publication_date' => 'date',
        'published_at' => 'datetime',
    ];

    /**
     * Get the category that owns the news article.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Scope to get only published news.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get only featured news.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get active news ordered by order field.
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true)->orderBy('order');
    }

    /**
     * Get news ordered by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope a query to only include news of a given category.
     */
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        });
    }
}