<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandStatement extends Model
{
    use HasFactory;

    // Temporary: Use hero_sections table until migration runs
    protected $table = 'hero_sections';

    protected $fillable = [
        'section_key',
        'title',
        'type',
        'status',
        'order',
        'content_data',
        'badge',
        'description',
        'cta_buttons',
        'background_image',
        'categories',
        'stats',
        'image_url',
        'overlay_title',
        'overlay_text',
        'is_active',
    ];

    protected $casts = [
        'content_data' => 'array',
        'stats' => 'array',
        'cta_buttons' => 'array',
        'categories' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Override getTable to use Content_management_table if it exists
     */
    public function getTable()
    {
        // Check if Content_management_table exists
        try {
            $tableExists = \Schema::hasTable('Content_management_table');
            if ($tableExists) {
                return 'Content_management_table';
            }
        } catch (\Exception $e) {
            // Fall back to hero_sections
        }

        return 'hero_sections';
    }

    /**
     * Boot method to add global scope for brand_statement section type
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('brand_statement', function ($query) {
            try {
                $tableExists = \Schema::hasTable('Content_management_table');
                if ($tableExists) {
                    $query->where('section_key', 'brand_statement');
                } else {
                    // For hero_sections table, create a brand statement record if it doesn't exist
                    $query->where('id', function($q) {
                        $q->from('hero_sections as hs')
                          ->where('hs.title', 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING')
                          ->select('hs.id');
                    });
                }
            } catch (\Exception $e) {
                // Fallback behavior
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'publish')
                     ->orWhere('is_active', true);
    }

    /**
     * Get brand statement content - works with both tables
     */
    public function getStatsAttribute()
    {
        // Check if we're using the new table
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data['stats'] ?? [];
        }

        // Using hero_sections table
        return $this->attributes['stats'] ?? [];
    }

    public function getDescriptionAttribute()
    {
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data['description'] ?? '';
        }
        return $this->attributes['description'] ?? '';
    }

    public function getImageUrlAttribute()
    {
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data['image_url'] ?? '';
        }
        return $this->attributes['image_url'] ?? '';
    }

    public function getOverlayTitleAttribute()
    {
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data['overlay_title'] ?? '';
        }
        return $this->attributes['overlay_title'] ?? '';
    }

    public function getOverlayTextAttribute()
    {
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data['overlay_text'] ?? '';
        }
        return $this->attributes['overlay_text'] ?? '';
    }

    public function getOrderedStatsAttribute()
    {
        return collect($this->stats ?? [])->sortBy('order')->values();
    }

    public function getFirstTwoStatsAttribute()
    {
        return collect($this->stats ?? [])->sortBy('order')->take(2)->values();
    }
}
