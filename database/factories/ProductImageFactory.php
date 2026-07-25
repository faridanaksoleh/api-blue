<?php

namespace Database\Factories;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // <-- Wajib di-import untuk generate UUID

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageHelper = new ImageHelper;
        
        return [
            'id' => (string) Str::uuid(), // <-- Paksa suntik UUID manual biar 100% aman
            'product_id' => Product::factory(),
            'image' => $imageHelper->storeAndResizeImage(
                $imageHelper->createDummyImageWithTextSizeAndPosition(800, 800, 'center', 'center', 'random', 'large'),
                'products',
                800,
                800,
            ),
            'is_thumbnail' => false,
        ];
    }

    // ==================================================
    // INI FUNGSI YANG BIKIN ERROR SEBELUMNYA HILANG
    // ==================================================
    public function thumbnail()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_thumbnail' => true,
            ];
        });
    }
}