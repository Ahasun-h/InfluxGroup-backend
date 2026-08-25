<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class NewsPageController extends Controller
{
    public function index(): View
    {
        $cmsData = $this->loadAllCmsData();
        return view('admin.cms-section.news-page', compact('cmsData'));
    }

    private function loadAllCmsData(): array
    {
        return [
            'hero' => $this->loadHeroSection(),
        ];
    }

    private function updateOrCreate(string $sectionName, string $itemName, array $values): ContentManagement
    {
        $item = ContentManagement::where('section_name', $sectionName)
            ->where('section_item_name', $itemName)
            ->where(function ($q) {
                $q->where('page_name', 'news_page')->orWhereNull('page_name');
            })->first();

        if ($item) {
            $item->update(array_merge(['page_name' => 'news_page'], $values));
            return $item;
        }

        return ContentManagement::create(array_merge([
            'page_name'         => 'news_page',
            'section_name'      => $sectionName,
            'section_item_name' => $itemName,
        ], $values));
    }

    private function loadHeroSection(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'news_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'news_hero')
            ->get()
            ->keyBy('section_item_name');

        return [
            'badge'       => $items['news_hero_badge']->section_content       ?? 'News & Updates',
            'title'       => $items['news_hero_title']->section_content       ?? 'LATEST <span class="text-industrial-blue">NEWS</span>',
            'description' => $items['news_hero_description']->section_content ?? 'Stay updated with the latest developments, achievements, and insights from Influx Group.',
        ];
    }

    public function update(Request $request, string $section): JsonResponse
    {
        try {
            if ($section === 'hero') {
                return $this->updateHeroSection($request);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid section name',
            ], 400);
        } catch (\Exception $e) {
            Log::error("Error updating News Page CMS section {$section}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save section data: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function updateHeroSection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge'       => 'nullable|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->has('badge')) {
            $this->updateOrCreate('news_hero', 'news_hero_badge', [
                'section_content' => $validated['badge'] ?? 'News & Updates',
                'field_type'      => 'text',
            ]);
        }

        if ($request->has('title')) {
            $this->updateOrCreate('news_hero', 'news_hero_title', [
                'section_content' => $validated['title'] ?? 'LATEST <span class="text-industrial-blue">NEWS</span>',
                'field_type'      => 'text',
            ]);
        }

        if ($request->has('description')) {
            $this->updateOrCreate('news_hero', 'news_hero_description', [
                'section_content' => $validated['description'] ?? 'Stay updated with the latest developments, achievements, and insights from Influx Group.',
                'field_type'      => 'textarea',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'News Hero Section updated successfully.',
            'data'    => $this->loadHeroSection(),
        ]);
    }
}
