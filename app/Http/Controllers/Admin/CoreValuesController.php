<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CoreValuesController extends Controller
{
    /**
     * Display the core values management page
     */
    public function index(): View
    {
        // Get or create section title
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'core_values',
                'section_item_name' => 'core_values_title'
            ],
            [
                'section_content' => 'Core Values',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create section subtitle
        $subtitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'core_values',
                'section_item_name' => 'core_values_subtitle'
            ],
            [
                'section_content' => 'The principles that guide everything we do',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create core value items (dynamically create up to 6 default values)
        $defaultValues = [
            [
                'title' => 'Integrity',
                'description' => 'We maintain the highest standards of ethical conduct in all our business operations.',
                'icon' => 'ShieldCheck'
            ],
            [
                'title' => 'Excellence',
                'description' => 'We deliver exceptional quality and technical precision in every project we undertake.',
                'icon' => 'Award'
            ],
            [
                'title' => 'Collaboration',
                'description' => 'We work together with clients and partners to achieve shared success.',
                'icon' => 'Users'
            ],
            [
                'title' => 'Innovation',
                'description' => 'We embrace cutting-edge technology and creative solutions for complex challenges.',
                'icon' => 'TrendingUp'
            ]
        ];

        for ($i = 1; $i <= count($defaultValues); $i++) {
            $valueData = $defaultValues[$i - 1];

            // Create title
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$i}_title"
                ],
                [
                    'section_content' => $valueData['title'],
                    'attributes' => null,
                    'media_files' => null
                ]
            );

            // Create description
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$i}_description"
                ],
                [
                    'section_content' => $valueData['description'],
                    'attributes' => null,
                    'media_files' => null
                ]
            );

            // Create icon
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$i}_icon"
                ],
                [
                    'section_content' => $valueData['icon'],
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Fetch all core values section items
        $data = ContentManagement::where('section_name', 'core_values')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['core_values_title']->section_content ?? 'Core Values',
            'subtitle' => $data['core_values_subtitle']->section_content ?? 'The principles that guide everything we do',
        ];

        $values = [];
        $i = 1;
        while (isset($data["core_value_{$i}_title"])) {
            $values[] = [
                'id' => $i,
                'title' => $data["core_value_{$i}_title"]->section_content ?? '',
                'description' => $data["core_value_{$i}_description"]->section_content ?? '',
                'icon' => $data["core_value_{$i}_icon"]->section_content ?? 'ShieldCheck',
            ];
            $i++;
        }

        return view('admin.core-values.index', compact('content', 'values'));
    }

    /**
     * Update the core values section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle deletion
        if ($request->has('delete_value')) {
            $deleteId = (int) $request->delete_value;

            $currentData = ContentManagement::where('section_name', 'core_values')
                ->where('section_item_name', 'like', 'core_value_%')
                ->get()
                ->groupBy(function($item) {
                    preg_match('/core_value_(\d+)_/', $item->section_item_name, $matches);
                    return $matches[1] ?? 0;
                });

            $remainingItems = [];
            foreach ($currentData as $id => $rows) {
                if ((int)$id !== $deleteId && (int)$id > 0) {
                    $rowsByKey = $rows->keyBy('section_item_name');
                    $remainingItems[] = [
                        'title' => $rowsByKey["core_value_{$id}_title"]->section_content ?? '',
                        'description' => $rowsByKey["core_value_{$id}_description"]->section_content ?? '',
                        'icon' => $rowsByKey["core_value_{$id}_icon"]->section_content ?? '',
                    ];
                }
            }

            ContentManagement::where('section_name', 'core_values')
                ->where('section_item_name', 'like', 'core_value_%')
                ->delete();

            foreach ($remainingItems as $idx => $item) {
                $newId = $idx + 1;
                ContentManagement::create([
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$newId}_title",
                    'section_content' => $item['title'],
                    'attributes' => null,
                    'media_files' => null
                ]);
                ContentManagement::create([
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$newId}_description",
                    'section_content' => $item['description'],
                    'attributes' => null,
                    'media_files' => null
                ]);
                ContentManagement::create([
                    'section_name' => 'core_values',
                    'section_item_name' => "core_value_{$newId}_icon",
                    'section_content' => $item['icon'],
                    'attributes' => null,
                    'media_files' => null
                ]);
            }

            return redirect()->route('admin.core-values.index')->with('success', 'Core value deleted successfully.');
        }

        // Update section title
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'core_values',
                    'section_item_name' => 'core_values_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update section subtitle
        if ($request->has('subtitle')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'core_values',
                    'section_item_name' => 'core_values_subtitle'
                ],
                [
                    'section_content' => $request->subtitle,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update core value items
        if ($request->has('values')) {
            foreach ($request->values as $id => $val) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$id}_title"
                    ],
                    [
                        'section_content' => $val['title'],
                        'attributes' => null,
                        'media_files' => null
                    ]
                );

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$id}_description"
                    ],
                    [
                        'section_content' => $val['description'],
                        'attributes' => null,
                        'media_files' => null
                    ]
                );

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$id}_icon"
                    ],
                    [
                        'section_content' => $val['icon'] ?? 'ShieldCheck',
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.core-values.index')->with('success', 'Core values updated successfully.');
    }
}
