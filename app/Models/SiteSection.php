<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    use HasFactory;

    protected $table = 'Content_management_table';

    protected $fillable = [
        'section_key',
        'title',
        'type',
        'status',
        'order',
        'content_data',
    ];

    protected $casts = [
        'content_data' => 'array',
    ];

    /**
     * Override getTable to handle missing Content_management_table
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
            // Fall back to hero_sections if content table doesn't exist
        }

        return 'hero_sections';
    }

    /**
     * Get section by key
     */
    public static function getByKey($key)
    {
        return static::where('section_key', $key)->first();
    }

    /**
     * Get published sections
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish')
                    ->orWhere('is_active', true);
    }

    /**
     * Get sections ordered by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Check if section is published
     */
    public function isPublished()
    {
        return $this->status === 'publish' || $this->is_active;
    }

    /**
     * Get content data for this section from content_data JSON column
     */
    public function getContentData()
    {
        // If using Content_management_table, return content_data
        if ($this->getTable() === 'Content_management_table') {
            return $this->content_data ?? [];
        }

        // If using hero_sections, create content_data structure
        return [
            'title' => $this->title ?? '',
            'description' => $this->description ?? '',
            'cta_buttons' => $this->cta_buttons ?? [],
            'background_image' => $this->background_image ?? '',
            'categories' => $this->categories ?? [],
            'stats' => $this->stats ?? [],
            'image_url' => $this->image_url ?? '',
            'overlay_title' => $this->overlay_title ?? '',
            'overlay_text' => $this->overlay_text ?? '',
        ];
    }

    /**
     * Get a specific field from content_data
     */
    public function getContentField($field, $default = null)
    {
        $contentData = $this->getContentData();
        return $contentData[$field] ?? $default;
    }

    /**
     * Update content data
     */
    public function updateContentData(array $data)
    {
        if ($this->getTable() === 'Content_management_table') {
            $currentContent = $this->content_data ?? [];
            $updatedContent = array_merge($currentContent, $data);
            $this->update(['content_data' => $updatedContent]);
        } else {
            // Using hero_sections, update fields directly
            $this->update($data);
        }
    }
}
