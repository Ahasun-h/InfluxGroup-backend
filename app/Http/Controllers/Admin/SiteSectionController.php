<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    /**
     * Display all site sections
     */
    public function index(): View
    {
        $sections = SiteSection::ordered()->get();
        return view('admin.site-sections.index', compact('sections'));
    }

    /**
     * Show a specific section for editing
     */
    public function edit($sectionKey): View
    {
        $section = SiteSection::where('section_key', $sectionKey)->firstOrFail();

        // Get the appropriate view based on section type
        $view = $this->getSectionView($sectionKey);

        return view($view, [
            'section' => $section,
            'content' => $section->getContentData()
        ]);
    }

    /**
     * Update a section
     */
    public function update(Request $request, $sectionKey)
    {
        $section = SiteSection::where('section_key', $sectionKey)->firstOrFail();

        // Validate based on section type
        $rules = $this->getValidationRules($sectionKey);
        $validated = $request->validate($rules);

        // Update the section metadata
        $section->update([
            'title' => $validated['title'] ?? $section->title,
            'status' => $validated['status'] ?? $section->status,
        ]);

        // Save content data (this would typically save to JSON files or another table)
        $this->saveSectionContent($sectionKey, $validated);

        return redirect()->route('admin.site-sections.edit', $sectionKey)
            ->with('success', ucfirst(str_replace('_', ' ', $sectionKey)) . ' updated successfully.');
    }

    /**
     * Toggle section status
     */
    public function toggleStatus($sectionKey)
    {
        $section = SiteSection::where('section_key', $sectionKey)->firstOrFail();
        $section->update([
            'status' => $section->status === 'publish' ? 'draft' : 'publish'
        ]);

        return redirect()->route('admin.site-sections.index')
            ->with('success', 'Section status updated successfully.');
    }

    /**
     * Get the appropriate view for each section type
     */
    protected function getSectionView($sectionKey)
    {
        return match($sectionKey) {
            'hero_section' => 'admin.site-sections.hero',
            'brand_statement' => 'admin.site-sections.brand-statement',
            default => 'admin.site-sections.generic'
        };
    }

    /**
     * Get validation rules for each section type
     */
    protected function getValidationRules($sectionKey)
    {
        return match($sectionKey) {
            'hero_section' => [
                'title' => 'nullable|string|max:255',
                'status' => 'in:publish,draft',
                'badge' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:2000',
                'cta_buttons' => 'nullable|array',
                'background_image' => 'nullable|string|max:500',
                'categories' => 'nullable|array',
            ],
            'brand_statement' => [
                'title' => 'nullable|string|max:500',
                'status' => 'in:publish,draft',
                'description' => 'nullable|string|max:2000',
                'stats' => 'nullable|array',
                'image_url' => 'nullable|string|max:500',
                'overlay_title' => 'nullable|string|max:255',
                'overlay_text' => 'nullable|string|max:500',
            ],
            default => [
                'title' => 'nullable|string|max:255',
                'status' => 'in:publish,draft',
            ]
        };
    }

    /**
     * Save section content (placeholder - would save to JSON files or database)
     */
    protected function saveSectionContent($sectionKey, $data)
    {
        // This is a placeholder implementation
        // In a real system, this would save to:
        // - JSON files in storage/app/sections/
        // - A separate content_data table
        // - Configuration files

        $contentData = array_intersect_key($data, array_flip($this->getContentFields($sectionKey)));

        // For now, we'll just log it
        // In production, implement proper storage
        \Log::info("Saving content for {$sectionKey}", $contentData);
    }

    /**
     * Get content fields for each section type
     */
    protected function getContentFields($sectionKey)
    {
        return match($sectionKey) {
            'hero_section' => ['badge', 'description', 'cta_buttons', 'background_image', 'categories'],
            'brand_statement' => ['description', 'stats', 'image_url', 'overlay_title', 'overlay_text'],
            default => []
        };
    }
}
