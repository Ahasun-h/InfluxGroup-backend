<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BrandStatementController extends Controller
{
    /**
     * Display the brand statement management page
     */
    public function index(): View
    {
        // Get or create brand statement items
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_title'
            ],
            [
                'section_content' => 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_description'
            ],
            [
                'section_content' => 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $image = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_image'
            ],
            [
                'section_content' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $overlayTitle = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_title'
            ],
            [
                'section_content' => 'Core Reliability',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $overlayText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_text'
            ],
            [
                'section_content' => 'Zero Downtime Operation Protocols',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Create stats items
        $stat1 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat1'
            ],
            [
                'section_content' => json_encode(['value' => '45+', 'label' => 'Years Experience', 'order' => 1]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat2 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat2'
            ],
            [
                'section_content' => json_encode(['value' => '15GW', 'label' => 'Power Generated', 'order' => 2]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat3 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat3'
            ],
            [
                'section_content' => json_encode(['value' => '250+', 'label' => 'Global Clients', 'order' => 3]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        $stat4 = ContentManagement::firstOrCreate(
            [
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_stat4'
            ],
            [
                'section_content' => json_encode(['value' => '500+', 'label' => 'Technical Staff', 'order' => 4]),
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Get all brand statement items for the view
        $brandItems = ContentManagement::where('section_name', 'brand_statements_section')
            ->get()
            ->keyBy('section_item_name');

        return view('admin.cms-section.brand-statements', compact('brandItems'));
    }

    /**
     * Update the brand statement
     */
    public function update(Request $request): RedirectResponse
    {
        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle description update
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle image URL update or file upload
        if ($request->has('image_url')) {
            $imageUrl = $request->image_url;

            // Check if it's a base64 data URL (file upload)
            if (preg_match('/^data:image\/(\w+);base64,/i', $imageUrl)) {
                try {
                    // Extract the image data
                    preg_match('/^data:image\/(\w+);base64,(.+)/i', $imageUrl, $matches);
                    $extension = strtolower($matches[1]);
                    $base64Data = $matches[2];

                    // Validate extension
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                    if (!in_array($extension, $allowedExtensions)) {
                        throw new \Exception("Invalid image format: {$extension}");
                    }

                    // Decode base64 data
                    $imageData = base64_decode($base64Data);

                    if ($imageData === false) {
                        throw new \Exception("Failed to decode image data");
                    }

                    // Validate file size (max 5MB)
                    if (strlen($imageData) > 5 * 1024 * 1024) {
                        throw new \Exception("Image file too large. Maximum size is 5MB.");
                    }

                    // Validate image dimensions (optional)
                    $imageInfo = getimagesizefromstring($imageData);
                    if ($imageInfo === false) {
                        throw new \Exception("Invalid image data");
                    }

                    $maxWidth = 4000;
                    $maxHeight = 4000;
                    if ($imageInfo[0] > $maxWidth || $imageInfo[1] > $maxHeight) {
                        throw new \Exception("Image dimensions too large. Maximum size is {$maxWidth}x{$maxHeight}px.");
                    }

                    // Create directory if it doesn't exist
                    $directory = public_path('uploads/brand-statements');
                    if (!File::exists($directory)) {
                        File::makeDirectory($directory, 0755, true, true);
                    }

                    // Generate unique filename
                    $filename = 'brand-statements-' . time() . '-' . uniqid() . '.' . $extension;
                    $filepath = $directory . '/' . $filename;

                    // Save the file
                    File::put($filepath, $imageData);

                    // Store the public URL in database
                    $imageUrl = '/uploads/brand-statements/' . $filename;

                    \Log::info("Image saved successfully: {$filepath}");
                } catch (\Exception $e) {
                    \Log::error("Failed to process image upload: " . $e->getMessage());
                    return redirect()->back()
                        ->with('error', "Failed to process image: {$e->getMessage()}");
                }
            }

            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_image'
                ],
                [
                    'section_content' => $imageUrl,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay title update
        if ($request->has('overlay_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_title'
                ],
                [
                    'section_content' => $request->overlay_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay text update
        if ($request->has('overlay_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_text'
                ],
                [
                    'section_content' => $request->overlay_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle stats updates - support both old format (stat1_value) and new format (stats[1][value])
        if ($request->has('stats')) {
            // New format from edit page: stats[1][value], stats[1][label]
            foreach ($request->input('stats') as $index => $statData) {
                $statValue = $statData['value'] ?? null;
                $statLabel = $statData['label'] ?? null;
                $statOrder = $statData['order'] ?? $index;

                if ($statValue || $statLabel) {
                    $data = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $statOrder
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$index}"
                        ],
                        [
                            'section_content' => json_encode($data),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        } else {
            // Old format from index page: stat1_value, stat1_label
            for ($i = 1; $i <= 4; $i++) {
                $statValue = $request->input("stat{$i}_value");
                $statLabel = $request->input("stat{$i}_label");

                if ($statValue || $statLabel) {
                    $statData = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $i
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$i}"
                        ],
                        [
                            'section_content' => json_encode($statData),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.cms-section.brand-statements')
            ->with('success', 'Brand statement updated successfully.');
    }
}
