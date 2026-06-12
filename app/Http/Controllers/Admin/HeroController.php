<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HeroController extends Controller
{
    /**
     * Display the hero section management page
     */
    public function index(): View
    {
        // Get or create hero section badge text content
        $badgeText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_badge_text'
            ],
            [
                'section_content' => 'Leaders in Energy & Infrastructure',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create hero section background content
        $background = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_Background'
            ],
            [
                'section_content' => null,
                'attributes' => null,
                'media_files' => json_encode(['source_file' => '/hero.png'])
            ]
        );

        // Get or create title content
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_title'
            ],
            [
                'section_content' => 'POWERING BANGLADESH SINCE 1980',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create description content
        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_description'
            ],
            [
                'section_content' => 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create primary CTA button content
        $primaryCtaText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_primary_cta_text'
            ],
            [
                'section_content' => 'EXPLORE CATALOG',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $primaryCtaLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_primary_cta_link'
            ],
            [
                'section_content' => '/projects',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create secondary CTA button content
        $secondaryCtaText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_secondary_cta_text'
            ],
            [
                'section_content' => 'CORPORATE PROFILE',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $secondaryCtaLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_secondary_cta_link'
            ],
            [
                'section_content' => '/about',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Create category items
        $category1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_category1'
            ],
            [
                'section_content' => json_encode([
                    'name' => 'Transformers',
                    'count' => '45+',
                    'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
                    'order' => 1
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $category2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_category2'
            ],
            [
                'section_content' => json_encode([
                    'name' => 'Switchgear',
                    'count' => '120+',
                    'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path><circle cx="12" cy="12" r="3"></circle></svg>',
                    'order' => 2
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $category3 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_category3'
            ],
            [
                'section_content' => json_encode([
                    'name' => 'Renewables',
                    'count' => '12GW',
                    'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.8 19.6A2 2 0 1 0 14 16H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.8 4.4A2 2 0 1 1 11 8H2"></path></svg>',
                    'order' => 3
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $category4 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_category4'
            ],
            [
                'section_content' => json_encode([
                    'name' => 'Automation',
                    'count' => '80+',
                    'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>',
                    'order' => 4
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all hero section items for the view
        $heroItems = ContentManagement::where('section_name', 'hero_section')
            ->get()
            ->keyBy('section_item_name');

        // Get hero categories
        $heroCategories = [];
        for ($i = 1; $i <= 4; $i++) {
            $catKey = 'hero_section_category' . $i;
            if (isset($heroItems[$catKey]) && $heroItems[$catKey]->section_content) {
                $catData = json_decode($heroItems[$catKey]->section_content, true);
                if ($catData) {
                    $heroCategories[] = $catData;
                }
            }
        }
        $heroCategories = collect($heroCategories)->sortBy('order')->values();

        return view('admin.cms-section.home-hero-section', compact('heroItems', 'heroCategories'));
    }

    /**
     * Update the hero section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle badge text update
        if ($request->has('badge')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_badge_text'
                ],
                [
                    'section_content' => $request->badge,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_title'
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
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle primary CTA button text update
        if ($request->has('cta_button_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_primary_cta_text'
                ],
                [
                    'section_content' => $request->cta_button_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle primary CTA button link update
        if ($request->has('cta_button_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_primary_cta_link'
                ],
                [
                    'section_content' => $request->cta_button_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle secondary CTA button text update
        if ($request->has('secondary_button_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_secondary_cta_text'
                ],
                [
                    'section_content' => $request->secondary_button_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle secondary CTA button link update
        if ($request->has('secondary_button_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'hero_section',
                    'section_item_name' => 'hero_section_secondary_cta_link'
                ],
                [
                    'section_content' => $request->secondary_button_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle background image update
        $backgroundImage = null;
        $seoAttributes = null;

        // Handle file upload for background image
        if ($request->hasFile('background_image_dropify')) {
            $file = $request->file('background_image_dropify');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hero'), $filename);
            $backgroundImage = '/uploads/hero/' . $filename;
        } elseif ($request->has('background_image')) {
            $backgroundImage = $request->background_image;
        }

        // Handle SEO attributes for background image
        if ($request->has('seo_attributes')) {
            $seoAttributes = json_encode($request->seo_attributes);
        }

        // Update background image content
        ContentManagement::updateOrCreate(
            [
                'section_name' => 'hero_section',
                'section_item_name' => 'hero_section_Background'
            ],
            [
                'section_content' => null, // nullable as per requirement
                'attributes' => $seoAttributes, // SEO attributes input field
                'media_files' => $backgroundImage ? json_encode(['source_file' => $backgroundImage]) : null
            ]
        );

        // Handle categories updates
        for ($i = 1; $i <= 4; $i++) {
            $catName = $request->input("cat{$i}_name");
            $catCount = $request->input("cat{$i}_count");
            $catIcon = $request->input("cat{$i}_icon");

            if ($catName || $catCount || $catIcon) {
                // Get existing category data to preserve the icon if not provided
                $existingCategory = ContentManagement::where('section_name', 'hero_section')
                    ->where('section_item_name', "hero_section_category{$i}")
                    ->first();

                $existingData = [];
                if ($existingCategory && $existingCategory->section_content) {
                    $existingData = json_decode($existingCategory->section_content, true) ?: [];
                }

                $catData = [
                    'name' => $catName ?? ($existingData['name'] ?? ''),
                    'count' => $catCount ?? ($existingData['count'] ?? ''),
                    'icon' => $catIcon ?? ($existingData['icon'] ?? ''),
                    'order' => $i
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'hero_section',
                        'section_item_name' => "hero_section_category{$i}"
                    ],
                    [
                        'section_content' => json_encode($catData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.cms-section.home-hero-section')
            ->with('success', 'Hero section updated successfully.');
    }

}
