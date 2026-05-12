<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
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
        $hero = Hero::firstOrCreate(
            ['is_active' => true],
            [
                'badge' => 'Leaders in Energy & Infrastructure',
                'title' => 'POWERING BANGLADESH SINCE 1980',
                'description' => 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
                'cta_buttons' => [
                    [
                        'type' => 'primary',
                        'text' => 'EXPLORE CATALOG',
                        'link' => '/projects',
                        'order' => 1
                    ],
                    [
                        'type' => 'secondary',
                        'text' => 'CORPORATE PROFILE',
                        'link' => '/about',
                        'order' => 2
                    ]
                ],
                'background_image' => '/hero.png',
                'categories' => [
                    [
                        'title' => 'Transformers',
                        'subtitle' => '45+ Models',
                        'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
                        'link' => '/products/transformers',
                        'order' => 1
                    ],
                    [
                        'title' => 'Switchgear',
                        'subtitle' => '120+ Models',
                        'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path><circle cx="12" cy="12" r="3"></circle></svg>',
                        'link' => '/products/switchgear',
                        'order' => 2
                    ],
                    [
                        'title' => 'Renewables',
                        'subtitle' => '12GW Models',
                        'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.8 19.6A2 2 0 1 0 14 16H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.8 4.4A2 2 0 1 1 11 8H2"></path></svg>',
                        'link' => '/products/renewables',
                        'order' => 3
                    ],
                    [
                        'title' => 'Automation',
                        'subtitle' => '80+ Models',
                        'icon' => '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>',
                        'link' => '/products/automation',
                        'order' => 4
                    ]
                ],
                'is_active' => true
            ]
        );

        return view('admin.hero.index', compact('hero'));
    }

    /**
     * Update the hero section
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:255',
            'secondary_button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            // Dynamic category fields
            'cat1_title' => 'nullable|string|max:255',
            'cat1_subtitle' => 'nullable|string|max:255',
            'cat1_icon' => 'nullable|string',
            'cat1_link' => 'nullable|string|max:255',
            'cat2_title' => 'nullable|string|max:255',
            'cat2_subtitle' => 'nullable|string|max:255',
            'cat2_icon' => 'nullable|string',
            'cat2_link' => 'nullable|string|max:255',
            'cat3_title' => 'nullable|string|max:255',
            'cat3_subtitle' => 'nullable|string|max:255',
            'cat3_icon' => 'nullable|string',
            'cat3_link' => 'nullable|string|max:255',
            'cat4_title' => 'nullable|string|max:255',
            'cat4_subtitle' => 'nullable|string|max:255',
            'cat4_icon' => 'nullable|string',
            'cat4_link' => 'nullable|string|max:255'
        ]);

        // Handle file upload for background image
        if ($request->hasFile('background_image_dropify')) {
            $file = $request->file('background_image_dropify');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hero'), $filename);
            $validated['background_image'] = '/uploads/hero/' . $filename;
        }

        $hero = Hero::where('is_active', true)->first();
        if (!$hero) {
            $hero = new Hero();
            $hero->is_active = true;
        }

        // Update basic fields
        $hero->badge = $validated['badge'] ?? null;
        $hero->title = $validated['title'] ?? null;
        $hero->description = $validated['description'] ?? null;
        $hero->background_image = $validated['background_image'] ?? null;

        // Update CTA buttons dynamically
        $ctaButtons = $hero->cta_buttons ?? [];

        // Update primary CTA
        if (isset($validated['cta_button_text']) || isset($validated['cta_button_link'])) {
            $primaryIndex = collect($ctaButtons)->search(function($button) {
                return $button['type'] === 'primary';
            });

            if ($primaryIndex !== false) {
                $ctaButtons[$primaryIndex]['text'] = $validated['cta_button_text'] ?? $ctaButtons[$primaryIndex]['text'];
                $ctaButtons[$primaryIndex]['link'] = $validated['cta_button_link'] ?? $ctaButtons[$primaryIndex]['link'];
            } else {
                $ctaButtons[] = [
                    'type' => 'primary',
                    'text' => $validated['cta_button_text'] ?? 'EXPLORE CATALOG',
                    'link' => $validated['cta_button_link'] ?? '/projects',
                    'order' => 1
                ];
            }
        }

        // Update secondary CTA
        if (isset($validated['secondary_button_text']) || isset($validated['secondary_button_link'])) {
            $secondaryIndex = collect($ctaButtons)->search(function($button) {
                return $button['type'] === 'secondary';
            });

            if ($secondaryIndex !== false) {
                $ctaButtons[$secondaryIndex]['text'] = $validated['secondary_button_text'] ?? $ctaButtons[$secondaryIndex]['text'];
                $ctaButtons[$secondaryIndex]['link'] = $validated['secondary_button_link'] ?? $ctaButtons[$secondaryIndex]['link'];
            } else {
                $ctaButtons[] = [
                    'type' => 'secondary',
                    'text' => $validated['secondary_button_text'] ?? 'CORPORATE PROFILE',
                    'link' => $validated['secondary_button_link'] ?? '/about',
                    'order' => 2
                ];
            }
        }

        $hero->cta_buttons = $ctaButtons;

        // Update categories dynamically
        $categories = $hero->categories ?? [];

        for ($i = 1; $i <= 4; $i++) {
            $catTitle = $validated["cat{$i}_title"] ?? null;
            $catSubtitle = $validated["cat{$i}_subtitle"] ?? null;
            $catIcon = $validated["cat{$i}_icon"] ?? null;
            $catLink = $validated["cat{$i}_link"] ?? null;

            if ($catTitle || $catSubtitle || $catIcon) {
                $catIndex = collect($categories)->search(function($cat) use ($i) {
                    return isset($cat['order']) && $cat['order'] == $i;
                });

                $categoryData = [
                    'title' => $catTitle,
                    'subtitle' => $catSubtitle,
                    'icon' => $catIcon,
                    'link' => $catLink,
                    'order' => $i
                ];

                if ($catIndex !== false) {
                    $categories[$catIndex] = array_merge($categories[$catIndex], array_filter($categoryData));
                } else {
                    $categories[] = array_filter($categoryData);
                }
            }
        }

        $hero->categories = $categories;
        $hero->save();

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section updated successfully.');
    }

    /**
     * Preview the hero section
     */
    public function preview(): View
    {
        $hero = Hero::where('is_active', true)->first();
        return view('admin.hero.preview', compact('hero'));
    }
}
