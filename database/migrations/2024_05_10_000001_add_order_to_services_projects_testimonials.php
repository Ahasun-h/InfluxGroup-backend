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
        // Add order column to services table
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'order')) {
                $table->integer('order')->default(0)->after('id');
            }
        });

        // Add order column to projects table
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'order')) {
                $table->integer('order')->default(0)->after('id');
            }
        });

        // Add order column to testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'order')) {
                $table->integer('order')->default(0)->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'order')) {
                $table->dropColumn('order');
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'order')) {
                $table->dropColumn('order');
            }
        });

        Schema::table('testimonials', function (Blueprint $table) {
            if (Schema::hasColumn('testimonials', 'order')) {
                $table->dropColumn('order');
            }
        });
    }
};
