<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'is_active',
        'service_area',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get the projects for the category.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    /**
     * Get the services for the category.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    /**
     * Get the news articles for the category.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    /**
     * Scope to get only product categories.
     */
    public function scopeProductArea($query)
    {
        return $query->where('service_area', 'product');
    }

    /**
     * Scope to get only project categories.
     */
    public function scopeProjectArea($query)
    {
        return $query->where('service_area', 'project');
    }

    /**
     * Scope to get only service categories.
     */
    public function scopeServiceArea($query)
    {
        return $query->where('service_area', 'service');
    }

    /**
     * Scope to get only news categories.
     */
    public function scopeNewsArea($query)
    {
        return $query->where('service_area', 'news');
    }

    /**
     * Scope to filter by specific service area.
     */
    public function scopeByServiceArea($query, $area)
    {
        return $query->where('service_area', $area);
    }

    /**
     * Get active categories ordered by order field.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get categories ordered by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}