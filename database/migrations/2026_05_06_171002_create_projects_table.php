<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('location')->nullable();
                $table->string('capacity')->nullable();
                $table->string('type')->nullable();
                $table->string('category'); // power, transmission, renewable, industrial
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('status'); // ongoing, completed, planned
                $table->string('completion')->nullable(); // percentage
                $table->string('client')->nullable();
                $table->decimal('value', 15, 2)->nullable();
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
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
