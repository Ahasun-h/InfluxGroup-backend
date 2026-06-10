<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PartnersController extends Controller
{
    /**
     * Display the partners management page
     */
    public function index(): View
    {
        // Get or create section title
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'partners',
                'section_item_name' => 'partners_title'
            ],
            [
                'section_content' => 'Trusted by Industry Leaders',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create section subtitle
        $subtitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'partners',
                'section_item_name' => 'partners_subtitle'
            ],
            [
                'section_content' => 'Proud partner to government agencies, multinational corporations, and leading enterprises',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create partner items (dynamically create up to 6 default values)
        $defaultPartners = [
            [
                'name' => 'Power Grid Corp',
                'logo' => '⚡'
            ],
            [
                'name' => 'Energy Ministry',
                'logo' => '🏛️'
            ],
            [
                'name' => 'Tata Motors',
                'logo' => '🚗'
            ],
            [
                'name' => 'ABB Group',
                'logo' => '🔌'
            ],
            [
                'name' => 'Siemens Energy',
                'logo' => '💡'
            ],
            [
                'name' => 'GP Group',
                'logo' => '🏭'
            ]
        ];

        for ($i = 1; $i <= count($defaultPartners); $i++) {
            $partnerData = $defaultPartners[$i - 1];

            // Create name
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'partners',
                    'section_item_name' => "partner_{$i}_name"
                ],
                [
                    'section_content' => $partnerData['name'],
                    'attributes' => null,
                    'media_files' => null
                ]
            );

            // Create logo
            ContentManagement::firstOrCreate(
                [
                    'section_name' => 'partners',
                    'section_item_name' => "partner_{$i}_logo"
                ],
                [
                    'section_content' => $partnerData['logo'],
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Fetch all partners section items
        $data = ContentManagement::where('section_name', 'partners')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['partners_title']->section_content ?? 'Trusted by Industry Leaders',
            'subtitle' => $data['partners_subtitle']->section_content ?? 'Proud partner to government agencies, multinational corporations, and leading enterprises',
        ];

        $partners = [];
        $i = 1;
        while (isset($data["partner_{$i}_name"])) {
            $partners[] = [
                'id' => $i,
                'name' => $data["partner_{$i}_name"]->section_content ?? '',
                'logo' => $data["partner_{$i}_logo"]->section_content ?? '🏢',
            ];
            $i++;
        }

        return view('admin.partners.index', compact('content', 'partners'));
    }

    /**
     * Update the partners section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle deletion
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'delete_partner_') === 0 && !empty($value)) {
                $deleteId = (int) $value;

                $currentData = ContentManagement::where('section_name', 'partners')
                    ->where('section_item_name', 'like', 'partner_%')
                    ->get()
                    ->groupBy(function($item) {
                        preg_match('/partner_(\d+)_/', $item->section_item_name, $matches);
                        return $matches[1] ?? 0;
                    });

                $remainingItems = [];
                foreach ($currentData as $id => $rows) {
                    if ((int)$id !== $deleteId && (int)$id > 0) {
                        $rowsByKey = $rows->keyBy('section_item_name');
                        $remainingItems[] = [
                            'name' => $rowsByKey["partner_{$id}_name"]->section_content ?? '',
                            'logo' => $rowsByKey["partner_{$id}_logo"]->section_content ?? '',
                        ];
                    }
                }

                ContentManagement::where('section_name', 'partners')
                    ->where('section_item_name', 'like', 'partner_%')
                    ->delete();

                foreach ($remainingItems as $idx => $item) {
                    $newId = $idx + 1;
                    ContentManagement::create([
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$newId}_name",
                        'section_content' => $item['name'],
                        'attributes' => null,
                        'media_files' => null
                    ]);
                    ContentManagement::create([
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$newId}_logo",
                        'section_content' => $item['logo'],
                        'attributes' => null,
                        'media_files' => null
                    ]);
                }

                return redirect()->route('admin.partners.index')->with('success', 'Partner deleted successfully.');
            }
        }

        // Update section title
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'partners',
                    'section_item_name' => 'partners_title'
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
                    'section_name' => 'partners',
                    'section_item_name' => 'partners_subtitle'
                ],
                [
                    'section_content' => $request->subtitle,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update partner items
        if ($request->has('partners')) {
            foreach ($request->partners as $id => $val) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$id}_name"
                    ],
                    [
                        'section_content' => $val['name'] ?? '',
                        'attributes' => null,
                        'media_files' => null
                    ]
                );

                // Handle file upload for partner logo
                $logoValue = $val['logo'] ?? '';
                $fileKey = "partner_logo_{$id}";

                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);

                    // Validate file size (max 10MB per file)
                    if ($file->getSize() > 10 * 1024 * 1024) {
                        return redirect()->route('admin.partners.index')
                            ->with('error', 'File size must be less than 10MB.');
                    }

                    // Validate file type
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($file->getMimeType(), $allowedTypes)) {
                        return redirect()->route('admin.partners.index')
                            ->with('error', 'Only JPEG, PNG, GIF, and WebP images are allowed.');
                    }

                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Create directory if it doesn't exist
                    if (!file_exists(public_path('uploads/partners'))) {
                        mkdir(public_path('uploads/partners'), 0755, true);
                    }

                    $file->move(public_path('uploads/partners'), $filename);
                    $logoValue = '/uploads/partners/' . $filename;
                }

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$id}_logo"
                    ],
                    [
                        'section_content' => $logoValue,
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.partners.index')->with('success', 'Partners updated successfully.');
    }
}
