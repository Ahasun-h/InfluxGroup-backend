<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAndSolution extends Model
{
    use HasFactory;

    protected $table = 'services_and_solutions';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'overview',
        'icon',
        'type',
        'features',
        'process',
        'duration',
        'availability',
        'components',
        'applications',
        'benefits',
        'industries',
        'stats',
        'category_id',
        'category',
        'image',
        'gallery',
        'is_active',
        'order',
    ];

    protected $casts = [
        'type' => 'string',
        'features' => 'array',
        'process' => 'array',
        'components' => 'array',
        'applications' => 'array',
        'benefits' => 'array',
        'industries' => 'array',
        'stats' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the service/solution.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Scope to get only services.
     */
    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }

    /**
     * Scope to get only solutions.
     */
    public function scopeSolutions($query)
    {
        return $query->where('type', 'solution');
    }

    /**
     * Get active services/solutions ordered by order field.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get services/solutions ordered by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}