<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class CareerPageController extends Controller
{
    public function index(): View
    {
        $cmsData = $this->loadAllCmsData();
        return view('admin.cms-section.career-page', compact('cmsData'));
    }

    private function loadAllCmsData(): array
    {
        return [
            'hero' => $this->loadHeroSection(),
            'cta'  => $this->loadCtaSection(),
        ];
    }

    private function updateOrCreate(string $sectionName, string $itemName, array $values): ContentManagement
    {
        $item = ContentManagement::where('section_name', $sectionName)
            ->where('section_item_name', $itemName)
            ->where(function ($q) {
                $q->where('page_name', 'career_page')->orWhereNull('page_name');
            })->first();

        if ($item) {
            $item->update(array_merge(['page_name' => 'career_page'], $values));
            return $item;
        }

        return ContentManagement::create(array_merge([
            'page_name'         => 'career_page',
            'section_name'      => $sectionName,
            'section_item_name' => $itemName,
        ], $values));
    }

    private function loadHeroSection(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'career_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_hero')
            ->get()
            ->keyBy('section_item_name');

        return [
            'badge'       => $items['career_hero_badge']->section_content       ?? 'Join Our Team',
            'title'       => $items['career_hero_title']->section_content       ?? 'Career <span class="text-industrial-blue">Opportunities</span>',
            'description' => $items['career_hero_description']->section_content ?? 'Build your career with Bangladesh\'s leading engineering conglomerate. Join our team of professionals powering the nation\'s infrastructure development.',
            'stat1_value' => $items['career_hero_stat1_value']->section_content ?? '45+',
            'stat1_label' => $items['career_hero_stat1_label']->section_content ?? 'Years of Excellence',
            'stat2_value' => $items['career_hero_stat2_value']->section_content ?? '500+',
            'stat2_label' => $items['career_hero_stat2_label']->section_content ?? 'Technical Professionals',
            'stat3_value' => $items['career_hero_stat3_value']->section_content ?? '15+',
            'stat3_label' => $items['career_hero_stat3_label']->section_content ?? 'Current Openings',
        ];
    }

    private function loadCtaSection(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'career_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_contact_cta')
            ->get()
            ->keyBy('section_item_name');

        return [
            'badge'       => $items['career_cta_badge']->section_content       ?? 'Don\'t See a Matching Role?',
            'title'       => $items['career_cta_title']->section_content       ?? 'Ready to <span class="text-industrial-blue">Apply?</span>',
            'description' => $items['career_cta_description']->section_content ?? 'Send your CV and cover letter to our HR team. We review all applications and contact shortlisted candidates within 2 weeks.',
            'email'       => $items['career_cta_email']->section_content       ?? 'careers@influxgroup.com',
            'phone'       => $items['career_cta_phone']->section_content       ?? '+880 2 987 6543',
            'address'     => $items['career_cta_address']->section_content     ?? 'Head Office: Dhaka, Bangladesh',
        ];
    }

    public function update(Request $request, string $section): JsonResponse
    {
        try {
            if ($section === 'hero') {
                return $this->updateHeroSection($request);
            } elseif ($section === 'contact-cta' || $section === 'cta') {
                return $this->updateCtaSection($request);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid section name',
            ], 400);
        } catch (\Exception $e) {
            Log::error("Error updating Career Page CMS section {$section}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save section data: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function updateHeroSection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge'       => 'nullable|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'stat1_value' => 'nullable|string|max:255',
            'stat1_label' => 'nullable|string|max:255',
            'stat2_value' => 'nullable|string|max:255',
            'stat2_label' => 'nullable|string|max:255',
            'stat3_value' => 'nullable|string|max:255',
            'stat3_label' => 'nullable|string|max:255',
        ]);

        if ($request->has('badge')) {
            $this->updateOrCreate('career_hero', 'career_hero_badge', ['section_content' => $validated['badge'] ?? 'Join Our Team']);
        }
        if ($request->has('title')) {
            $this->updateOrCreate('career_hero', 'career_hero_title', ['section_content' => $validated['title'] ?? 'Career <span class="text-industrial-blue">Opportunities</span>']);
        }
        if ($request->has('description')) {
            $this->updateOrCreate('career_hero', 'career_hero_description', ['section_content' => $validated['description'] ?? 'Build your career with Bangladesh\'s leading engineering conglomerate.']);
        }
        if ($request->has('stat1_value')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat1_value', ['section_content' => $validated['stat1_value'] ?? '45+']);
        }
        if ($request->has('stat1_label')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat1_label', ['section_content' => $validated['stat1_label'] ?? 'Years of Excellence']);
        }
        if ($request->has('stat2_value')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat2_value', ['section_content' => $validated['stat2_value'] ?? '500+']);
        }
        if ($request->has('stat2_label')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat2_label', ['section_content' => $validated['stat2_label'] ?? 'Technical Professionals']);
        }
        if ($request->has('stat3_value')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat3_value', ['section_content' => $validated['stat3_value'] ?? '15+']);
        }
        if ($request->has('stat3_label')) {
            $this->updateOrCreate('career_hero', 'career_hero_stat3_label', ['section_content' => $validated['stat3_label'] ?? 'Current Openings']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Career Hero Section updated successfully.',
            'data'    => $this->loadHeroSection(),
        ]);
    }

    private function updateCtaSection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'badge'       => 'nullable|string|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email'       => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
        ]);

        if ($request->has('badge')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_badge', ['section_content' => $validated['badge'] ?? 'Don\'t See a Matching Role?']);
        }
        if ($request->has('title')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_title', ['section_content' => $validated['title'] ?? 'Ready to <span class="text-industrial-blue">Apply?</span>']);
        }
        if ($request->has('description')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_description', ['section_content' => $validated['description'] ?? 'Send your CV and cover letter to our HR team.']);
        }
        if ($request->has('email')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_email', ['section_content' => $validated['email'] ?? 'careers@influxgroup.com']);
        }
        if ($request->has('phone')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_phone', ['section_content' => $validated['phone'] ?? '+880 2 987 6543']);
        }
        if ($request->has('address')) {
            $this->updateOrCreate('career_contact_cta', 'career_cta_address', ['section_content' => $validated['address'] ?? 'Head Office: Dhaka, Bangladesh']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Career Contact CTA Section updated successfully.',
            'data'    => $this->loadCtaSection(),
        ]);
    }
}
