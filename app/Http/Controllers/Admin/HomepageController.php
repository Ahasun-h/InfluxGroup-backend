<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $homepage = CompanySetting::get('homepage_content', [
            'hero' => [
                'title' => 'Building Bangladesh\'s Future',
                'subtitle' => 'Leading infrastructure development since 1980',
                'description' => 'We deliver world-class construction and engineering solutions.',
                'cta_text' => 'View Our Projects',
                'cta_link' => '/projects',
                'background_image' => '/images/hero-bg.jpg',
                'show_contact_form' => true,
            ],
            'stats' => [
                'projects_completed' => 500,
                'years_experience' => 40,
                'happy_clients' => 150,
                'awards_won' => 25,
            ],
            'brand_statement' => [
                'title' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
                'highlighted_word' => 'AUTHORITY',
                'description' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                'overlay_title' => 'Core Reliability',
                'overlay_text' => '"Zero Downtime Operation Protocols"',
            ],
            'mission_vision' => [
                'mission' => [
                    'title' => 'Our Mission',
                    'description' => 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
                    'points' => [
                        'Powering Bangladesh\'s development through innovative energy solutions',
                        'Ensuring energy security for future generations',
                        'Building sustainable infrastructure nationwide'
                    ]
                ],
                'vision' => [
                    'title' => 'Our Vision',
                    'description' => 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
                    'points' => [
                        'Regional leadership in sustainable infrastructure development',
                        'Global recognition for engineering excellence',
                        'Pioneering renewable energy adoption'
                    ]
                ]
            ],
            'services_title' => 'Our Services',
            'services_subtitle' => 'Comprehensive construction and engineering solutions',
            'projects_title' => 'Featured Projects',
            'projects_subtitle' => 'Discover our portfolio of successful projects',
            'testimonials_title' => 'What Our Clients Say',
            'testimonials_subtitle' => 'Trusted by leading organizations across Bangladesh',
            'cta_section' => [
                'title' => 'Ready to Start Your Project?',
                'description' => 'Contact us today to discuss how we can help bring your vision to life.',
                'button_text' => 'Get in Touch',
                'button_link' => '/contact',
            ],
        ]);

        $featuredProjects = Project::where('featured', true)->take(6)->get();
        $featuredServices = Service::take(6)->get();
        $featuredTestimonials = Testimonial::where('featured', true)->take(6)->get();

        return view('admin.homepage.index', compact(
            'homepage',
            'featuredProjects',
            'featuredServices',
            'featuredTestimonials'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero.title' => 'required|string|max:255',
            'hero.subtitle' => 'required|string|max:255',
            'hero.description' => 'required|string',
            'hero.cta_text' => 'required|string|max:100',
            'hero.cta_link' => 'required|string|max:255',
            'hero.background_image' => 'nullable|string|max:500',
            'hero.show_contact_form' => 'boolean',

            'stats.projects_completed' => 'required|integer|min:0',
            'stats.years_experience' => 'required|integer|min:0',
            'stats.happy_clients' => 'required|integer|min:0',
            'stats.awards_won' => 'required|integer|min:0',

            'brand_statement.title' => 'required|string|max:255',
            'brand_statement.highlighted_word' => 'required|string|max:100',
            'brand_statement.description' => 'required|string',
            'brand_statement.image_url' => 'nullable|string|max:500',
            'brand_statement.overlay_title' => 'required|string|max:255',
            'brand_statement.overlay_text' => 'required|string|max:255',

            'mission_vision.mission.title' => 'required|string|max:255',
            'mission_vision.mission.description' => 'required|string',
            'mission_vision.mission.points' => 'required|array',
            'mission_vision.mission.points.*' => 'required|string|max:500',

            'mission_vision.vision.title' => 'required|string|max:255',
            'mission_vision.vision.description' => 'required|string',
            'mission_vision.vision.points' => 'required|array',
            'mission_vision.vision.points.*' => 'required|string|max:500',

            'services_title' => 'required|string|max:255',
            'services_subtitle' => 'required|string|max:255',
            'projects_title' => 'required|string|max:255',
            'projects_subtitle' => 'required|string|max:255',
            'testimonials_title' => 'required|string|max:255',
            'testimonials_subtitle' => 'required|string|max:255',

            'cta_section.title' => 'required|string|max:255',
            'cta_section.description' => 'required|string',
            'cta_section.button_text' => 'required|string|max:100',
            'cta_section.button_link' => 'required|string|max:255',
        ]);

        CompanySetting::set('homepage_content', $validated);

        return redirect()
            ->route('admin.homepage.index')
            ->with('success', 'Homepage content updated successfully! The changes will appear immediately on your website.');
    }

    public function preview()
    {
        $homepage = CompanySetting::get('homepage_content', []);
        return response()->json($homepage);
    }

    /**
     * Get all services data for homepage management
     */
    public function getServices()
    {
        $services = Service::orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * Store or update a service
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:services,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'features' => 'nullable|array',
            'process' => 'nullable|array',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($request->filled('id')) {
            $service = Service::find($request->id);
            $service->update($validated);
        } else {
            $service = Service::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Service saved successfully',
            'data' => $service
        ]);
    }

    /**
     * Delete a service
     */
    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully'
        ]);
    }

    /**
     * Get all projects data for homepage management
     */
    public function getProjects()
    {
        $projects = Project::orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Store or update a project
     */
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|string',
            'type' => 'nullable|string',
            'category' => 'required|string|max:255',
            'status' => 'required|in:active,completed',
            'completion' => 'nullable|integer|min:0|max:100',
            'client' => 'nullable|string|max:255',
            'value' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'scope' => 'nullable|array',
            'highlights' => 'nullable|array',
            'stats' => 'nullable|array',
            'featured' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->filled('id')) {
            $project = Project::find($request->id);
            $project->update($validated);
        } else {
            $project = Project::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Project saved successfully',
            'data' => $project
        ]);
    }

    /**
     * Delete a project
     */
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }

    /**
     * Get all testimonials data for homepage management
     */
    public function getTestimonials()
    {
        $testimonials = Testimonial::orderBy('order')->get();
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Store or update a testimonial
     */
    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:testimonials,id',
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'company_logo' => 'nullable|string',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'project_name' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'featured' => 'boolean',
            'date' => 'nullable|date',
            'order' => 'nullable|integer',
        ]);

        if ($request->filled('id')) {
            $testimonial = Testimonial::find($request->id);
            $testimonial->update($validated);
        } else {
            $testimonial = Testimonial::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Testimonial saved successfully',
            'data' => $testimonial
        ]);
    }

    /**
     * Delete a testimonial
     */
    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }

    /**
     * Toggle featured status for projects
     */
    public function toggleProjectFeatured($id)
    {
        $project = Project::findOrFail($id);
        $project->featured = !$project->featured;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Project featured status updated',
            'data' => $project
        ]);
    }

    /**
     * Toggle featured status for testimonials
     */
    public function toggleTestimonialFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->featured = !$testimonial->featured;
        $testimonial->save();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial featured status updated',
            'data' => $testimonial
        ]);
    }
}