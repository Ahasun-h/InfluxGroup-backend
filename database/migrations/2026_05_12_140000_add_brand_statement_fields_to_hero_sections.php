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
        Schema::table('hero_sections', function (Blueprint $table) {
            // Add brand statement columns if they don't exist
            if (!Schema::hasColumn('hero_sections', 'stats')) {
                $table->json('stats')->nullable()->comment('Brand statement statistics');
            }
            if (!Schema::hasColumn('hero_sections', 'image_url')) {
                $table->string('image_url')->nullable()->comment('Brand statement image URL');
            }
            if (!Schema::hasColumn('hero_sections', 'overlay_title')) {
                $table->string('overlay_title')->nullable()->comment('Brand statement overlay title');
            }
            if (!Schema::hasColumn('hero_sections', 'overlay_text')) {
                $table->string('overlay_text')->nullable()->comment('Brand statement overlay text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            if (Schema::hasColumn('hero_sections', 'stats')) {
                $table->dropColumn('stats');
            }
            if (Schema::hasColumn('hero_sections', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('hero_sections', 'overlay_title')) {
                $table->dropColumn('overlay_title');
            }
            if (Schema::hasColumn('hero_sections', 'overlay_text')) {
                $table->dropColumn('overlay_text');
            }
        });
    }
};
