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

        // Fetch all core values section items
        $data = ContentManagement::where('section_name', 'core_values')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['core_values_title']->section_content ?? 'Core Values',
            'subtitle' => $data['core_values_subtitle']->section_content ?? 'The principles that guide everything we do',
        ];

        // Try new JSON format first (core_value_1, core_value_2, etc.)
        $values = [];
        $i = 1;
        while (isset($data["core_value_{$i}"]) && $data["core_value_{$i}"]->section_content) {
            $jsonData = json_decode($data["core_value_{$i}"]->section_content, true);
            if ($jsonData && isset($jsonData['title'])) {
                $iconValue = $jsonData['icon'] ?? '';

                // Convert old icon names to SVG if needed
                $iconSvg = $iconValue;
                if (in_array($iconValue, ['ShieldCheck', 'Award', 'Users', 'TrendingUp', 'Zap', 'Target'])) {
                    $iconSvg = $this->getIconSvg($iconValue);
                }

                // Sanitize SVG to prevent rendering errors
                $iconSvg = $this->sanitizeSvg($iconSvg);

                $values[] = [
                    'id' => $i,
                    'title' => $jsonData['title'] ?? '',
                    'description' => $jsonData['description'] ?? '',
                    'icon' => $iconSvg,
                ];
            }
            $i++;
        }

        // If no JSON items found, try old format (core_value_X_title, core_value_X_description, core_value_X_icon)
        if (empty($values)) {
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
        }

        // If still no values, create defaults
        if (empty($values)) {
            $defaultValues = [
                [
                    'title' => 'Safety First',
                    'description' => 'Zero-compromise approach to workplace and operational safety',
                    'icon' => 'ShieldCheck'
                ],
                [
                    'title' => 'Quality Excellence',
                    'description' => 'ISO 9001:2015 certified processes and international standards',
                    'icon' => 'Award'
                ],
                [
                    'title' => 'Customer Focus',
                    'description' => 'Dedicated to delivering beyond client expectations',
                    'icon' => 'Users'
                ],
                [
                    'title' => 'Innovation Driven',
                    'description' => 'Continuous investment in R&D and cutting-edge technology',
                    'icon' => 'TrendingUp'
                ]
            ];

            foreach ($defaultValues as $idx => $val) {
                $id = $idx + 1;
                $iconSvg = $this->getIconSvg($val['icon']);

                $values[] = [
                    'id' => $id,
                    'title' => $val['title'],
                    'description' => $val['description'],
                    'icon' => $iconSvg,
                ];
            }
        }

        return view('admin.cms-section.core-values-section', compact('content', 'values'));
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

                // Get all current core value items in JSON format
                $currentItems = ContentManagement::where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->get()
                    ->sortBy(function($item) {
                        preg_match('/core_value_(\d+)$/', $item->section_item_name, $matches);
                        return (int)($matches[1] ?? 0);
                    });

                $remainingItems = [];
                foreach ($currentItems as $item) {
                    preg_match('/core_value_(\d+)$/', $item->section_item_name, $matches);
                    $id = (int)($matches[1] ?? 0);

                    if ($id !== $deleteId && $id > 0) {
                        $jsonData = json_decode($item->section_content, true);
                        if ($jsonData) {
                            $remainingItems[] = $jsonData;
                        }
                    }
                }

                // Delete ALL current core_value items to rebuild cleanly
                ContentManagement::where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->delete();

                // Re-insert remaining items with new indices
                foreach ($remainingItems as $idx => $item) {
                    $newId = $idx + 1;
                    ContentManagement::create([
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$newId}",
                        'section_content' => json_encode($item),
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

                // Store icon name only, not full SVG
                $iconName = $val['icon'] ?? 'ShieldCheck';

                $coreValueData = [
                    'title' => $val['title'] ?? '',
                    'description' => $val['description'] ?? '',
                    'icon' => $iconName,
                    'order' => (int)$id
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'core_values',
                        'section_item_name' => "core_value_{$id}"
                    ],
                    [
                        'section_content' => json_encode($coreValueData),
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
