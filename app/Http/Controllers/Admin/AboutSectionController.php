<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends BaseSectionController
{
    protected function getModelClass()
    {
        return AboutSection::class;
    }

    protected function getViewsPrefix()
    {
        return 'about-sections';
    }

    protected function getRoutePrefix()
    {
        return 'admin.about-sections';
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
            'content_blocks' => 'nullable|array',
            'content_blocks.*.title' => 'required|string|max:255',
            'content_blocks.*.description' => 'required|string|max:1000',
            'content_blocks.*.icon' => 'nullable|string',
            'content_blocks.*.order' => 'required|integer',
            'is_active' => 'boolean',
        ];
    }

    protected function getStoragePath()
    {
        return 'about-sections';
    }

    protected function getSuccessMessage($action)
    {
        return "About section {$action} successfully.";
    }
}
