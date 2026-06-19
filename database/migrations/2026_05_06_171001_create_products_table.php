<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('category'); // transformers, switchgear, renewables, automation
                $table->text('description');
                $table->text('overview')->nullable();
                $table->json('specifications')->nullable();
                $table->json('features')->nullable();
                $table->json('applications')->nullable();
                $table->string('image')->nullable();
                $table->json('gallery')->nullable();
                $table->string('brochure')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
