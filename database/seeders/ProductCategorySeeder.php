<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'tagline' => 'Temukan berbagai produk elektronik terbaik',
                'description' => 'Kategori produk elektronik seperti smartphone, laptop, dan gadget lainnya.',
                'children' => [
                    [
                        'name' => 'Smartphone',
                        'tagline' => 'Smarthphone terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek smartphone terbaru dengan spesifikasi tinggi.',
                    ],
                    [
                        'name' => 'Laptop',
                        'tagline' => 'Laptop terbaru dengan performa tinggi',
                        'description' => 'Berbagai merek laptop terbaru dengan spesifikasi tinggi.',
                    ],
                    [
                        'name' => 'Aksesoris Gadget',
                        'tagline' => 'Aksesoris terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek aksesoris terbaru dengan spesifikasi tinggi.',
                    ],
                ],
            ],
            [
                'name' => 'Fashion',
                'tagline' => 'Temukan gaya fashion terbaik anda',
                'description' => 'Kategori fashion untuk pria dan wanita.',
                'children' => [
                    [
                        'name' => 'Pakaian Pria',
                        'tagline' => 'Pakaian terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek pakaian terbaru dengan spesifikasi tinggi.',
                    ],
                    [
                        'name' => 'Pakaian Wanita',
                        'tagline' => 'Pakaian terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek pakaian terbaru dengan spesifikasi tinggi.',
                    ],
                ],
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'tagline' => 'Temukan berbagai produk kesehatan dan kecantikan terbaik',
                'description' => 'Kategori produk kesehatan dan kecantikan seperti obat, kosmetik, dan peralatan.',
                'children' => [
                    [
                        'name' => 'Skin Care',
                        'tagline' => 'Skin care terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek skin care terbaru dengan spesifikasi tinggi.',
                    ],
                    [
                        'name' => 'Suplemen',
                        'tagline' => 'Suplemen terbaru dengan teknologi canggih',
                        'description' => 'Berbagai merek suplemen terbaru dengan spesifikasi tinggi.',
                    ],
                ],
            ],
        ];

        $imageHelper = new ImageHelper;

        foreach ($categories as $category) {
            $parent = ProductCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'tagline' => $category['tagline'],
                'description' => $category['description'],
                'image' => $imageHelper->storeAndResizeImage(
                    $imageHelper->createDummyImageWithTextSizeAndPosition(250, 250, 'center', 'center', 'random', 'medium'),
                    'product_category',
                    250,
                    250,
                ),
                'parent_id' => null,
            ]);

            foreach ($category['children'] as $child) {
                ProductCategory::create([
                    'name' => $child['name'],
                    'slug' => Str::slug($child['name']),
                    'tagline' => $child['tagline'],
                    'description' => $child['description'],
                    'image' => $imageHelper->storeAndResizeImage(
                        $imageHelper->createDummyImageWithTextSizeAndPosition(250, 250, 'center', 'center', 'random', 'medium'),
                        'product_category',
                        250,
                        250,
                    ),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
