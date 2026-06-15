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
        Schema::table('project_categories', function (Blueprint $table) {
            // Change icon column from text to LONGTEXT to support large SVG strings
            $table->longText('icon')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_categories', function (Blueprint $table) {
            // Revert back to text type
            $table->text('icon')->nullable()->change();
        });
    }
};
