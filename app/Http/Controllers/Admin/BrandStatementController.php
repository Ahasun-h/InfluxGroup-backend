<?php

namespace App\Http\Controllers\Admin;

use App\Models\BrandStatement;
use Illuminate\Http\Request;

class BrandStatementController extends BaseSectionController
{
    protected function getModelClass()
    {
        return BrandStatement::class;
    }

    protected function getViewsPrefix()
    {
        return 'brand-statements';
    }

    protected function getRoutePrefix()
    {
        return 'admin.brand-statements';
    }

    protected function getValidationRules(Request $request)
    {
        return [
            'title' => 'nullable|string|max:500',
            'status' => 'in:publish,draft',
            'description' => 'nullable|string|max:2000',
            'stats' => 'nullable|array',
            'stats.*.value' => 'required|string|max:255',
            'stats.*.label' => 'required|string|max:255',
            'stats.*.order' => 'required|integer',
            'image_url' => 'nullable|string|max:500',
            'overlay_title' => 'nullable|string|max:255',
            'overlay_text' => 'nullable|string|max:500',
        ];
    }

    protected function getStoragePath()
    {
        return 'brand-statements';
    }

    protected function getSuccessMessage($action)
    {
        return "Brand statement {$action} successfully.";
    }

    public function index()
    {
        // Check if required columns exist in hero_sections table
        $hasBrandStatementColumns = \Schema::hasColumn('hero_sections', 'stats') &&
                                   \Schema::hasColumn('hero_sections', 'image_url') &&
                                   \Schema::hasColumn('hero_sections', 'overlay_title') &&
                                   \Schema::hasColumn('hero_sections', 'overlay_text');

        if (!$hasBrandStatementColumns) {
            // Columns don't exist yet - show error message with instructions
            return view('admin.brand-statements.migration-needed');
        }

        // Columns exist, proceed with normal logic
        try {
            $tableExists = \Schema::hasTable('Content_management_table');

            if ($tableExists) {
                // Using new Content_management_table
                $brandStatement = BrandStatement::firstOrCreate(
                    ['section_key' => 'brand_statement'],
                    [
                        'title' => 'Brand Statement',
                        'type' => 'section',
                        'status' => 'publish',
                        'order' => 2,
                        'content_data' => [
                            'title' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
                            'description' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                            'stats' => [
                                ['value' => '45+', 'label' => 'Years Experience', 'order' => 1],
                                ['value' => '1200+', 'label' => 'Projects Delivered', 'order' => 2],
                                ['value' => 'ISO', 'label' => 'Certified Company', 'order' => 3],
                                ['value' => '500+', 'label' => 'Expert Engineers', 'order' => 4]
                            ],
                            'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                            'overlay_title' => 'Core Reliability',
                            'overlay_text' => 'Zero Downtime Operation Protocols'
                        ]
                    ]
                );
            } else {
                // Using existing hero_sections table
                $brandStatement = BrandStatement::firstOrCreate(
                    ['title' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING'],
                    [
                        'badge' => null,
                        'description' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                        'stats' => json_encode([
                            ['value' => '45+', 'label' => 'Years Experience', 'order' => 1],
                            ['value' => '1200+', 'label' => 'Projects Delivered', 'order' => 2],
                            ['value' => 'ISO', 'label' => 'Certified Company', 'order' => 3],
                            ['value' => '500+', 'label' => 'Expert Engineers', 'order' => 4]
                        ]),
                        'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                        'overlay_title' => 'Core Reliability',
                        'overlay_text' => 'Zero Downtime Operation Protocols',
                        'cta_buttons' => null,
                        'background_image' => null,
                        'categories' => null,
                        'is_active' => true
                    ]
                );
            }
        } catch (\Exception $e) {
            // Fallback to hero_sections table
            $brandStatement = BrandStatement::firstOrCreate(
                ['title' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING'],
                [
                    'badge' => null,
                    'description' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                    'stats' => json_encode([
                        ['value' => '45+', 'label' => 'Years Experience', 'order' => 1],
                        ['value' => '1200+', 'label' => 'Projects Delivered', 'order' => 2],
                        ['value' => 'ISO', 'label' => 'Certified Company', 'order' => 3],
                        ['value' => '500+', 'label' => 'Expert Engineers', 'order' => 4]
                    ]),
                    'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                    'overlay_title' => 'Core Reliability',
                    'overlay_text' => 'Zero Downtime Operation Protocols',
                    'cta_buttons' => null,
                    'background_image' => null,
                    'categories' => null,
                    'is_active' => true
                ]
            );
        }

        return view('admin.brand-statements.index', compact('brandStatement'));
    }

    public function edit($id)
    {
        $brandStatement = BrandStatement::withoutGlobalScope('brand_statement')->findOrFail($id);
        return view('admin.brand-statements.edit', compact('brandStatement'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->getValidationRules($request));

        $brandStatement = BrandStatement::withoutGlobalScope('brand_statement')->findOrFail($id);

        // Check which table we're using
        $usingNewTable = \Schema::hasTable('Content_management_table');

        if ($usingNewTable) {
            // Update basic fields
            $brandStatement->update([
                'title' => $validated['title'] ?? $brandStatement->title,
                'status' => $validated['status'] ?? $brandStatement->status,
            ]);

            // Update content_data
            $contentData = $brandStatement->content_data ?? [];

            // Handle stats data
            if (isset($validated['stats']) && is_array($validated['stats'])) {
                $stats = [];
                foreach ($validated['stats'] as $stat) {
                    if (!empty($stat['value']) && !empty($stat['label'])) {
                        $stats[] = [
                            'value' => $stat['value'],
                            'label' => $stat['label'],
                            'order' => $stat['order'] ?? count($stats) + 1
                        ];
                    }
                }
                $contentData['stats'] = $stats;
            }

            // Update other content fields
            if (isset($validated['description'])) {
                $contentData['description'] = $validated['description'];
            }
            if (isset($validated['image_url'])) {
                $contentData['image_url'] = $validated['image_url'];
            }
            if (isset($validated['overlay_title'])) {
                $contentData['overlay_title'] = $validated['overlay_title'];
            }
            if (isset($validated['overlay_text'])) {
                $contentData['overlay_text'] = $validated['overlay_text'];
            }

            $brandStatement->update(['content_data' => $contentData]);
        } else {
            // Using hero_sections table - update directly
            $updateData = [
                'title' => $validated['title'] ?? $brandStatement->title,
            ];

            // Handle stats data
            if (isset($validated['stats']) && is_array($validated['stats'])) {
                $stats = [];
                foreach ($validated['stats'] as $stat) {
                    if (!empty($stat['value']) && !empty($stat['label'])) {
                        $stats[] = [
                            'value' => $stat['value'],
                            'label' => $stat['label'],
                            'order' => $stat['order'] ?? count($stats) + 1
                        ];
                    }
                }
                $updateData['stats'] = json_encode($stats);
            }

            // Update other fields
            if (isset($validated['description'])) {
                $updateData['description'] = $validated['description'];
            }
            if (isset($validated['image_url'])) {
                $updateData['image_url'] = $validated['image_url'];
            }
            if (isset($validated['overlay_title'])) {
                $updateData['overlay_title'] = $validated['overlay_title'];
            }
            if (isset($validated['overlay_text'])) {
                $updateData['overlay_text'] = $validated['overlay_text'];
            }

            $brandStatement->update($updateData);
        }

        return redirect()->route('admin.brand-statements.index')
            ->with('success', 'Brand statement updated successfully.');
    }
}
