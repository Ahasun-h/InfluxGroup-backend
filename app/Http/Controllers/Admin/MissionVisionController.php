<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MissionVisionController extends Controller
{
    /**
     * Display the mission & vision management page
     */
    public function index(): View
    {
        // Fetch all mission & vision items
        $mvItemsData = ContentManagement::where('section_name', 'mission_vision')
            ->get()
            ->keyBy('section_item_name');

        // Map content to the expected format
        $mvItems = [
            'mission' => [
                'title' => $mvItemsData['mission_title']->section_content ?? 'Our Mission',
                'description' => $mvItemsData['mission_description']->section_content ?? 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
                'points' => json_decode($mvItemsData['mission_points']->section_content ?? '[]', true) ?: [
                    'Powering Bangladesh\'s development through innovative energy solutions',
                    'Ensuring energy security for future generations',
                    'Building sustainable infrastructure nationwide'
                ]
            ],
            'vision' => [
                'title' => $mvItemsData['vision_title']->section_content ?? 'Our Vision',
                'description' => $mvItemsData['vision_description']->section_content ?? 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
                'points' => json_decode($mvItemsData['vision_points']->section_content ?? '[]', true) ?: [
                    'Regional leadership in sustainable infrastructure development',
                    'Global recognition for engineering excellence',
                    'Pioneering renewable energy adoption'
                ]
            ]
        ];

        return view('admin.cms-section.mission-vision-section', compact('mvItems'));
    }

    /**
     * Update the mission & vision section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle Mission Update
        if ($request->has('mission')) {
            $mission = $request->mission;
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'mission_title'],
                ['section_content' => $mission['title']]
            );
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'mission_description'],
                ['section_content' => $mission['description']]
            );

            $missionPoints = array_filter($mission['points'] ?? []);
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'mission_points'],
                ['section_content' => json_encode(array_values($missionPoints))]
            );
        }

        // Handle Vision Update
        if ($request->has('vision')) {
            $vision = $request->vision;
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'vision_title'],
                ['section_content' => $vision['title']]
            );
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'vision_description'],
                ['section_content' => $vision['description']]
            );

            $visionPoints = array_filter($vision['points'] ?? []);
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'vision_points'],
                ['section_content' => json_encode(array_values($visionPoints))]
            );
        }

        return redirect()->route('admin.cms-section.mission-vision-section')
            ->with('success', 'Mission & Vision updated successfully.');
    }
}
