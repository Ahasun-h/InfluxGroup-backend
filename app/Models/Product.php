<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'category_id',
        'description',
        'overview',
        'specifications',
        'features',
        'applications',
        'image',
        'brochure',
        'gallery',
        'is_active',
        'order',
    ];

    protected $casts = [
        'specifications' => 'array',
        'features' => 'array',
        'applications' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get active products ordered by order field.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get products ordered by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope a query to only include products of a given category.
     */
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('productCategory', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        });
    }
}
