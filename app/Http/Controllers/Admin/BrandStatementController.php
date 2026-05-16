<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BrandStatementController extends Controller
{
    /**
     * Display the brand statement management page
     */
    public function index(): View
    {
        // Get or create brand statement items
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_title'
            ],
            [
                'section_content' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_description'
            ],
            [
                'section_content' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $image = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_image'
            ],
            [
                'section_content' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $overlayTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_title'
            ],
            [
                'section_content' => 'Core Reliability',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $overlayText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_text'
            ],
            [
                'section_content' => 'Zero Downtime Operation Protocols',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Create stats items
        $stat1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat1'
            ],
            [
                'section_content' => json_encode(['value' => '45+', 'label' => 'Years Experience', 'order' => 1]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat2'
            ],
            [
                'section_content' => json_encode(['value' => '15GW', 'label' => 'Power Generated', 'order' => 2]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat3 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat3'
            ],
            [
                'section_content' => json_encode(['value' => '250+', 'label' => 'Global Clients', 'order' => 3]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat4 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat4'
            ],
            [
                'section_content' => json_encode(['value' => '500+', 'label' => 'Technical Staff', 'order' => 4]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all brand statement items for the view
        $brandItems = ContentManagement::where('section_name', 'brand_statements_section')
            ->get()
            ->keyBy('section_item_name');

        return view('admin.brand-statements.index', compact('brandItems'));
    }

    /**
     * Update the brand statement
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_title'
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
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle image URL update
        if ($request->has('image_url')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_image'
                ],
                [
                    'section_content' => $request->image_url,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay title update
        if ($request->has('overlay_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_title'
                ],
                [
                    'section_content' => $request->overlay_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay text update
        if ($request->has('overlay_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_text'
                ],
                [
                    'section_content' => $request->overlay_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle stats updates
        for ($i = 1; $i <= 4; $i++) {
            $statValue = $request->input("stat{$i}_value");
            $statLabel = $request->input("stat{$i}_label");

            if ($statValue || $statLabel) {
                $statData = [
                    'value' => $statValue,
                    'label' => $statLabel,
                    'order' => $i
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'brand_statements_section',
                        'section_item_name' => "brand_statements_stat{$i}"
                    ],
                    [
                        'section_content' => json_encode($statData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.brand-statements.index')
            ->with('success', 'Brand statement updated successfully.');
    }
}
