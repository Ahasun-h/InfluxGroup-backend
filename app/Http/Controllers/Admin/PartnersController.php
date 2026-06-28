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
        try {
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

            // Fetch all partners section items
            $data = ContentManagement::where('section_name', 'partners')
                ->get()
                ->keyBy('section_item_name');

            $content = [
                'title' => $data['partners_title']?->section_content ?? 'Trusted by Industry Leaders',
                'subtitle' => $data['partners_subtitle']?->section_content ?? 'Proud partner to government agencies, multinational corporations, and leading enterprises',
            ];

            // Try new JSON format first (partner_1, partner_2, etc.)
            $partners = [];
            $i = 1;
            while (isset($data["partner_{$i}"]) && $data["partner_{$i}"]?->section_content) {
                $jsonData = json_decode($data["partner_{$i}"]?->section_content, true);
                if ($jsonData && isset($jsonData['name'])) {
                    $partners[] = [
                        'id' => $i,
                        'name' => $jsonData['name'] ?? '',
                        'logo' => $jsonData['logo'] ?? '',
                    ];
                }
                $i++;
            }

            // If no JSON items found, try old format (partner_X_name, partner_X_logo)
            if (empty($partners)) {
                $i = 1;
                while (isset($data["partner_{$i}_name"]) && $data["partner_{$i}_name"]) {
                    $partners[] = [
                        'id' => $i,
                        'name' => $data["partner_{$i}_name"]?->section_content ?? '',
                        'logo' => $data["partner_{$i}_logo"]?->section_content ?? '',
                    ];
                    $i++;
                }
            }

            // If still no partners, create defaults
            if (empty($partners)) {
                $partners = [
                    ['id' => 1, 'name' => 'ExxonMobil', 'logo' => '🏢'],
                    ['id' => 2, 'name' => 'Shell', 'logo' => '🏭'],
                    ['id' => 3, 'name' => 'Chevron', 'logo' => '🏗️'],
                    ['id' => 4, 'name' => 'TotalEnergies', 'logo' => '⚡'],
                    ['id' => 5, 'name' => 'BP', 'logo' => '🔥'],
                    ['id' => 6, 'name' => 'Schlumberger', 'logo' => '🔧'],
                ];
            }

            return view('admin.cms-section.partners-section', [
                'content' => $content,
                'partners' => $partners
            ]);
        } catch (\Exception $e) {
            \Log::error('Partners page error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the partners section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle deletion from new format
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'delete_partner_') === 0 && !empty($value)) {
                $deleteId = (int) $value;

                \Log::info('Deleting partner ID: ' . $deleteId);

                // Get all current partner items in JSON format
                $currentItems = ContentManagement::where('section_name', 'partners')
                    ->where('section_item_name', 'regexp', '^partner_[0-9]+$')
                    ->get()
                    ->sortBy(function($item) {
                        preg_match('/partner_(\d+)$/', $item->section_item_name, $matches);
                        return (int)($matches[1] ?? 0);
                    });

                $remainingItems = [];
                foreach ($currentItems as $item) {
                    preg_match('/partner_(\d+)$/', $item->section_item_name, $matches);
                    $id = (int)($matches[1] ?? 0);

                    if ($id !== $deleteId && $id > 0) {
                        $jsonData = json_decode($item->section_content, true);
                        if ($jsonData) {
                            $remainingItems[] = $jsonData;
                        }
                    }
                }

                // Delete ALL current partner items to rebuild cleanly
                ContentManagement::where('section_name', 'partners')
                    ->where('section_item_name', 'regexp', '^partner_[0-9]+$')
                    ->delete();

                // Re-insert remaining items with new indices
                foreach ($remainingItems as $idx => $item) {
                    $newId = $idx + 1;
                    ContentManagement::create([
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$newId}",
                        'section_content' => json_encode($item),
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
            \Log::info('Processing partners update', ['partners' => $request->partners]);

            foreach ($request->partners as $id => $partner) {
                \Log::info("Processing partner ID: {$id}", ['partner' => $partner]);

                // Safely access partner data
                $partnerName = is_array($partner) && isset($partner['name']) ? $partner['name'] : '';
                $partnerLogo = is_array($partner) && isset($partner['logo']) ? $partner['logo'] : '';

                $partnerData = [
                    'name' => $partnerName,
                    'logo' => $partnerLogo,
                    'order' => (int)$id
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'partners',
                        'section_item_name' => "partner_{$id}"
                    ],
                    [
                        'section_content' => json_encode($partnerData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.partners.index')->with('success', 'Partners updated successfully.');
    }
}