<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\Category;
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

    public function getProjectCategories()
    {
        return response()->json([
            'success' => true,
            'data' => Category::projectArea()->active()->ordered()->get()
        ]);
    }

    public function getCompanyInfo()
    {
        $company = [
            'name' => 'Influx Group',
            'tagline' => 'Leaders in Energy & Infrastructure',
            'description' => 'Powering Bangladesh since 1980.',
            'address' => 'Dhaka, Bangladesh',
            'phone' => '+880 2 1234 5678',
            'email' => 'info@influxgroup.com',
        ];

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
            'partners' => [
                'title' => $allContent['partners']->where('section_item_name', 'partners_title')->first()->section_content ?? 'Trusted by Industry Leaders',
                'subtitle' => $allContent['partners']->where('section_item_name', 'partners_subtitle')->first()->section_content ?? 'Proud partner to government agencies, multinational corporations, and leading enterprises',
                'list' => $allContent['partners']->filter(fn($item) => str_starts_with($item->section_item_name, 'partner_') && str_ends_with($item->section_item_name, '_name'))
                    ->map(function($item) use ($allContent) {
                        preg_match('/partner_(\d+)_name/', $item->section_item_name, $matches);
                        $id = $matches[1];
                        return [
                            'name' => $item->section_content,
                            'logo' => $allContent['partners']->where('section_item_name', "partner_{$id}_logo")->first()->section_content ?? '🏢',
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


    // Legacy support - old methods (deprecated)
    public function getServices() { return response()->json(['success' => true, 'data' => []]); }
    public function getSolutions() { return response()->json(['success' => true, 'data' => []]); }
    public function getTestimonials() { return response()->json(['success' => true, 'data' => []]); }
    public function getJobs() { return response()->json(['success' => true, 'data' => []]); }
    public function getGallery() { return response()->json(['success' => true, 'data' => []]); }

    public function updateHomepageContent(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Homepage content update is disabled',
            'data' => null
        ]);
    }

    /**
     * Get Hero Section Content
     */
    public function getHeroSection()
    {
        $heroItems = \App\Models\ContentManagement::where('section_name', 'hero_section')
            ->get()
            ->keyBy('section_item_name');

        $backgroundImage = null;
        if ($heroItems->has('hero_section_Background') && $heroItems['hero_section_Background']->media_files) {
            $mediaFiles = json_decode($heroItems['hero_section_Background']->media_files, true);
            $backgroundImage = $mediaFiles['source_file'] ?? null;
        }

        // Get hero categories - looking for hero_section_category1, hero_section_category2, etc.
        $heroCategories = [];
        for ($i = 1; $i <= 4; $i++) {
            $catKey = "hero_section_category{$i}";
            $catItem = $heroItems->get($catKey);

            if ($catItem) {
                // Parse JSON content
                $catData = json_decode($catItem->section_content, true);

                if ($catData && isset($catData['name'])) {
                    $heroCategories[] = [
                        'order' => $i,
                        'name' => $catData['name'],
                        'count' => $catData['count'] ?? '0',
                        'icon' => $catData['icon'] ?? ''
                    ];
                }
            }
        }

        $hero = [
            'badge' => $heroItems['hero_section_badge_text']->section_content ?? 'Leaders in Energy & Infrastructure',
            'title' => $heroItems['hero_section_title']->section_content ?? 'POWERING BANGLADESH SINCE 1980',
            'description' => $heroItems['hero_section_description']->section_content ?? 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
            'primary_cta' => [
                'text' => $heroItems['hero_section_primary_cta_text']->section_content ?? 'EXPLORE CATALOG',
                'link' => $heroItems['hero_section_primary_cta_link']->section_content ?? '/projects'
            ],
            'secondary_cta' => [
                'text' => $heroItems['hero_section_secondary_cta_text']->section_content ?? 'CORPORATE PROFILE',
                'link' => $heroItems['hero_section_secondary_cta_link']->section_content ?? '/about'
            ],
            'background_image' => $backgroundImage,
            'seo_attributes' => $heroItems['hero_section_Background']->attributes ?? null,
            'categories' => $heroCategories
        ];

        return response()->json([
            'success' => true,
            'data' => $hero
        ]);
    }

    /**
     * Get Brand Statements Content
     */
    public function getBrandStatements()
    {
        $brandItems = \App\Models\ContentManagement::where('section_name', 'brand_statements_section')
            ->get()
            ->keyBy('section_item_name');

        $stats = [];
        for ($i = 1; $i <= 4; $i++) {
            $statData = $brandItems["brand_statements_stat{$i}"]->section_content ?? '{}';
            $stats[] = json_decode($statData, true) ?: [];
        }

        $brandStatements = [
            'title' => $brandItems['brand_statements_title']->section_content ?? 'Building Bangladesh\'s Future',
            'description' => $brandItems['brand_statements_description']->section_content ?? 'We are the authority in infrastructure development.',
            'image' => $brandItems['brand_statements_image']->section_content ?? '',
            'overlay_title' => $brandItems['brand_statements_overlay_title']->section_content ?? '',
            'overlay_text' => $brandItems['brand_statements_overlay_text']->section_content ?? '',
            'stats' => $stats
        ];

        return response()->json([
            'success' => true,
            'data' => $brandStatements
        ]);
    }

    /**
     * Get Journey Timeline Content
     */
    public function getJourneyTimeline()
    {
        $journeyItems = \App\Models\ContentManagement::where('section_name', 'journey')
            ->get()
            ->keyBy('section_item_name');

        $title = $journeyItems['journey_title']->section_content ?? 'Our Journey';
        $description = $journeyItems['journey_description']->section_content ?? 'Four decades of excellence in powering Bangladesh\'s development';

        $milestones = [];

        // Try new JSON format first (Journey_1, Journey_2, etc.)
        $i = 1;
        while (isset($journeyItems["Journey_{$i}"]) && $journeyItems["Journey_{$i}"]->section_content) {
            $jsonData = json_decode($journeyItems["Journey_{$i}"]->section_content, true);
            if ($jsonData && isset($jsonData['year'])) {
                $milestones[] = [
                    'year' => $jsonData['year'] ?? '',
                    'title' => $jsonData['title'] ?? '',
                    'description' => $jsonData['description'] ?? ''
                ];
            }
            $i++;
        }

        // If no JSON items found, try old format (Journey_X_year, Journey_X_title, Journey_X_description)
        if (empty($milestones)) {
            for ($i = 1; $i <= 10; $i++) {
                $year = $journeyItems["Journey_{$i}_year"]->section_content ?? null;
                if ($year) {
                    $milestones[] = [
                        'year' => $year,
                        'title' => $journeyItems["Journey_{$i}_title"]->section_content ?? '',
                        'description' => $journeyItems["Journey_{$i}_description"]->section_content ?? ''
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $title,
                'subtitle' => $description, // Include subtitle for frontend compatibility
                'description' => $description,
                'milestones' => $milestones
            ]
        ]);
    }

    /**
     * Get Mission & Vision Content
     */
    public function getMissionVision()
    {
        $mvItems = \App\Models\ContentManagement::where('section_name', 'mission_vision')
            ->get()
            ->keyBy('section_item_name');

        $mission = [
            'title' => $mvItems['mission_title']->section_content ?? 'Our Mission',
            'description' => $mvItems['mission_description']->section_content ?? '',
            'points' => json_decode($mvItems['mission_points']->section_content ?? '[]', true)
        ];

        $vision = [
            'title' => $mvItems['vision_title']->section_content ?? 'Our Vision',
            'description' => $mvItems['vision_description']->section_content ?? '',
            'points' => json_decode($mvItems['vision_points']->section_content ?? '[]', true)
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'mission' => $mission,
                'vision' => $vision
            ]
        ]);
    }

    /**
     * Get Core Values Content
     */
    public function getCoreValues()
    {
        $cvItems = \App\Models\ContentManagement::where('section_name', 'core_values')
            ->get()
            ->keyBy('section_item_name');

        $title = $cvItems['core_values_title']->section_content ?? 'Core Values';
        $subtitle = $cvItems['core_values_subtitle']->section_content ?? '';

        $values = [];

        // Try new JSON format first (core_value_1, core_value_2, etc.)
        $i = 1;
        while (isset($cvItems["core_value_{$i}"]) && $cvItems["core_value_{$i}"]->section_content) {
            $jsonData = json_decode($cvItems["core_value_{$i}"]->section_content, true);
            if ($jsonData && isset($jsonData['title'])) {
                $values[] = [
                    'title' => $jsonData['title'] ?? '',
                    'description' => $jsonData['description'] ?? '',
                    'icon' => $jsonData['icon'] ?? 'ShieldCheck'
                ];
            }
            $i++;
        }

        // If no JSON items found, try old format (core_value_X_title, core_value_X_description, core_value_X_icon)
        if (empty($values)) {
            for ($i = 1; $i <= 6; $i++) {
                $valueTitle = $cvItems["core_value_{$i}_title"]->section_content ?? null;
                if ($valueTitle) {
                    $values[] = [
                        'title' => $valueTitle,
                        'description' => $cvItems["core_value_{$i}_description"]->section_content ?? '',
                        'icon' => $cvItems["core_value_{$i}_icon"]->section_content ?? 'ShieldCheck'
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $title,
                'subtitle' => $subtitle,
                'values' => $values
            ]
        ]);
    }

    /**
     * Get Partners Content (CMS version, different from Partner model)
     */
    public function getPartners()
    {
        $partnerItems = \App\Models\ContentManagement::where('section_name', 'partners')
            ->get()
            ->keyBy('section_item_name');

        $title = $partnerItems['partners_title']->section_content ?? 'Trusted by Industry Leaders';
        $subtitle = $partnerItems['partners_subtitle']->section_content ?? 'Proud partner to government agencies, multinational corporations, and leading enterprises';

        $partners = [];
        for ($i = 1; $i <= 20; $i++) {
            $name = $partnerItems["partner_{$i}_name"]->section_content ?? null;
            if ($name) {
                $partners[] = [
                    'name' => $name,
                    'logo' => $partnerItems["partner_{$i}_logo"]->section_content ?? '🏢'
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $title,
                'subtitle' => $subtitle,
                'partners' => $partners
            ]
        ]);
    }

    /**
     * Get Contact CTA Content
     */
    public function getContactCTA()
    {
        $ctaItems = \App\Models\ContentManagement::where('section_name', 'cta_section')
            ->get()
            ->keyBy('section_item_name');

        $cta = [
            'title' => $ctaItems['cta_title']->section_content ?? 'Ready to Power Your Success?',
            'description' => $ctaItems['cta_description']->section_content ?? "Let's discuss how Influx Group can deliver the power infrastructure solutions your organization needs. Our team is ready to provide expert consultation and tailored solutions.",
            'button_text' => $ctaItems['cta_button_text']->section_content ?? 'Get in Touch',
            'button_link' => $ctaItems['cta_button_link']->section_content ?? '/contact'
        ];

        return response()->json([
            'success' => true,
            'data' => $cta
        ]);
    }

    /**
     * Get Career CTA Section Data
     */
    public function getCareerCTA()
    {
        $careerCtaItems = \App\Models\ContentManagement::where('section_name', 'career_cta_section')
            ->get()
            ->keyBy('section_item_name');

        $careerCta = [
            'title' => $careerCtaItems['career_cta_title']->section_content ?? 'Join Our <span class="text-yellow-400">Mission</span>',
            'description' => $careerCtaItems['career_cta_description']->section_content ?? 'Be part of Bangladesh\'s engineering excellence story',
            'button_text' => $careerCtaItems['career_cta_button_text']->section_content ?? 'Career Opportunities',
            'button_link' => $careerCtaItems['career_cta_button_link']->section_content ?? '/contact'
        ];

        return response()->json([
            'success' => true,
            'data' => $careerCta
        ]);
    }

    /**
     * Get Contact Section Content
     */
    public function getContactSection()
    {
        $contactItems = \App\Models\ContentManagement::where('section_name', 'contact_section')
            ->get()
            ->keyBy('section_item_name');

        // Get phone numbers
        $phones = [];
        for ($i = 1; $i <= 2; $i++) {
            $phone = $contactItems->get("contact_phone_{$i}");
            if ($phone && $phone->section_content) {
                $phones[] = $phone->section_content;
            }
        }

        // Get email addresses
        $emails = [];
        for ($i = 1; $i <= 2; $i++) {
            $email = $contactItems->get("contact_email_{$i}");
            if ($email && $email->section_content) {
                $emails[] = $email->section_content;
            }
        }

        // Get office hours
        $officeHours = [
            'weekdays' => $contactItems->get('contact_office_hours_weekdays')->section_content ?? 'Saturday - Thursday: 9:00 AM - 6:00 PM',
            'friday' => $contactItems->get('contact_office_hours_friday')->section_content ?? 'Friday: Closed'
        ];

        // Get office locations
        $offices = [];
        for ($i = 1; $i <= 10; $i++) {
            $officeKey = "contact_office_{$i}";
            $office = $contactItems->get($officeKey);

            if ($office && $office->section_content) {
                $officeData = json_decode($office->section_content, true);
                if ($officeData && isset($officeData['city'])) {
                    $offices[] = [
                        'city' => $officeData['city'],
                        'type' => $officeData['type'] ?? '',
                        'address' => $officeData['address'] ?? '',
                        'phone' => $officeData['phone'] ?? '',
                        'email' => $officeData['email'] ?? '',
                        'order' => $officeData['order'] ?? $i
                    ];
                }
            }
        }
        $offices = collect($offices)->sortBy('order')->values()->all();

        // Get Google Maps embed URL
        $mapEmbedUrl = $contactItems->get('contact_map_embed_url')
            ? $contactItems->get('contact_map_embed_url')->section_content
            : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd';

        // Get Emergency Support section
        $emergency = [
            'title' => $contactItems->get('emergency_title')
                ? $contactItems->get('emergency_title')->section_content
                : 'Emergency <span class="text-industrial-red">Support</span>',
            'description' => $contactItems->get('emergency_description')
                ? $contactItems->get('emergency_description')->section_content
                : '24/7 emergency support available for critical power infrastructure issues',
            'primary_button' => [
                'text' => $contactItems->get('emergency_primary_text')
                    ? $contactItems->get('emergency_primary_text')->section_content
                    : 'Emergency Line',
                'link' => $contactItems->get('emergency_primary_link')
                    ? $contactItems->get('emergency_primary_link')->section_content
                    : 'tel:+88029876543'
            ],
            'secondary_button' => [
                'text' => $contactItems->get('emergency_secondary_text')
                    ? $contactItems->get('emergency_secondary_text')->section_content
                    : 'Email Support',
                'link' => $contactItems->get('emergency_secondary_link')
                    ? $contactItems->get('emergency_secondary_link')->section_content
                    : 'mailto:support@influxgroup.com'
            ]
        ];

        $contact = [
            'phones' => $phones,
            'emails' => $emails,
            'office_hours' => $officeHours,
            'offices' => $offices,
            'map_embed_url' => $mapEmbedUrl,
            'emergency' => $emergency
        ];

        return response()->json([
            'success' => true,
            'data' => $contact
        ]);
    }

    /**
     * Get Complete Homepage Content (all sections)
     */
    public function getHomepageContent()
    {
        try {
            $allContent = \App\Models\ContentManagement::all()->groupBy('section_name');

            $homepage = [
                'hero' => $this->getHeroSection()->getData(true)['data'],
                'brand_statements' => $this->getBrandStatements()->getData(true)['data'],
                'journey' => $this->getJourneyTimeline()->getData(true)['data'],
                'mission_vision' => $this->getMissionVision()->getData(true)['data'],
                'core_values' => $this->getCoreValues()->getData(true)['data'],
                'partners' => $this->getPartners()->getData(true)['data'],
                'contact_cta' => $this->getContactCTA()->getData(true)['data'],
                'headings' => [
                    'services_title' => $allContent['homepage_headings']->where('section_item_name', 'services_title')->first()->section_content ?? 'Our Services',
                    'services_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'services_subtitle')->first()->section_content ?? '',
                    'projects_title' => $allContent['homepage_headings']->where('section_item_name', 'projects_title')->first()->section_content ?? 'Featured Projects',
                    'projects_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'projects_subtitle')->first()->section_content ?? '',
                    'testimonials_title' => $allContent['homepage_headings']->where('section_item_name', 'testimonials_title')->first()->section_content ?? 'What Our Clients Say',
                    'testimonials_subtitle' => $allContent['homepage_headings']->where('section_item_name', 'testimonials_subtitle')->first()->section_content ?? '',
                ],
                'stats' => [
                    'projects_completed' => $allContent->get('homepage_stats')?->where('section_item_name', 'stats_projects_completed')->first()->section_content ?? '500+',
                    'years_experience' => $allContent->get('homepage_stats')?->where('section_item_name', 'stats_years_experience')->first()->section_content ?? '40',
                    'happy_clients' => $allContent->get('homepage_stats')?->where('section_item_name', 'stats_happy_clients')->first()->section_content ?? '150',
                    'awards_won' => $allContent->get('homepage_stats')?->where('section_item_name', 'stats_awards_won')->first()->section_content ?? '25',
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $homepage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching homepage content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Legacy support - keep old methods
    public function getProductCategories() { return response()->json(['success' => true, 'data' => []]); }
    public function getFeaturedNews() { return response()->json(['success' => true, 'data' => []]); }
    public function getNewsCategories() { return response()->json(['success' => true, 'data' => []]); }
    public function getGalleryCategories() { return response()->json(['success' => true, 'data' => []]); }
    public function getProduct($slug) { return response()->json(['success' => true, 'data' => Product::where('slug', $slug)->first()]); }
    public function getArticle($slug) { return response()->json(['success' => true, 'data' => null]); }
}
