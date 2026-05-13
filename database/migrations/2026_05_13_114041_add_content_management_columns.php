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
        Schema::table('content_management', function (Blueprint $table) {
            $table->string('section_name')->after('id');
            $table->string('section_item_name')->after('section_name');
            $table->text('section_content')->nullable()->after('section_item_name');
            $table->json('attributes')->nullable()->after('section_content');
            $table->json('media_files')->nullable()->after('attributes');

            // Add indexes for better performance
            $table->index(['section_name', 'section_item_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_management', function (Blueprint $table) {
            $table->dropIndex(['section_name', 'section_item_name']);
            $table->dropColumn(['section_name', 'section_item_name', 'section_content', 'attributes', 'media_files']);
        });
    }
};
