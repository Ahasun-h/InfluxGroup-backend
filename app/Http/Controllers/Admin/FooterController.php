<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display the footer management page
     */
    public function index()
    {
        // Fetch all footer items
        $footerItems = ContentManagement::where('section_name', 'footer_section')
            ->orderBy('id')
            ->get();

        // Group items by their item name
        $groupedItems = $footerItems->groupBy('section_item_name');

        // Company Info
        $companyInfo = [
            'description' => $groupedItems->get('footer_company_description')?->first()?->section_content ?? '',
            'logo' => $groupedItems->get('footer_company_logo')?->first()?->media_files['source_file'] ?? null,
        ];

        // Social Media Links
        $socialMedia = [];
        for ($i = 1; $i <= 3; $i++) {
            $item = $groupedItems->get("footer_social_media_{$i}");
            if ($item && $item->first()) {
                $data = json_decode($item->first()->section_content, true);
                if ($data && isset($data['platform']) && isset($data['url'])) {
                    $socialMedia[] = [
                        'id' => $item->first()->id,
                        'platform' => $data['platform'],
                        'url' => $data['url'],
                        'label' => $data['label'] ?? ucfirst($data['platform']),
                    ];
                }
            }
        }

        // Bottom Bar
        $bottomBar = [
            'copyright_text' => $groupedItems->get('footer_copyright_text')?->first()?->section_content ?? '',
            'iso_certification' => $groupedItems->get('footer_iso_certification')?->first()?->section_content ?? '',
            'show_iso_badge' => filter_var($groupedItems->get('footer_show_iso_badge')?->first()?->section_content ?? 'true', FILTER_VALIDATE_BOOLEAN),
        ];

        return view('admin.footer.index', compact('companyInfo', 'socialMedia', 'bottomBar'));
    }

    /**
     * Update footer content
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_description' => 'nullable|string',
            'copyright_text' => 'nullable|string',
            'iso_certification' => 'nullable|string',
            'show_iso_badge' => 'nullable',
            'social_media_1_platform' => 'nullable|string',
            'social_media_1_url' => 'nullable|url',
            'social_media_2_platform' => 'nullable|string',
            'social_media_2_url' => 'nullable|url',
            'social_media_3_platform' => 'nullable|string',
            'social_media_3_url' => 'nullable|url',
        ]);

        // Update or create company description
        $this->updateOrCreateFooterItem('footer_company_description', $validated['company_description'] ?? '');

        // Update copyright text
        $this->updateOrCreateFooterItem('footer_copyright_text', $validated['copyright_text'] ?? '');

        // Update ISO certification
        $this->updateOrCreateFooterItem('footer_iso_certification', $validated['iso_certification'] ?? '');

        // Update ISO badge visibility - checkbox sends "1" when checked, null when unchecked
        $showIsoBadge = isset($validated['show_iso_badge']) && $validated['show_iso_badge'] === '1' ? 'true' : 'false';
        $this->updateOrCreateFooterItem('footer_show_iso_badge', $showIsoBadge);

        // Update Social Media Links
        for ($i = 1; $i <= 3; $i++) {
            $platform = $validated["social_media_{$i}_platform"] ?? null;
            $url = $validated["social_media_{$i}_url"] ?? null;

            if ($platform && $url) {
                $socialMediaData = [
                    'platform' => $platform,
                    'url' => $url,
                    'label' => ucfirst($platform),
                ];
                $this->updateOrCreateFooterItem("footer_social_media_{$i}", json_encode($socialMediaData));
            }
        }

        return redirect()->back()->with('success', 'Footer content updated successfully!');
    }

    /**
     * Helper method to update or create a footer item
     */
    private function updateOrCreateFooterItem($itemName, $content)
    {
        $item = ContentManagement::where('section_name', 'footer_section')
            ->where('section_item_name', $itemName)
            ->first();

        if ($item) {
            $item->update(['section_content' => $content]);
        } else {
            ContentManagement::create([
                'section_name' => 'footer_section',
                'section_item_name' => $itemName,
                'section_content' => $content,
            ]);
        }
    }
}
