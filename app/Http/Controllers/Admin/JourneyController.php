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
        // Get or create journey section title
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_section_title'
            ],
            [
                'section_content' => 'Our Journey',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create journey section description
        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_section_description'
            ],
            [
                'section_content' => 'Four decades of excellence in powering Bangladesh\'s development',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Create timeline items with default data
        $timeline1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_timeline1'
            ],
            [
                'section_content' => json_encode([
                    'year' => '1980',
                    'title' => 'Foundation',
                    'description' => 'Influx Group established as a small electrical contractor',
                    'order' => 1
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $timeline2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_timeline2'
            ],
            [
                'section_content' => json_encode([
                    'year' => '1995',
                    'title' => 'Expansion',
                    'description' => 'Entered power transmission and distribution sector',
                    'order' => 2
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $timeline3 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_timeline3'
            ],
            [
                'section_content' => json_encode([
                    'year' => '2005',
                    'title' => 'Manufacturing',
                    'description' => 'Started manufacturing transformers and switchgear',
                    'order' => 3
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $timeline4 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_timeline4'
            ],
            [
                'section_content' => json_encode([
                    'year' => '2015',
                    'title' => 'Renewables',
                    'description' => 'Diversified into solar and wind energy solutions',
                    'order' => 4
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $timeline5 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'journey_section',
                'section_item_name' => 'journey_timeline5'
            ],
            [
                'section_content' => json_encode([
                    'year' => '2026',
                    'title' => 'Regional Hub',
                    'description' => 'Expanded operations across South Asia',
                    'order' => 5
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all journey section items for the view
        $journeyItems = ContentManagement::where('section_name', 'journey_section')
            ->get()
            ->keyBy('section_item_name');

        // Get timeline items
        $timelineItems = [];
        for ($i = 1; $i <= 5; $i++) {
            $timelineKey = 'journey_timeline' . $i;
            if (isset($journeyItems[$timelineKey]) && $journeyItems[$timelineKey]->section_content) {
                $timelineData = json_decode($journeyItems[$timelineKey]->section_content, true);
                if ($timelineData) {
                    $timelineItems[] = $timelineData;
                }
            }
        }
        $timelineItems = collect($timelineItems)->sortBy('order')->values();

        return view('admin.journey.index', compact('journeyItems', 'timelineItems'));
    }

    /**
     * Update the journey section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'journey_section',
                    'section_item_name' => 'journey_section_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle description update
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'journey_section',
                    'section_item_name' => 'journey_section_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle timeline updates
        for ($i = 1; $i <= 5; $i++) {
            $timelineYear = $request->input("timeline{$i}_year");
            $timelineTitle = $request->input("timeline{$i}_title");
            $timelineDescription = $request->input("timeline{$i}_description");

            if ($timelineYear || $timelineTitle || $timelineDescription) {
                $timelineData = [
                    'year' => $timelineYear,
                    'title' => $timelineTitle,
                    'description' => $timelineDescription,
                    'order' => $i
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'journey_section',
                        'section_item_name' => "journey_timeline{$i}"
                    ],
                    [
                        'section_content' => json_encode($timelineData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.journey.index')
            ->with('success', 'Journey section updated successfully.');
    }
}
