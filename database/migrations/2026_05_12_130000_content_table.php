<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the Content_management_table (site_sections) table
        Schema::create('Content_management_table', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique()->comment('Unique identifier for the section, e.g., hero_section');
            $table->string('title')->nullable();
            $table->string('type')->default('section')->comment('Type of content: section, page, block, etc.');
            $table->string('status')->default('publish');
            $table->integer('order')->default(0);
            $table->json('content_data')->nullable()->comment('JSON data storing actual section content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Content_management_table');
    }
};
