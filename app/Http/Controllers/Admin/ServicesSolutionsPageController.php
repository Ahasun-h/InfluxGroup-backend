<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ServicesSolutionsPageController extends Controller
{
    /**
     * Display the services & solutions page management
     */
    public function index(): View
    {
        // Get or create hero section badge text content
        $badgeText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'hero_badge_text'
            ],
            [
                'section_content' => 'What We Offer',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create hero section title
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'hero_title'
            ],
            [
                'section_content' => 'SERVICES & <span class="text-industrial-blue">SOLUTIONS</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create hero section description
        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'hero_description'
            ],
            [
                'section_content' => 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create process section title
        $processTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'process_title'
            ],
            [
                'section_content' => 'Our <span class="text-industrial-blue">Process</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create process section description
        $processDescription = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'process_description'
            ],
            [
                'section_content' => 'A systematic approach to delivering excellence in every project',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create process steps (stored as JSON)
        $processSteps = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'process_steps'
            ],
            [
                'section_content' => json_encode([
                    [
                        'step' => '01',
                        'title' => 'Consultation',
                        'description' => 'Understanding your requirements and developing customized solutions'
                    ],
                    [
                        'step' => '02',
                        'title' => 'Design',
                        'description' => 'Engineering detailed designs and specifications for optimal performance'
                    ],
                    [
                        'step' => '03',
                        'title' => 'Implementation',
                        'description' => 'Executing projects with precision and adherence to timelines'
                    ],
                    [
                        'step' => '04',
                        'title' => 'Support',
                        'description' => 'Providing ongoing maintenance and technical support throughout lifecycle'
                    ]
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create industries section title
        $industriesTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'industries_title'
            ],
            [
                'section_content' => 'Industries We <span class="text-industrial-blue">Serve</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create industries section description
        $industriesDescription = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'industries_description'
            ],
            [
                'section_content' => 'Delivering specialized solutions across diverse sectors',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create industries list (stored as JSON)
        $industriesList = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'industries_list'
            ],
            [
                'section_content' => json_encode([
                    ['name' => 'Power Generation', 'icon' => 'Zap'],
                    ['name' => 'Textile', 'icon' => 'Factory'],
                    ['name' => 'Pharmaceuticals', 'icon' => 'Building2'],
                    ['name' => 'Construction', 'icon' => 'Building2'],
                    ['name' => 'Food Processing', 'icon' => 'Factory'],
                    ['name' => 'Telecom', 'icon' => 'Zap']
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create why choose us section title
        $whyChooseUsTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'why_choose_us_title'
            ],
            [
                'section_content' => 'Why Choose <span class="text-industrial-blue">Influx Group?</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create why choose us points (stored as JSON)
        $whyChooseUsPoints = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'why_choose_us_points'
            ],
            [
                'section_content' => json_encode([
                    [
                        'title' => '45+ Years of Excellence',
                        'description' => 'Decades of experience in delivering power infrastructure solutions across Bangladesh.'
                    ],
                    [
                        'title' => 'Expert Engineering Team',
                        'description' => 'Highly skilled professionals with expertise in power systems and renewable energy.'
                    ],
                    [
                        'title' => 'Quality Assurance',
                        'description' => 'ISO 9001:2015 certified processes ensuring highest quality standards.'
                    ],
                    [
                        'title' => '24/7 Support',
                        'description' => 'Round-the-clock technical support and maintenance services.'
                    ]
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create why choose us image
        $whyChooseUsImage = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'why_choose_us_image'
            ],
            [
                'section_content' => null,
                'attributes' => null,
                'media_files' => json_encode(['source_file' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200'])
            ]
        );

        // Get or create stat number
        $statNumber = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'stat_number'
            ],
            [
                'section_content' => '24/7',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create stat label
        $statLabel = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'stat_label'
            ],
            [
                'section_content' => 'Support Available',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create CTA title
        $ctaTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'cta_title'
            ],
            [
                'section_content' => 'Ready to Get <span class="text-yellow-400">Started?</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create CTA description
        $ctaDescription = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'cta_description'
            ],
            [
                'section_content' => 'Contact our team to discuss your power infrastructure needs',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create CTA button text
        $ctaButtonText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'services_solutions_page',
                'section_item_name' => 'cta_button_text'
            ],
            [
                'section_content' => 'Request Consultation',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all services_solutions_page items for the view
        $pageItems = ContentManagement::where('section_name', 'services_solutions_page')
            ->get()
            ->keyBy('section_item_name');

        return view('admin.cms-section.services-solutions-page', compact('pageItems'));
    }

    /**
     * Update the services & solutions page content
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle hero badge text update
        if ($request->has('hero_badge')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'hero_badge_text'
                ],
                [
                    'section_content' => $request->hero_badge,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle hero title update
        if ($request->has('hero_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'hero_title'
                ],
                [
                    'section_content' => $request->hero_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle hero description update
        if ($request->has('hero_description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'hero_description'
                ],
                [
                    'section_content' => $request->hero_description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle process section updates
        if ($request->has('process_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'process_title'
                ],
                [
                    'section_content' => $request->process_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('process_description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'process_description'
                ],
                [
                    'section_content' => $request->process_description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle process steps
        if ($request->has('process_steps')) {
            $steps = [];
            for ($i = 1; $i <= 4; $i++) {
                $stepNum = $request->input("step{$i}_number") ?? sprintf('%02d', $i);
                $stepTitle = $request->input("step{$i}_title");
                $stepDesc = $request->input("step{$i}_description");

                if ($stepTitle && $stepDesc) {
                    $steps[] = [
                        'step' => $stepNum,
                        'title' => $stepTitle,
                        'description' => $stepDesc
                    ];
                }
            }

            if (!empty($steps)) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'services_solutions_page',
                        'section_item_name' => 'process_steps'
                    ],
                    [
                        'section_content' => json_encode($steps),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle industries section updates
        if ($request->has('industries_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'industries_title'
                ],
                [
                    'section_content' => $request->industries_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('industries_description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'industries_description'
                ],
                [
                    'section_content' => $request->industries_description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle industries list
        if ($request->has('industries_list')) {
            $industries = [];
            for ($i = 1; $i <= 6; $i++) {
                $indName = $request->input("industry{$i}_name");
                $indIcon = $request->input("industry{$i}_icon");

                if ($indName && $indIcon) {
                    $industries[] = [
                        'name' => $indName,
                        'icon' => $indIcon
                    ];
                }
            }

            if (!empty($industries)) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'services_solutions_page',
                        'section_item_name' => 'industries_list'
                    ],
                    [
                        'section_content' => json_encode($industries),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle why choose us section updates
        if ($request->has('why_choose_us_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'why_choose_us_title'
                ],
                [
                    'section_content' => $request->why_choose_us_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle why choose us points
        if ($request->has('why_choose_us_points')) {
            $points = [];
            for ($i = 1; $i <= 4; $i++) {
                $pointTitle = $request->input("point{$i}_title");
                $pointDesc = $request->input("point{$i}_description");

                if ($pointTitle && $pointDesc) {
                    $points[] = [
                        'title' => $pointTitle,
                        'description' => $pointDesc
                    ];
                }
            }

            if (!empty($points)) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'services_solutions_page',
                        'section_item_name' => 'why_choose_us_points'
                    ],
                    [
                        'section_content' => json_encode($points),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle why choose us image
        $whyChooseUsImage = null;
        if ($request->hasFile('why_choose_us_image')) {
            $file = $request->file('why_choose_us_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/services-solutions-page'), $filename);
            $whyChooseUsImage = '/uploads/services-solutions-page/' . $filename;
        } elseif ($request->has('why_choose_us_image')) {
            $whyChooseUsImage = $request->why_choose_us_image;
        }

        if ($whyChooseUsImage) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'why_choose_us_image'
                ],
                [
                    'section_content' => null,
                    'attributes' => null,
                    'media_files' => json_encode(['source_file' => $whyChooseUsImage])
                ]
            );
        }

        // Handle stat updates
        if ($request->has('stat_number')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'stat_number'
                ],
                [
                    'section_content' => $request->stat_number,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('stat_label')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'stat_label'
                ],
                [
                    'section_content' => $request->stat_label,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle CTA section updates
        if ($request->has('cta_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'cta_title'
                ],
                [
                    'section_content' => $request->cta_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('cta_description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'cta_description'
                ],
                [
                    'section_content' => $request->cta_description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('cta_button_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'services_solutions_page',
                    'section_item_name' => 'cta_button_text'
                ],
                [
                    'section_content' => $request->cta_button_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        return redirect()->route('admin.services-solutions-page.index')
            ->with('success', 'Services & Solutions page content updated successfully.');
    }
}