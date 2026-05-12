<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends BaseSectionController
{
    protected function getModelClass()
    {
        return HeroSection::class;
    }

    protected function getViewsPrefix()
    {
        return 'hero-sections';
    }

    protected function getRoutePrefix()
    {
        return 'admin.hero-sections';
    }

    protected function getValidationRules(Request $request)
    {
        return [
            'badge' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:2000',
            'cta_buttons' => 'nullable|array',
            'cta_buttons.*.type' => 'required|string|in:primary,secondary',
            'cta_buttons.*.text' => 'required|string|max:255',
            'cta_buttons.*.link' => 'required|string|max:500',
            'cta_buttons.*.order' => 'required|integer',
            'background_image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*.title' => 'required|string|max:255',
            'categories.*.subtitle' => 'nullable|string|max:255',
            'categories.*.icon' => 'nullable|string',
            'categories.*.link' => 'required|string|max:500',
            'categories.*.order' => 'required|integer',
            'is_active' => 'boolean',
        ];
    }

    protected function getStoragePath()
    {
        return 'hero-sections';
    }

    protected function getSuccessMessage($action)
    {
        return "Hero section {$action} successfully.";
    }
}
