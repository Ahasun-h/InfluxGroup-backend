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
        Schema::create('career_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->default('Full-time'); // Full-time, Part-time, Contract, Internship
            $table->string('posted_date')->nullable()->default('Recently posted');
            $table->date('expiry_date')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable();
            $table->text('description')->nullable();
            $table->json('requirements')->nullable(); // Array of requirements
            $table->json('responsibilities')->nullable(); // Array of responsibilities
            $table->json('benefits')->nullable(); // Array of benefits
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_opportunities');
    }
};
