<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            // Header Settings
            'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,svg|max:1024',
            'company_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',

            // Contact Info
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',

            // Social Links
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',

            // Footer Settings
            'footer_text' => 'nullable|string|max:1000',
            'copyright_text' => 'nullable|string|max:500',

            // SEO Settings
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $settings = [];

        // Handle file uploads
        if ($request->hasFile('header_logo')) {
            $headerLogo = $request->file('header_logo');
            $headerLogoPath = $headerLogo->store('settings', 'public');
            $settings['header_logo'] = $headerLogoPath;

            // Delete old logo if exists
            if (file_exists(public_path('storage/' . $request->old_header_logo))) {
                unlink(public_path('storage/' . $request->old_header_logo));
            }
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconPath = $favicon->store('settings', 'public');
            $settings['favicon'] = $faviconPath;

            // Copy favicon to root for browser recognition
            $favicon->move(public_path(), 'favicon.ico');

            // Delete old favicon if exists
            if (file_exists(public_path('storage/' . $request->old_favicon))) {
                unlink(public_path('storage/' . $request->old_favicon));
            }
        }

        // Text fields
        $textFields = [
            'company_name', 'tagline', 'phone', 'email', 'address',
            'facebook', 'twitter', 'linkedin', 'youtube',
            'footer_text', 'copyright_text', 'meta_title', 'meta_description', 'meta_keywords'
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $settings[$field] = $request->input($field);
            }
        }

        // Save settings to file or database
        $this->saveSettings($settings);

        return redirect()->back()
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Get current settings.
     */
    private function getSettings(): array
    {
        // Try to get from JSON file first
        $settingsPath = storage_path('app/settings.json');

        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            return $settings ?: [];
        }

        // Default settings
        return [
            'company_name' => 'Influx Group Engineering',
            'tagline' => 'Power Infrastructure Solutions',
            'phone' => '+880 2 987 6543',
            'email' => 'info@influxgroup.com',
            'address' => 'Dhaka, Bangladesh',
            'facebook' => '',
            'twitter' => '',
            'linkedin' => '',
            'youtube' => '',
            'footer_text' => 'Bangladesh\'s premier engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems.',
            'copyright_text' => '© 2026 INFLUX GROUP ENGINEERING. ALL RIGHTS RESERVED. ISO 9001:2015 CERTIFIED.',
            'meta_title' => 'Influx Group - Power Infrastructure Solutions',
            'meta_description' => 'Leading engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems in Bangladesh.',
            'meta_keywords' => 'power infrastructure, engineering, transformers, renewable energy, Bangladesh',
        ];
    }

    /**
     * Save settings to file.
     */
    private function saveSettings(array $newSettings): void
    {
        $settingsPath = storage_path('app/settings.json');

        // Get existing settings
        $existingSettings = [];
        if (file_exists($settingsPath)) {
            $existingSettings = json_decode(file_get_contents($settingsPath), true) ?: [];
        }

        // Merge settings
        $settings = array_merge($existingSettings, $newSettings);

        // Save to file
        file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
    }

    /**
     * Delete header logo.
     */
    public function deleteLogo(): RedirectResponse
    {
        $settings = $this->getSettings();

        if (isset($settings['header_logo']) && file_exists(public_path('storage/' . $settings['header_logo']))) {
            unlink(public_path('storage/' . $settings['header_logo']));
        }

        $settings['header_logo'] = null;
        $this->saveSettings($settings);

        return redirect()->back()
            ->with('success', 'Logo deleted successfully.');
    }

    /**
     * Delete favicon.
     */
    public function deleteFavicon(): RedirectResponse
    {
        $settings = $this->getSettings();

        if (isset($settings['favicon']) && file_exists(public_path('storage/' . $settings['favicon']))) {
            unlink(public_path('storage/' . $settings['favicon']));
        }

        $settings['favicon'] = null;
        $this->saveSettings($settings);

        // Delete root favicon if exists
        if (file_exists(public_path('favicon.ico'))) {
            unlink(public_path('favicon.ico'));
        }

        return redirect()->back()
            ->with('success', 'Favicon deleted successfully.');
    }
}