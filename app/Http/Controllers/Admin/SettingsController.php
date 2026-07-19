<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(): View
    {
        $settings = $this->getSettings();
        $footerData = $this->getFooterData();

        return view('admin.settings.index', compact('settings', 'footerData'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            // Header Settings
            'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'header_logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,svg|max:1024',
            'company_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',

            // Contact Info
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',

            // Footer Settings
            'footer_company_description' => 'nullable|string|max:1000',
            'footer_copyright_text' => 'nullable|string|max:500',
            'footer_iso_certification' => 'nullable|string|max:255',
            'show_iso_badge' => 'nullable',

            // Footer Social Media
            'footer_social_media_1_platform' => 'nullable|string|max:50',
            'footer_social_media_1_url' => 'nullable|url|max:255',
            'footer_social_media_2_platform' => 'nullable|string|max:50',
            'footer_social_media_2_url' => 'nullable|url|max:255',
            'footer_social_media_3_platform' => 'nullable|string|max:50',
            'footer_social_media_3_url' => 'nullable|url|max:255',

            // SEO Settings
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        // Handle file uploads
        if ($request->hasFile('header_logo')) {
            $headerLogo = $request->file('header_logo');
            $headerLogoPath = $headerLogo->store('settings', 'public');
            $this->updateOrCreateSetting('header_logo', $headerLogoPath);

            // Delete old logo if exists
            $oldLogo = ContentManagement::where('section_name', 'settings')
                ->where('section_item_name', 'old_header_logo')
                ->first();
            if ($oldLogo && file_exists(public_path('storage/' . $oldLogo->section_content))) {
                unlink(public_path('storage/' . $oldLogo->section_content));
            }
        }

        if ($request->hasFile('header_logo_dark')) {
            $headerLogoDark = $request->file('header_logo_dark');
            $headerLogoDarkPath = $headerLogoDark->store('settings', 'public');
            $this->updateOrCreateSetting('header_logo_dark', $headerLogoDarkPath);

            // Delete old dark logo if exists
            $oldLogoDark = ContentManagement::where('section_name', 'settings')
                ->where('section_item_name', 'old_header_logo_dark')
                ->first();
            if ($oldLogoDark && file_exists(public_path('storage/' . $oldLogoDark->section_content))) {
                unlink(public_path('storage/' . $oldLogoDark->section_content));
            }
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconPath = $favicon->store('settings', 'public');
            $this->updateOrCreateSetting('favicon', $faviconPath);

            // Copy favicon to root for browser recognition
            $favicon->move(public_path(), 'favicon.ico');

            // Delete old favicon if exists
            $oldFavicon = ContentManagement::where('section_name', 'settings')
                ->where('section_item_name', 'old_favicon')
                ->first();
            if ($oldFavicon && file_exists(public_path('storage/' . $oldFavicon->section_content))) {
                unlink(public_path('storage/' . $oldFavicon->section_content));
            }
        }

        // Update text settings
        $settingsFields = [
            'company_name', 'tagline', 'phone', 'email', 'address',
            'meta_title', 'meta_description', 'meta_keywords'
        ];

        foreach ($settingsFields as $field) {
            if ($request->has($field)) {
                $this->updateOrCreateSetting($field, $request->input($field));
            }
        }

        // Update footer settings
        $footerFields = [
            'footer_company_description' => 'footer_company_description',
            'footer_copyright_text' => 'footer_copyright_text',
            'footer_iso_certification' => 'footer_iso_certification'
        ];

        foreach ($footerFields as $dbField => $requestField) {
            $value = $request->input($requestField, '');
            $this->updateOrCreateFooterItem($dbField, $value);
        }

        // Update ISO badge visibility
        $showIsoBadge = isset($request->show_iso_badge) && $request->show_iso_badge === '1' ? 'true' : 'false';
        $this->updateOrCreateFooterItem('footer_show_iso_badge', $showIsoBadge);

        // Update footer social media links
        for ($i = 1; $i <= 3; $i++) {
            $platform = $request->input("footer_social_media_{$i}_platform");
            $url = $request->input("footer_social_media_{$i}_url");

            if ($platform && $url) {
                $socialMediaData = [
                    'platform' => $platform,
                    'url' => $url,
                    'label' => ucfirst($platform),
                ];
                $this->updateOrCreateFooterItem("footer_social_media_{$i}", json_encode($socialMediaData));
            } else {
                // Remove empty social media entries
                ContentManagement::where('section_name', 'footer_section')
                    ->where('section_item_name', "footer_social_media_{$i}")
                    ->delete();
            }
        }

        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Get current settings from database.
     */
    private function getSettings(): array
    {
        $settingsItems = ContentManagement::where('section_name', 'settings')
            ->get()
            ->keyBy('section_item_name');

        $defaultSettings = [
            'company_name' => 'Influx Group Engineering',
            'tagline' => 'Power Infrastructure Solutions',
            'phone' => '+880 2 987 6543',
            'email' => 'info@influxgroup.com',
            'address' => 'Dhaka, Bangladesh',
            'meta_title' => 'Influx Group - Power Infrastructure Solutions',
            'meta_description' => 'Leading engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems in Bangladesh.',
            'meta_keywords' => 'power infrastructure, engineering, transformers, renewable energy, Bangladesh',
        ];

        foreach ($defaultSettings as $key => $default) {
            if (isset($settingsItems[$key])) {
                $defaultSettings[$key] = $settingsItems[$key]->section_content;
            }
        }

        // Handle file fields separately
        if (isset($settingsItems['header_logo'])) {
            $defaultSettings['header_logo'] = $settingsItems['header_logo']->section_content;
        }
        if (isset($settingsItems['header_logo_dark'])) {
            $defaultSettings['header_logo_dark'] = $settingsItems['header_logo_dark']->section_content;
        }
        if (isset($settingsItems['favicon'])) {
            $defaultSettings['favicon'] = $settingsItems['favicon']->section_content;
        }

        return $defaultSettings;
    }

    /**
     * Get footer data from database.
     */
    private function getFooterData(): array
    {
        $footerItems = ContentManagement::where('section_name', 'footer_section')
            ->get()
            ->keyBy('section_item_name');

        $socialMedia = [];
        for ($i = 1; $i <= 3; $i++) {
            $item = $footerItems->get("footer_social_media_{$i}");
            if ($item) {
                $data = json_decode($item->section_content, true);
                if ($data && isset($data['platform']) && isset($data['url'])) {
                    $socialMedia[] = [
                        'platform' => $data['platform'],
                        'url' => $data['url'],
                        'label' => $data['label'] ?? ucfirst($data['platform']),
                    ];
                }
            }
        }

        return [
            'company_description' => $footerItems->get('footer_company_description')->section_content ?? '',
            'copyright_text' => $footerItems->get('footer_copyright_text')->section_content ?? '',
            'iso_certification' => $footerItems->get('footer_iso_certification')->section_content ?? '',
            'show_iso_badge' => filter_var($footerItems->get('footer_show_iso_badge')->section_content ?? 'true', FILTER_VALIDATE_BOOLEAN),
            'social_media' => $socialMedia,
        ];
    }

    /**
     * Update or create a setting item.
     */
    private function updateOrCreateSetting($itemName, $content)
    {
        $item = ContentManagement::where('section_name', 'settings')
            ->where('section_item_name', $itemName)
            ->first();

        if ($item) {
            $item->update(['section_content' => $content]);
        } else {
            ContentManagement::create([
                'section_name' => 'settings',
                'section_item_name' => $itemName,
                'section_content' => $content,
            ]);
        }
    }

    /**
     * Update or create a footer item.
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

    /**
     * Delete header logo.
     */
    public function deleteLogo(): RedirectResponse
    {
        $logoItem = ContentManagement::where('section_name', 'settings')
            ->where('section_item_name', 'header_logo')
            ->first();

        if ($logoItem && file_exists(public_path('storage/' . $logoItem->section_content))) {
            unlink(public_path('storage/' . $logoItem->section_content));
        }

        if ($logoItem) {
            $logoItem->update(['section_content' => '']);
        }

        return redirect()->back()
            ->with('success', 'Logo deleted successfully.');
    }

    /**
     * Delete favicon.
     */
    public function deleteFavicon(): RedirectResponse
    {
        $faviconItem = ContentManagement::where('section_name', 'settings')
            ->where('section_item_name', 'favicon')
            ->first();

        if ($faviconItem && file_exists(public_path('storage/' . $faviconItem->section_content))) {
            unlink(public_path('storage/' . $faviconItem->section_content));
        }

        if ($faviconItem) {
            $faviconItem->update(['section_content' => '']);
        }

        // Delete root favicon if exists
        if (file_exists(public_path('favicon.ico'))) {
            unlink(public_path('favicon.ico'));
        }

        return redirect()->back()
            ->with('success', 'Favicon deleted successfully.');
    }

    /**
     * Delete dark header logo.
     */
    public function deleteLogoDark(): RedirectResponse
    {
        $logoDarkItem = ContentManagement::where('section_name', 'settings')
            ->where('section_item_name', 'header_logo_dark')
            ->first();

        if ($logoDarkItem && file_exists(public_path('storage/' . $logoDarkItem->section_content))) {
            unlink(public_path('storage/' . $logoDarkItem->section_content));
        }

        if ($logoDarkItem) {
            $logoDarkItem->update(['section_content' => '']);
        }

        return redirect()->back()
            ->with('success', 'Dark logo deleted successfully.');
    }
}