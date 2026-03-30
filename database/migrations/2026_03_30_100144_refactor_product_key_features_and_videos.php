<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add key_features to products table
        if (!Schema::hasColumn('products', 'key_features')) {
            Schema::table('products', function (Blueprint $table) {
                $table->longText('key_features')->nullable()->after('description');
            });
        }

        // 2. Migrate existing key features data to the new products.key_features column
        if (Schema::hasTable('product_key_features')) {
            $products = DB::table('products')->get();
            foreach ($products as $product) {
                $features = DB::table('product_key_features')
                    ->where('product_id', $product->id)
                    ->orderBy('position')
                    ->get();
                
                if ($features->isNotEmpty()) {
                    $html = '<ul>';
                    foreach ($features as $feature) {
                        $html .= '<li><strong>' . e($feature->name) . '</strong>: ' . e($feature->description) . '</li>';
                    }
                    $html .= '</ul>';
                    
                    DB::table('products')->where('id', $product->id)->update(['key_features' => $html]);
                }
            }
            
            // 3. Rename product_key_features to product_othervideos and modify columns
            Schema::rename('product_key_features', 'product_othervideos');
            
            Schema::table('product_othervideos', function (Blueprint $table) {
                // Drop old columns
                $table->dropColumn(['name', 'description', 'position', 'status', 'deleted_at']);
                // Add new columns
                $table->string('video_url')->nullable()->after('product_id');
            });
        } else {
            // Create if it doesn't exist
            Schema::create('product_othervideos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('video_url')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Rename othervideos back to key_features
        if (Schema::hasTable('product_othervideos')) {
            Schema::table('product_othervideos', function (Blueprint $table) {
                $table->dropColumn('video_url');
                $table->string('name')->after('product_id');
                $table->text('description')->nullable()->after('name');
                $table->integer('position')->default(1)->after('description');
                $table->boolean('status')->default(1)->after('position');
                $table->softDeletes()->after('status');
            });
            Schema::rename('product_othervideos', 'product_key_features');
        }

        // 2. Remove key_features from products table
        if (Schema::hasColumn('products', 'key_features')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('key_features');
            });
        }
    }
};
