<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->words(rand(2, 4), true);
        
        // Pick an existing category or use 1 if none
        $category = Category::inRandomOrder()->first();
        $categoryId = $category ? $category->id : 1;
        
        // Pick subcategory for that category
        $subcategory = Subcategory::where('category_id', $categoryId)->inRandomOrder()->first();
        $subcategoryId = $subcategory ? $subcategory->id : null;
        
        // Pick any brand
        $brand = Brand::inRandomOrder()->first();
        $brandId = $brand ? $brand->id : null;

        return [
            'category_id'       => $categoryId,
            'subcategory_id'    => $subcategoryId,
            'brand_id'          => $brandId,
            'product_title'     => ucwords($title),
            'sub_title'         => $this->faker->sentence(),
            'slug'              => Str::slug($title) . '-' . rand(100, 999),
            'description'       => $this->faker->paragraphs(3, true),
            'status'            => 1,
            'position'          => rand(1, 100),
            'created_at'        => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at'        => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Product $product) {
            // Give every product at least one image
            ProductImage::create([
                'product_id' => $product->id,
                'image'      => 'assets/images/products/' . rand(1, 4) . '.png', // fallback or existing placeholders
            ]);
        });
    }
}
