<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Display the contact section management page
     */
    public function index(): View
    {
        // Get or create phone numbers
        $phone1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_phone_1'
            ],
            [
                'section_content' => '+880 2 987 6543',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $phone2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_phone_2'
            ],
            [
                'section_content' => '+880 1XXX-XXXXXX',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create email addresses
        $email1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_email_1'
            ],
            [
                'section_content' => 'info@influxgroup.com',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $email2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_email_2'
            ],
            [
                'section_content' => 'sales@influxgroup.com',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create office hours
        $officeHoursWeekdays = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_office_hours_weekdays'
            ],
            [
                'section_content' => 'Saturday - Thursday: 9:00 AM - 6:00 PM',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $officeHoursFriday = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_office_hours_friday'
            ],
            [
                'section_content' => 'Friday: Closed',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create office locations
        $office1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_office_1'
            ],
            [
                'section_content' => json_encode([
                    'city' => 'Dhaka',
                    'type' => 'Corporate Headquarters',
                    'address' => 'Level 12, Energy Plaza, Tejgaon I/A',
                    'phone' => '+880 2 987 6543',
                    'email' => 'dhaka@influxgroup.com',
                    'order' => 1
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $office2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_office_2'
            ],
            [
                'section_content' => json_encode([
                    'city' => 'Chittagong',
                    'type' => 'Regional Office',
                    'address' => 'Plot 45, GEC Circle, Nasirabad',
                    'phone' => '+880 31 654 321',
                    'email' => 'ctg@influxgroup.com',
                    'order' => 2
                ]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create Google Maps embed URL
        $mapEmbedUrl = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'contact_map_embed_url'
            ],
            [
                'section_content' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get or create Emergency Support section content
        $emergencyTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_title'
            ],
            [
                'section_content' => 'Emergency <span class="text-industrial-red">Support</span>',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $emergencyDescription = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_description'
            ],
            [
                'section_content' => '24/7 emergency support available for critical power infrastructure issues',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $emergencyPrimaryText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_primary_text'
            ],
            [
                'section_content' => 'Emergency Line',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $emergencyPrimaryLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_primary_link'
            ],
            [
                'section_content' => 'tel:+88029876543',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $emergencySecondaryText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_secondary_text'
            ],
            [
                'section_content' => 'Email Support',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $emergencySecondaryLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'contact_section',
                'section_item_name' => 'emergency_secondary_link'
            ],
            [
                'section_content' => 'mailto:support@influxgroup.com',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all contact section items for the view
        $contactItems = ContentManagement::where('section_name', 'contact_section')
            ->get()
            ->keyBy('section_item_name');

        // Get office locations
        $offices = [];
        for ($i = 1; $i <= 10; $i++) {
            $officeKey = 'contact_office_' . $i;
            if (isset($contactItems[$officeKey]) && $contactItems[$officeKey]->section_content) {
                $officeData = json_decode($contactItems[$officeKey]->section_content, true);
                if ($officeData && isset($officeData['city'])) {
                    $offices[] = $officeData;
                }
            }
        }
        $offices = collect($offices)->sortBy('order')->values();

        return view('admin.cms-section.contact-section', compact('contactItems', 'offices'));
    }

    /**
     * Update the contact section
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle phone updates
        for ($i = 1; $i <= 2; $i++) {
            if ($request->has("phone_{$i}")) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'contact_section',
                        'section_item_name' => "contact_phone_{$i}"
                    ],
                    [
                        'section_content' => $request->input("phone_{$i}"),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle email updates
        for ($i = 1; $i <= 2; $i++) {
            if ($request->has("email_{$i}")) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'contact_section',
                        'section_item_name' => "contact_email_{$i}"
                    ],
                    [
                        'section_content' => $request->input("email_{$i}"),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle office hours updates
        if ($request->has('office_hours_weekdays')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'contact_office_hours_weekdays'
                ],
                [
                    'section_content' => $request->office_hours_weekdays,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('office_hours_friday')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'contact_office_hours_friday'
                ],
                [
                    'section_content' => $request->office_hours_friday,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle Google Maps embed URL
        if ($request->has('map_embed_url')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'contact_map_embed_url'
                ],
                [
                    'section_content' => $request->map_embed_url,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle deleted offices
        if ($request->has('deleted_offices') && $request->deleted_offices) {
            $deletedOfficeIds = explode(',', $request->deleted_offices);
            foreach ($deletedOfficeIds as $officeId) {
                ContentManagement::where('section_name', 'contact_section')
                    ->where('section_item_name', 'contact_office_' . trim($officeId))
                    ->delete();
            }
        }

        // Handle Emergency Support section updates
        if ($request->has('emergency_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_title'
                ],
                [
                    'section_content' => $request->emergency_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('emergency_description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_description'
                ],
                [
                    'section_content' => $request->emergency_description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('emergency_primary_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_primary_text'
                ],
                [
                    'section_content' => $request->emergency_primary_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('emergency_primary_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_primary_link'
                ],
                [
                    'section_content' => $request->emergency_primary_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('emergency_secondary_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_secondary_text'
                ],
                [
                    'section_content' => $request->emergency_secondary_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        if ($request->has('emergency_secondary_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'contact_section',
                    'section_item_name' => 'emergency_secondary_link'
                ],
                [
                    'section_content' => $request->emergency_secondary_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle office location updates
        for ($i = 1; $i <= 10; $i++) {
            $city = $request->input("office_{$i}_city");
            $type = $request->input("office_{$i}_type");
            $address = $request->input("office_{$i}_address");
            $phone = $request->input("office_{$i}_phone");
            $email = $request->input("office_{$i}_email");

            if ($city || $type || $address || $phone || $email) {
                // Get existing office data to preserve values if not provided
                $existingOffice = ContentManagement::where('section_name', 'contact_section')
                    ->where('section_item_name', "contact_office_{$i}")
                    ->first();

                $existingData = [];
                if ($existingOffice && $existingOffice->section_content) {
                    $existingData = json_decode($existingOffice->section_content, true) ?: [];
                }

                $officeData = [
                    'city' => $city ?? ($existingData['city'] ?? ''),
                    'type' => $type ?? ($existingData['type'] ?? ''),
                    'address' => $address ?? ($existingData['address'] ?? ''),
                    'phone' => $phone ?? ($existingData['phone'] ?? ''),
                    'email' => $email ?? ($existingData['email'] ?? ''),
                    'order' => $i
                ];

                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'contact_section',
                        'section_item_name' => "contact_office_{$i}"
                    ],
                    [
                        'section_content' => json_encode($officeData),
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        return redirect()->route('admin.cms-section.contact-section')
            ->with('success', 'Contact section updated successfully.');
    }
}
