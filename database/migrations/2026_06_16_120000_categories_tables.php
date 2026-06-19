<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            // Create unified categories table
            Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('icon')->nullable(); // TEXT type for storing full SVG icons
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('service_area'); // 'product' or 'project'
            $table->timestamps();
            });
        }
    }
};
