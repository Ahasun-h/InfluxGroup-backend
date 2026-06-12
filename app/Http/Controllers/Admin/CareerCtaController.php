<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CareerCtaController extends Controller
{
    /**
     * Display the Career CTA management page
     */
    public function index(): View
    {
        // Get or create Career CTA section content
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'career_cta_section',
                'section_item_name' => 'career_cta_title'
            ],
            [
                'section_content' => 'Join Our <span class="text-yellow-400">Mission</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'career_cta_section',
                'section_item_name' => 'career_cta_description'
            ],
            [
                'section_content' => 'Be part of Bangladesh\'s engineering excellence story',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'career_cta_section',
                'section_item_name' => 'career_cta_button_text'
            ],
            [
                'section_content' => 'Career Opportunities',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'career_cta_section',
                'section_item_name' => 'career_cta_button_link'
            ],
            [
                'section_content' => '/contact',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Fetch all Career CTA section items
        $data = ContentManagement::where('section_name', 'career_cta_section')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['career_cta_title']->section_content ?? 'Join Our <span class="text-yellow-400">Mission</span>',
            'description' => $data['career_cta_description']->section_content ?? 'Be part of Bangladesh\'s engineering excellence story',
            'button_text' => $data['career_cta_button_text']->section_content ?? 'Career Opportunities',
            'button_link' => $data['career_cta_button_link']->section_content ?? '/contact',
        ];

        return view('admin.cms-section.career-cta-section', compact('content'));
    }

    /**
     * Update the Career CTA section
     */
    public function update(Request $request): RedirectResponse
    {
        // Update title
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'career_cta_section',
                    'section_item_name' => 'career_cta_title'
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
                    'section_name' => 'career_cta_section',
                    'section_item_name' => 'career_cta_description'
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
                    'section_name' => 'career_cta_section',
                    'section_item_name' => 'career_cta_button_text'
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
                    'section_name' => 'career_cta_section',
                    'section_item_name' => 'career_cta_button_link'
                ],
                [
                    'section_content' => $request->button_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        return redirect()->route('admin.career-cta-section.index')
            ->with('success', 'Career CTA section updated successfully.');
    }

    /**
     * API: Get Career CTA data for frontend
     */
    public function getCareerCtaData()
    {
        $data = ContentManagement::where('section_name', 'career_cta_section')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $data['career_cta_title']->section_content ?? 'Join Our <span class="text-yellow-400">Mission</span>',
                'description' => $data['career_cta_description']->section_content ?? 'Be part of Bangladesh\'s engineering excellence story',
                'button_text' => $data['career_cta_button_text']->section_content ?? 'Career Opportunities',
                'button_link' => $data['career_cta_button_link']->section_content ?? '/contact',
            ]
        ]);
    }
}