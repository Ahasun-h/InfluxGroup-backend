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

        // Fetch all homepage content from ContentManagement
        $allContent = \App\Models\ContentManagement::all()->groupBy('section_name');

        $homepage = [
            'hero' => [
                'title' => $allContent['hero_section']->where('section_item_name', 'hero_section_title')->first()->section_content ?? 'Building Bangladesh\'s Future',
                'subtitle' => $allContent['hero_section']->where('section_item_name', 'hero_section_badge_text')->first()->section_content ?? 'Leading infrastructure development since 1980',
                'description' => $allContent['hero_section']->where('section_item_name', 'hero_section_description')->first()->section_content ?? '',
                'cta_text' => $allContent['hero_section']->where('section_item_name', 'hero_section_primary_cta_text')->first()->section_content ?? 'View Our Projects',
                'cta_link' => $allContent['hero_section']->where('section_item_name', 'hero_section_primary_cta_link')->first()->section_content ?? '/projects',
                'background_image' => $allContent['hero_section']->where('section_item_name', 'hero_section_Background')->first()->media_files['source_file'] ?? '/images/hero-bg.jpg',
                'show_contact_form' => true,
            ],
            'stats' => [
                'projects_completed' => $allContent['homepage_stats']->where('section_item_name', 'stats_projects_completed')->first()->section_content ?? '500+',
                'years_experience' => $allContent['homepage_stats']->where('section_item_name', 'stats_years_experience')->first()->section_content ?? '40',
                'happy_clients' => $allContent['homepage_stats']->where('section_item_name', 'stats_happy_clients')->first()->section_content ?? '150',
                'awards_won' => $allContent['homepage_stats']->where('section_item_name', 'stats_awards_won')->first()->section_content ?? '25',
            ],
            'brand_statement' => [
                'title' => $allContent['brand_statements_section']->where('section_item_name', 'brand_statements_title')->first()->section_content ?? '',
                'highlighted_word' => 'AUTHORITY', // Can be dynamic if needed
                'description' => $allContent['brand_statements_section']->where('section_item_name', 'brand_statements_description')->first()->section_content ?? '',
                'image_url' => $allContent['brand_statements_section']->where('section_item_name', 'brand_statements_image')->first()->section_content ?? '',
                'overlay_title' => $allContent['brand_statements_section']->where('section_item_name', 'brand_statements_overlay_title')->first()->section_content ?? '',
                'overlay_text' => $allContent['brand_statements_section']->where('section_item_name', 'brand_statements_overlay_text')->first()->section_content ?? '',
                'stats' => [
                    json_decode($allContent['brand_statements_section']->where('section_item_name', 'brand_statements_stat1')->first()->section_content ?? '{}', true),
                    json_decode($allContent['brand_statements_section']->where('section_item_name', 'brand_statements_stat2')->first()->section_content ?? '{}', true),
                    json_decode($allContent['brand_statements_section']->where('section_item_name', 'brand_statements_stat3')->first()->section_content ?? '{}', true),
                ]
            ],
            'mission_vision' => [
                'mission' => [
                    'title' => $allContent['mission_vision']->where('section_item_name', 'mission_title')->first()->section_content ?? 'Our Mission',
                    'description' => $allContent['mission_vision']->where('section_item_name', 'mission_description')->first()->section_content ?? '',
                    'points' => json_decode($allContent['mission_vision']->where('section_item_name', 'mission_points')->first()->section_content ?? '[]', true)
                ],
                'vision' => [
                    'title' => $allContent['mission_vision']->where('section_item_name', 'vision_title')->first()->section_content ?? 'Our Vision',
                    'description' => $allContent['mission_vision']->where('section_item_name', 'vision_description')->first()->section_content ?? '',
                    'points' => json_decode($allContent['mission_vision']->where('section_item_name', 'vision_points')->first()->section_content ?? '[]', true)
                ]
            ],
            'core_values' => [
                'title' => $allContent['core_values']->where('section_item_name', 'core_values_title')->first()->section_content ?? 'Core Values',
                'subtitle' => $allContent['core_values']->where('section_item_name', 'core_values_subtitle')->first()->section_content ?? '',
                'list' => $allContent['core_values']->filter(fn($item) => str_starts_with($item->section_item_name, 'core_value_') && str_ends_with($item->section_item_name, '_title'))
                    ->map(function($item) use ($allContent) {
                        preg_match('/core_value_(\d+)_title/', $item->section_item_name, $matches);
                        $id = $matches[1];
                        return [
                            'title' => $item->section_content,
                            'description' => $allContent['core_values']->where('section_item_name', "core_value_{$id}_description")->first()->section_content ?? '',
                            'icon' => $allContent['core_values']->where('section_item_name', "core_value_{$id}_icon")->first()->section_content ?? 'ShieldCheck',
                        ];
                    })->values()->toArray()
            ],
            'services_title' => $allContent['homepage_headings']->where('section_item_name', 'services_title')->first()->section_content ?? 'Our Services',
            'services_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'services_subtitle')->first()->section_content ?? '',
            'projects_title' => $allContent['homepage_headings']->where('section_item_name', 'projects_title')->first()->section_content ?? 'Featured Projects',
            'projects_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'projects_subtitle')->first()->section_content ?? '',
            'testimonials_title' => $allContent['homepage_headings']->where('section_item_name', 'testimonials_title')->first()->section_content ?? 'What Our Clients Say',
            'testimonials_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'testimonials_subtitle')->first()->section_content ?? '',
            'cta_section' => [
                'title' => $allContent['cta_section']->where('section_item_name', 'cta_title')->first()->section_content ?? '',
                'description' => $allContent['cta_section']->where('section_item_name', 'cta_description')->first()->section_content ?? '',
                'button_text' => $allContent['cta_section']->where('section_item_name', 'cta_button_text')->first()->section_content ?? 'Get in Touch',
                'button_link' => $allContent['cta_section']->where('section_item_name', 'cta_button_link')->first()->section_content ?? '/contact',
            ],
        ];

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
