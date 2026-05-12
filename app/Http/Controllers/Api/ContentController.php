<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Solution;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\JobOpening;
use App\Models\CompanySetting;
use App\Models\Page;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getPages()
    {
        return response()->json([
            'success' => true,
            'data' => Page::where('status', 'published')->orderBy('order')->get()
        ]);
    }

    public function getPageBySlug($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $page
        ]);
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();
        
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate($request->limit ?? 10);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'pagination' => [
                'total' => $products->total(),
                'page' => $products->currentPage(),
                'limit' => $products->perPage(),
                'totalPages' => $products->lastPage(),
            ]
        ]);
    }

    public function getProjects(Request $request)
    {
        $query = Project::query();
        
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate($request->limit ?? 10);

        return response()->json([
            'success' => true,
            'data' => $projects->items(),
            'pagination' => [
                'total' => $projects->total(),
                'page' => $projects->currentPage(),
                'limit' => $projects->perPage(),
                'totalPages' => $projects->lastPage(),
            ]
        ]);
    }

    public function getFeaturedProjects()
    {
        return response()->json([
            'success' => true,
            'data' => Project::where('featured', true)->latest()->take(6)->get()
        ]);
    }

    public function getProject($slug)
    {
        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }

    public function getNews(Request $request)
    {
        $query = News::query();
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->latest()->paginate($request->limit ?? 10);

        return response()->json([
            'success' => true,
            'data' => $news->items(),
            'pagination' => [
                'total' => $news->total(),
                'page' => $news->currentPage(),
                'limit' => $news->perPage(),
                'totalPages' => $news->lastPage(),
            ]
        ]);
    }

    public function getCompanyInfo()
    {
        $company = CompanySetting::get('company_info', [
            'name' => 'Influx Group',
            'tagline' => 'Leaders in Energy & Infrastructure',
            'description' => 'Powering Bangladesh since 1980.',
            'address' => 'Dhaka, Bangladesh',
            'phone' => '+880 2 1234 5678',
            'email' => 'info@influxgroup.com',
        ]);

        $homepage = CompanySetting::get('homepage_content', [
            'hero' => [
                'title' => 'Building Bangladesh\'s Future',
                'subtitle' => 'Leading infrastructure development since 1980',
                'description' => 'We deliver world-class construction and engineering solutions that power Bangladesh\'s growth and development.',
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

        return response()->json([
            'success' => true,
            'data' => [
                'company' => $company,
                'homepage' => $homepage
            ]
        ]);
    }

    // Add other methods as needed based on models...
    public function getServices() { return response()->json(['success' => true, 'data' => Service::all()]); }
    public function getSolutions() { return response()->json(['success' => true, 'data' => Solution::all()]); }
    public function getTestimonials() { return response()->json(['success' => true, 'data' => Testimonial::all()]); }
    public function getPartners() { return response()->json(['success' => true, 'data' => Partner::all()]); }
    public function getJobs() { return response()->json(['success' => true, 'data' => JobOpening::where('status', 'active')->get()]); }
    public function getGallery() { return response()->json(['success' => true, 'data' => Gallery::orderBy('order')->get()]); }

    public function updateHomepageContent(Request $request)
    {
        $homepage = CompanySetting::set('homepage_content', $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Homepage content updated successfully',
            'data' => $homepage
        ]);
    }
}
