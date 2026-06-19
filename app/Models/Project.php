<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'capacity',
        'type',
        'category',
        'status',
        'completion',
        'client',
        'value',
        'start_date',
        'expected_completion',
        'image',
        'images',
        'scope',
        'highlights',
        'stats',
        'featured',
    ];

    protected $casts = [
        'images' => 'array',
        'scope' => 'array',
        'highlights' => 'array',
        'stats' => 'array',
        'featured' => 'boolean',
        'start_date' => 'date',
        'expected_completion' => 'date',
        'value' => 'decimal:2',
    ];

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the category that owns the project.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
