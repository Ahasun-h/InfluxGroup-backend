<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactCtaController extends Controller
{
    /**
     * Display the Contact CTA management page
     */
    public function index(): View
    {
        // Get or create CTA section content
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'cta_section',
                'section_item_name' => 'cta_title'
            ],
            [
                'section_content' => 'Ready to Power Your Success?',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'cta_section',
                'section_item_name' => 'cta_description'
            ],
            [
                'section_content' => "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions.",
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'cta_section',
                'section_item_name' => 'cta_button_text'
            ],
            [
                'section_content' => 'Get in Touch',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'cta_section',
                'section_item_name' => 'cta_button_link'
            ],
            [
                'section_content' => '/contact',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Fetch all CTA section items
        $data = ContentManagement::where('section_name', 'cta_section')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['cta_title']->section_content ?? 'Ready to Power Your Success?',
            'description' => $data['cta_description']->section_content ?? "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs.",
            'button_text' => $data['cta_button_text']->section_content ?? 'Get in Touch',
            'button_link' => $data['cta_button_link']->section_content ?? '/contact',
        ];

        return view('admin.cms-section.contact-cta-section', compact('content'));
    }

    /**
     * Update the Contact CTA section
     */
    public function update(Request $request): RedirectResponse
    {
        // Update title
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'cta_section',
                    'section_item_name' => 'cta_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update description
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'cta_section',
                    'section_item_name' => 'cta_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update button text
        if ($request->has('button_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'cta_section',
                    'section_item_name' => 'cta_button_text'
                ],
                [
                    'section_content' => $request->button_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update button link
        if ($request->has('button_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'cta_section',
                    'section_item_name' => 'cta_button_link'
                ],
                [
                    'section_content' => $request->button_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        return redirect()->route('admin.contact-cta.index')
            ->with('success', 'Contact CTA section updated successfully.');
    }
}
