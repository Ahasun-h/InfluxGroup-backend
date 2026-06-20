<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('services_and_solutions')) {
            Schema::create('services_and_solutions', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->text('overview')->nullable();
                $table->string('icon')->nullable();

                // Type to distinguish between service and solution
                $table->enum('type', ['service', 'solution'])->default('service');

                // Service-specific fields
                $table->json('features')->nullable();
                $table->json('process')->nullable();
                $table->string('duration')->nullable();
                $table->string('availability')->nullable();

                // Solution-specific fields
                $table->json('components')->nullable();
                $table->json('applications')->nullable();
                $table->json('benefits')->nullable();
                $table->json('industries')->nullable();
                $table->json('stats')->nullable();

                // Category support
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('category')->nullable(); // Display name for badges

                // Media
                $table->string('image')->nullable();
                $table->json('gallery')->nullable();

                // Settings
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('services_and_solutions');
    }
};