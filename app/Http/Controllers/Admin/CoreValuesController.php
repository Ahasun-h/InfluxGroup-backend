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
                'icon' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
            ],
            [
                'title' => 'Excellence',
                'description' => 'We deliver exceptional quality and technical precision in every project we undertake.',
                'icon' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8l-4 4m0 0l4 4m-4-4h12M8 12H4M12 2v4M12 18v4M8 8l4-4M16 8l-4 4"></path></svg>'
            ],
            [
                'title' => 'Collaboration',
                'description' => 'We work together with clients and partners to achieve shared success.',
                'icon' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
            ],
            [
                'title' => 'Innovation',
                'description' => 'We embrace cutting-edge technology and creative solutions for complex challenges.',
                'icon' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>'
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

            // Create icon with SVG
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
            $iconValue = $data["core_value_{$i}_icon"]->section_content ?? '';

            // Convert old icon names to SVG if needed
            $iconSvg = $iconValue;
            if (in_array($iconValue, ['ShieldCheck', 'Award', 'Users', 'TrendingUp', 'Zap', 'Target'])) {
                $iconSvg = $this->getIconSvg($iconValue);
            }

            // Sanitize SVG to prevent rendering errors
            $iconSvg = $this->sanitizeSvg($iconSvg);

            $values[] = [
                'id' => $i,
                'title' => $data["core_value_{$i}_title"]->section_content ?? '',
                'description' => $data["core_value_{$i}_description"]->section_content ?? '',
                'icon' => $iconSvg,
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
        // Handle deletion from new format
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'delete_value_') === 0 && !empty($value)) {
                $deleteId = (int) $value;

                \Log::info('Deleting core value ID: ' . $deleteId);

                $currentData = ContentManagement::where('section_name', 'core_values')
                    ->where('section_item_name', 'like', 'core_value_%')
                    ->get()
                    ->groupBy(function($item) {
                        preg_match('/core_value_(\d+)_/', $item->section_item_name, $matches);
                        return $matches[1] ?? 0;
                    });

                \Log::info('Current data count: ' . count($currentData));

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
            \Log::info('Processing values update', ['values' => $request->values]);

            foreach ($request->values as $id => $val) {
                \Log::info("Processing value ID: {$id}", ['value' => $val]);

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$id}_title"
                    ],
                    [
                        'section_content' => $val['title'] ?? '',
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
                        'section_content' => $val['description'] ?? '',
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
                        'section_content' => $val['icon'] ?? '',
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.core-values.index')->with('success', 'Core values updated successfully.');
    }

    /**
     * Get SVG for icon name (for backwards compatibility)
     */
    private function getIconSvg($iconName): string
    {
        $iconMap = [
            'ShieldCheck' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
            'Award' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8l-4 4m0 0l4 4m-4-4h12M8 12H4M12 2v4M12 18v4M8 8l4-4M16 8l-4 4"></path></svg>',
            'Users' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'TrendingUp' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'Zap' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
            'Target' => '<svg class="w-6 h-6 text-[#007bff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l4 4m0-4l-4 4m4-4v12m0 0l-4-4m4 4h12m-12 0a5 5 0 110-10 5 5 0 010 10z"></path></svg>',
        ];

        return $iconMap[$iconName] ?? $iconMap['ShieldCheck'];
    }

    /**
     * Sanitize SVG to prevent rendering errors
     */
    private function sanitizeSvg($svg): string
    {
        // If it's empty, return default shield icon
        if (empty($svg)) {
            return $this->getIconSvg('ShieldCheck');
        }

        // If it doesn't contain SVG tags, return default
        if (strpos($svg, '<svg') === false) {
            return $this->getIconSvg('ShieldCheck');
        }

        // Basic SVG sanitization - remove potentially harmful attributes
        $svg = preg_replace('/on\w+="[^"]*"/i', '', $svg);
        $svg = preg_replace('/javascript:/i', '', $svg);

        // Fix common SVG path issues
        $svg = preg_replace('/<path([^>]*)>/i', '<path$1>', $svg);

        // Ensure the SVG has proper structure
        if (strpos($svg, 'xmlns=') === false) {
            $svg = str_replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"', $svg);
        }

        return $svg;
    }
}
