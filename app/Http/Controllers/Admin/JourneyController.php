<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JourneyController extends Controller
{
    /**
     * Display the journey timeline management page
     */
    public function index(): View
    {
        // Fetch all journey section items
        $journeyItemsData = ContentManagement::where('section_name', 'journey')
            ->get()
            ->keyBy('section_item_name');

        // Map content to the expected view format
        $journeyItems = [
            'journey_section_title' => (object)['section_content' => $journeyItemsData['journey_title']->section_content ?? 'Our Journey'],
            'journey_section_description' => (object)['section_content' => $journeyItemsData['journey_description']->section_content ?? 'Four decades of excellence in powering Bangladesh\'s development'],
        ];

        // Fetch timeline items - check if using new JSON format or old format
        $timelineItems = [];

        // Try new JSON format first (Journey_1, Journey_2, etc.)
        $i = 1;
        while (isset($journeyItemsData["Journey_{$i}"]) && $journeyItemsData["Journey_{$i}"]->section_content) {
            $jsonData = json_decode($journeyItemsData["Journey_{$i}"]->section_content, true);
            if ($jsonData && isset($jsonData['year'])) {
                $timelineItems[] = [
                    'order' => $i,
                    'year' => $jsonData['year'] ?? '',
                    'title' => $jsonData['title'] ?? '',
                    'description' => $jsonData['description'] ?? '',
                ];
            }
            $i++;
        }

        // If no JSON items found, try old format (Journey_X_year, Journey_X_title, Journey_X_description)
        if (empty($timelineItems)) {
            $i = 1;
            while (isset($journeyItemsData["Journey_{$i}_year"]) || isset($journeyItemsData["Journey_{$i}_title"])) {
                $timelineItems[] = [
                    'order' => $i,
                    'year' => $journeyItemsData["Journey_{$i}_year"]->section_content ?? '',
                    'title' => $journeyItemsData["Journey_{$i}_title"]->section_content ?? '',
                    'description' => $journeyItemsData["Journey_{$i}_description"]->section_content ?? '',
                ];
                $i++;
            }
        }

        // If no timeline items found, create defaults if table is empty for this section
        if (empty($timelineItems) && $journeyItemsData->isEmpty()) {
            $defaults = [
                ['year' => '1980', 'title' => 'Foundation', 'description' => 'Influx Group established as a small electrical contractor'],
                ['year' => '1995', 'title' => 'Expansion', 'description' => 'Entered power transmission and distribution sector'],
                ['year' => '2005', 'title' => 'Manufacturing', 'description' => 'Started manufacturing transformers and switchgear'],
                ['year' => '2015', 'title' => 'Renewables', 'description' => 'Diversified into solar and wind energy solutions'],
                ['year' => '2026', 'title' => 'Regional Hub', 'description' => 'Expanded operations across South Asia'],
            ];

            foreach ($defaults as $idx => $def) {
                $order = $idx + 1;
                $timelineItems[] = [
                    'order' => $order,
                    'year' => $def['year'],
                    'title' => $def['title'],
                    'description' => $def['description'],
                ];
            }
        }

        return view('admin.cms-section.journey-section', compact('journeyItems', 'timelineItems'));
    }

    /**
     * Update the journey section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle deletion if requested
        if ($request->has('delete_timeline')) {
            $deleteId = (int) $request->delete_timeline;

            // Get all current timeline items in JSON format
            $currentItems = ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'regexp', '^Journey_[0-9]+$')
                ->get()
                ->sortBy(function($item) {
                    preg_match('/Journey_(\d+)$/', $item->section_item_name, $matches);
                    return (int)($matches[1] ?? 0);
                });

            $items = [];
            foreach ($currentItems as $item) {
                preg_match('/Journey_(\d+)$/', $item->section_item_name, $matches);
                $id = (int)($matches[1] ?? 0);

                if ($id !== $deleteId && $id > 0) {
                    $jsonData = json_decode($item->section_content, true);
                    if ($jsonData) {
                        $items[] = $jsonData;
                    }
                }
            }

            // Delete ALL current Journey items to rebuild cleanly
            ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'regexp', '^Journey_[0-9]+$')
                ->delete();

            // Re-insert remaining items with new indices
            foreach ($items as $idx => $item) {
                $newId = $idx + 1;
                $item['order'] = $newId;
                ContentManagement::create([
                    'section_name' => 'journey',
                    'section_item_name' => "Journey_{$newId}",
                    'section_content' => json_encode($item),
                    'attributes' => null,
                    'media_files' => null
                ]);
            }

            return redirect()->route('admin.cms-section.journey-section')
                ->with('success', 'Journey milestone deleted and timeline re-ordered.');
        }

        // Update basic info
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                ['section_name' => 'journey', 'section_item_name' => 'journey_title'],
                ['section_content' => $request->title, 'attributes' => null, 'media_files' => null]
            );
        }

        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                ['section_name' => 'journey', 'section_item_name' => 'journey_description'],
                ['section_content' => $request->description, 'attributes' => null, 'media_files' => null]
            );
        }

        // Handle timeline updates/additions
        $allKeys = array_keys($request->all());
        $timelineIndices = [];
        foreach ($allKeys as $key) {
            if (preg_match('/^timeline(\d+)_year$/', $key, $matches)) {
                $timelineIndices[] = (int) $matches[1];
            }
        }
        $maxIndex = !empty($timelineIndices) ? max($timelineIndices) : 0;

        for ($i = 1; $i <= $maxIndex; $i++) {
            $year = $request->input("timeline{$i}_year");
            $title = $request->input("timeline{$i}_title");
            $description = $request->input("timeline{$i}_description");

            // Only create/update if at least one field has data
            if ($year || $title || $description) {
                $journeyData = [
                    'year' => $year ?? '',
                    'title' => $title ?? '',
                    'description' => $description ?? '',
                    'order' => $i
                ];

                ContentManagement::updateOrCreate(
                    ['section_name' => 'journey', 'section_item_name' => "Journey_{$i}"],
                    [
                        'section_content' => json_encode($journeyData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.cms-section.journey-section')
            ->with('success', 'Journey section updated successfully.');
    }
}



