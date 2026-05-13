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

        // Get all hero section items for the view
        $heroItems = ContentManagement::where('section_name', 'hero_section')
            ->get()
            ->keyBy('section_item_name');

        return view('admin.hero.index', compact('heroItems'));
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

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section updated successfully.');
    }

}
