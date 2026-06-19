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
        // Fix double-encoded JSON fields in products table
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $updates = [];

            // Fix specifications field
            if (!empty($product->specifications)) {
                $specifications = $product->specifications;
                // If it's already JSON, decode and re-encode to fix double-encoding
                if (is_string($specifications)) {
                    $decoded = json_decode($specifications, true);
                    if (is_array($decoded)) {
                        $updates['specifications'] = json_encode($decoded);
                    }
                }
            }

            // Fix features field
            if (!empty($product->features)) {
                $features = $product->features;
                if (is_string($features)) {
                    $decoded = json_decode($features, true);
                    if (is_array($decoded)) {
                        $updates['features'] = json_encode($decoded);
                    }
                }
            }

            // Fix applications field
            if (!empty($product->applications)) {
                $applications = $product->applications;
                if (is_string($applications)) {
                    $decoded = json_decode($applications, true);
                    if (is_array($decoded)) {
                        $updates['applications'] = json_encode($decoded);
                    }
                }
            }

            // Fix gallery field
            if (!empty($product->gallery)) {
                $gallery = $product->gallery;
                if (is_string($gallery)) {
                    $decoded = json_decode($gallery, true);
                    if (is_array($decoded)) {
                        $updates['gallery'] = json_encode($decoded);
                    }
                }
            }

            // Update the product if there are fixes
            if (!empty($updates)) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed as this just fixes data format
    }
};
