<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('category');
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->text('excerpt');
                $table->text('content');
                $table->string('author')->nullable();
                $table->string('author_title')->nullable();
                $table->date('publication_date')->nullable();
                $table->boolean('featured')->default(false);
                $table->string('read_time')->nullable();
                $table->string('image')->nullable();
                $table->json('gallery')->nullable();
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('is_published')->default(true);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};