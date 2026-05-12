<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'hero_sections';

    protected $fillable = [
        'badge',
        'title',
        'description',
        'cta_buttons',
        'background_image',
        'categories',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cta_buttons' => 'array',
        'categories' => 'array'
    ];

    /**
     * Get the active hero section
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get primary CTA button
     */
    public function getPrimaryCtaAttribute()
    {
        return collect($this->cta_buttons)->firstWhere('type', 'primary');
    }

    /**
     * Get secondary CTA button
     */
    public function getSecondaryCtaAttribute()
    {
        return collect($this->cta_buttons)->firstWhere('type', 'secondary');
    }

    /**
     * Get categories sorted by order
     */
    public function getSortedCategoriesAttribute()
    {
        return collect($this->categories)->sortBy('order')->values();
    }

    /**
     * Get a specific category by order
     */
    public function getCategoryByOrder($order)
    {
        return collect($this->categories)->firstWhere('order', $order);
    }

    /**
     * Update CTA button
     */
    public function updateCtaButton($type, $text, $link)
    {
        $ctaButtons = $this->cta_buttons ?? [];
        $index = collect($ctaButtons)->search(function($button) use ($type) {
            return $button['type'] === $type;
        });

        if ($index !== false) {
            $ctaButtons[$index]['text'] = $text;
            $ctaButtons[$index]['link'] = $link;
        } else {
            $ctaButtons[] = [
                'type' => $type,
                'text' => $text,
                'link' => $link,
                'order' => count($ctaButtons) + 1
            ];
        }

        $this->cta_buttons = $ctaButtons;
        $this->save();
    }

    /**
     * Update category by order
     */
    public function updateCategory($order, $data)
    {
        $categories = $this->categories ?? [];
        $index = collect($categories)->search(function($category) use ($order) {
            return $category['order'] == $order;
        });

        if ($index !== false) {
            $categories[$index] = array_merge($categories[$index], $data);
        } else {
            $categories[] = array_merge($data, ['order' => $order]);
        }

        $this->categories = $categories;
        $this->save();
    }

    /**
     * Add new category
     */
    public function addCategory($title, $subtitle, $icon, $link = null)
    {
        $categories = $this->categories ?? [];
        $maxOrder = collect($categories)->max('order') ?? 0;

        $categories[] = [
            'title' => $title,
            'subtitle' => $subtitle,
            'icon' => $icon,
            'link' => $link,
            'order' => $maxOrder + 1
        ];

        $this->categories = $categories;
        $this->save();
    }

    /**
     * Remove category by order
     */
    public function removeCategory($order)
    {
        $categories = $this->categories ?? [];
        $categories = collect($categories)->filter(function($category) use ($order) {
            return $category['order'] != $order;
        })->values()->toArray();

        $this->categories = $categories;
        $this->save();
    }

    /**
     * Reorder categories
     */
    public function reorderCategories($newOrder)
    {
        $categories = $this->categories ?? [];
        $reordered = [];

        foreach ($newOrder as $order => $categoryData) {
            $category = collect($categories)->firstWhere('order', $categoryData['old_order']);
            if ($category) {
                $category['order'] = $order + 1;
                $reordered[] = $category;
            }
        }

        $this->categories = $reordered;
        $this->save();
    }
}
