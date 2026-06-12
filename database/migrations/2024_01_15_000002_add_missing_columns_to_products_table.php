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
        Schema::table('products', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('products', 'order')) {
                $table->integer('order')->default(0)->after('brochure');
            }

            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order');
            }

            if (!Schema::hasColumn('products', 'overview')) {
                $table->text('overview')->nullable()->after('description');
            }

            if (!Schema::hasColumn('products', 'applications')) {
                $table->json('applications')->nullable()->after('features');
            }

            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('product_categories')->nullOnDelete();
            }

            // Make sure gallery column exists
            if (!Schema::hasColumn('products', 'gallery')) {
                $table->json('gallery')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('products', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('products', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('products', 'overview')) {
                $table->dropColumn('overview');
            }
            if (Schema::hasColumn('products', 'applications')) {
                $table->dropColumn('applications');
            }
            if (Schema::hasColumn('products', 'gallery')) {
                $table->dropColumn('gallery');
            }
        });
    }
};