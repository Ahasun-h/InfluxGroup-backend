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

        // Fetch all timeline items by looking for Journey_X_year keys in the database rows
        $timelineItems = [];
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

        return view('admin.journey.index', compact('journeyItems', 'timelineItems'));
    }

    /**
     * Update the journey section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle deletion if requested
        if ($request->has('delete_timeline')) {
            $deleteId = (int) $request->delete_timeline;
            
            // Get all current timeline items
            $currentItems = ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'like', 'Journey_%')
                ->get()
                ->groupBy(function($item) {
                    preg_match('/Journey_(\d+)_/', $item->section_item_name, $matches);
                    return $matches[1] ?? 0;
                });

            $items = [];
            foreach ($currentItems as $id => $rows) {
                if ((int)$id !== $deleteId && (int)$id > 0) {
                    $rowsByKey = $rows->keyBy('section_item_name');
                    $items[] = [
                        'year' => $rowsByKey["Journey_{$id}_year"]->section_content ?? '',
                        'title' => $rowsByKey["Journey_{$id}_title"]->section_content ?? '',
                        'description' => $rowsByKey["Journey_{$id}_description"]->section_content ?? '',
                    ];
                }
            }
            
            // Delete ALL current Journey items to rebuild cleanly
            ContentManagement::where('section_name', 'journey')
                ->where('section_item_name', 'like', 'Journey_%')
                ->delete();
            
            // Re-insert remaining items with new indices
            foreach ($items as $idx => $item) {
                $newId = $idx + 1;
                ContentManagement::create(['section_name' => 'journey', 'section_item_name' => "Journey_{$newId}_year", 'section_content' => $item['year']]);
                ContentManagement::create(['section_name' => 'journey', 'section_item_name' => "Journey_{$newId}_title", 'section_content' => $item['title']]);
                ContentManagement::create(['section_name' => 'journey', 'section_item_name' => "Journey_{$newId}_description", 'section_content' => $item['description']]);
            }
            
            return redirect()->route('admin.journey.index')
                ->with('success', 'Journey milestone deleted and timeline re-ordered.');
        }

        // Update basic info
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                ['section_name' => 'journey', 'section_item_name' => 'journey_title'],
                ['section_content' => $request->title]
            );
        }

        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                ['section_name' => 'journey', 'section_item_name' => 'journey_description'],
                ['section_content' => $request->description]
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
            if ($request->has("timeline{$i}_year")) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'journey', 'section_item_name' => "Journey_{$i}_year"],
                    ['section_content' => $request->input("timeline{$i}_year")]
                );
            }
            if ($request->has("timeline{$i}_title")) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'journey', 'section_item_name' => "Journey_{$i}_title"],
                    ['section_content' => $request->input("timeline{$i}_title")]
                );
            }
            if ($request->has("timeline{$i}_description")) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'journey', 'section_item_name' => "Journey_{$i}_description"],
                    ['section_content' => $request->input("timeline{$i}_description")]
                );
            }
        }

        return redirect()->route('admin.journey.index')
            ->with('success', 'Journey section updated successfully.');
    }
}



