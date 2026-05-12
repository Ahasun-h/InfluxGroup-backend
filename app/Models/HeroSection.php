<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_sections';

    protected $fillable = [
        'badge',
        'title',
        'description',
        'cta_buttons',
        'background_image',
        'categories',
        'is_active',
    ];

    protected $casts = [
        'cta_buttons' => 'array',
        'categories' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFirstCtaButtonAttribute()
    {
        return $this->cta_buttons[0] ?? null;
    }

    public function getSecondaryCtaButtonAttribute()
    {
        return $this->cta_buttons[1] ?? null;
    }

    public function getOrderedCategoriesAttribute()
    {
        return collect($this->categories ?? [])->sortBy('order')->values();
    }

    public function getPrimaryCtaButtonAttribute()
    {
        return collect($this->cta_buttons ?? [])->firstWhere('type', 'primary');
    }
}
