<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // transformers, switchgear, renewables, automation
            $table->text('description');
            $table->json('specifications')->nullable();
            $table->json('features')->nullable();
            $table->string('image')->nullable();
            $table->string('brochure')->nullable();
            $table->timestamps();
        });

        // Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location')->nullable();
            $table->string('capacity')->nullable();
            $table->string('type')->nullable();
            $table->string('category'); // power, transmission, renewable, industrial
            $table->string('status'); // ongoing, completed, planned
            $table->string('completion')->nullable(); // percentage
            $table->string('client')->nullable();
            $table->string('value')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expected_completion')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->json('scope')->nullable();
            $table->json('highlights')->nullable();
            $table->json('stats')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        // Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->json('features')->nullable();
            $table->json('process')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Solutions
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->json('features')->nullable();
            $table->json('applications')->nullable();
            $table->string('image')->nullable();
            $table->string('case_study')->nullable();
            $table->timestamps();
        });

        // News
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->string('author_photo')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('read_time')->nullable();
            $table->boolean('featured')->default(false);
            $table->json('tags')->nullable();
            $table->timestamps();
        });

        // Gallery
        Schema::create('gallery', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['photo', 'video'])->default('photo');
            $table->string('title');
            $table->string('category');
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->text('caption')->nullable();
            $table->string('alt')->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('date')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('company')->nullable();
            $table->string('company_logo')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->string('project_name')->nullable();
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->date('date')->nullable();
            $table->timestamps();
        });

        // Partners
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('type'); // government, international, regulator, standards, technology
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('partnership_type')->nullable(); // Client, Partner, Regulator, Standards
            $table->string('since')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Job Openings
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('location');
            $table->string('type'); // Full-time, Part-time, Contract
            $table->string('experience')->nullable();
            $table->text('description');
            $table->json('responsibilities')->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->string('salary')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->string('status')->default('active'); // active, closed
            $table->dateTime('posted_date')->nullable();
            $table->timestamps();
        });

        // Company Info / Settings (Single Record Store)
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
        Schema::dropIfExists('job_openings');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('news');
        Schema::dropIfExists('solutions');
        Schema::dropIfExists('services');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('products');
    }
};
