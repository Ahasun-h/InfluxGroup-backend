<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    /**
     * Display the testimonials management page
     */
    public function index(): View
    {
        // Get or create testimonials section title content
        $subtitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_subtitle'
            ],
            [
                'section_content' => 'Testimonials',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_title'
            ],
            [
                'section_content' => 'What Our Clients Say',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'testimonials_section',
                'section_item_name' => 'testimonials_description'
            ],
            [
                'section_content' => 'Trusted by leading organizations across Bangladesh and beyond',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all testimonials
        $testimonials = ContentManagement::where('section_name', 'testimonials')
            ->orderBy('id')
            ->get();

        // Decode the testimonial data
        $testimonialsData = [];
        foreach ($testimonials as $testimonial) {
            $data = json_decode($testimonial->section_content, true);
            if ($data) {
                $data['id'] = $testimonial->id;
                $testimonialsData[] = $data;
            }
        }

        // Get section items
        $sectionItems = ContentManagement::where('section_name', 'testimonials_section')
            ->get()
            ->keyBy('section_item_name');

        return view('admin.cms-section.testimonials', compact('sectionItems', 'testimonialsData'));
    }

    /**
     * Update the testimonials section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle subtitle update
        if ($request->has('subtitle')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'testimonials_section',
                    'section_item_name' => 'testimonials_subtitle'
                ],
                [
                    'section_content' => $request->subtitle,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'testimonials_section',
                    'section_item_name' => 'testimonials_title'
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
                    'section_name' => 'testimonials_section',
                    'section_item_name' => 'testimonials_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonials section updated successfully.');
    }

    /**
     * Store a new testimonial
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string',
            'position' => 'required|string',
            'company' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $testimonialData = [
            'content' => $request->content,
            'name' => $request->name,
            'position' => $request->position,
            'company' => $request->company,
            'rating' => $request->rating
        ];

        ContentManagement::create([
            'section_name' => 'testimonials',
            'section_item_name' => 'testimonial_' . time(),
            'section_content' => json_encode($testimonialData),
            'attributes' => null,
            'media_files' => null
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial added successfully.');
    }

    /**
     * Update a testimonial
     */
    public function updateTestimonial(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
            'name' => 'required|string',
            'position' => 'required|string',
            'company' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $testimonial = ContentManagement::findOrFail($id);

        $testimonialData = [
            'content' => $request->content,
            'name' => $request->name,
            'position' => $request->position,
            'company' => $request->company,
            'rating' => $request->rating
        ];

        $testimonial->update([
            'section_content' => json_encode($testimonialData)
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Delete a testimonial
     */
    public function destroy($id): RedirectResponse
    {
        $testimonial = ContentManagement::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}