<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing table if it exists
        Schema::dropIfExists('hero_sections');

        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();

            // Main Hero Content
            $table->string('badge')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // CTA Buttons - stored as JSON for flexibility
            $table->json('cta_buttons')->nullable();

            // Background Image
            $table->string('background_image')->nullable();

            // Categories - stored as JSON for dynamic, WordPress-style management
            // Format: [{"title":"Transformers","subtitle":"45+ Models","icon":"<svg>...</svg>","link":"/products","order":1}]
            $table->json('categories')->nullable();

            // Brand Statement Fields (added for CMS functionality)
            $table->json('stats')->nullable()->comment('Brand statement statistics');
            $table->string('image_url')->nullable()->comment('Brand statement image URL');
            $table->string('overlay_title')->nullable()->comment('Brand statement overlay title');
            $table->string('overlay_text')->nullable()->comment('Brand statement overlay text');

            // Metadata
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for better performance
            $table->index('is_active');
        });

        // Insert default hero section data
        DB::table('hero_sections')->insert([
            'badge' => 'Leaders in Energy & Infrastructure',
            'title' => 'POWERING BANGLADESH SINCE 1980',
            'description' => 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
            'cta_buttons' => json_encode([
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
            ]),
            'background_image' => '/hero.png',
            'categories' => json_encode([
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
            ]),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
