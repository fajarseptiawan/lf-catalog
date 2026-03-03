<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 13 Pro Max',
                'slug' => 'iphone-13-pro-max',
                'category' => 'iphone13',
                'price' => 12000000,
                'stock' => 10,
                'description' => 'The ultimate iPhone 13.',
                'features' => ['A15 Bionic', 'ProMotion', 'Long battery life'],
                'image' => 'img/tes1.png',
                'is_featured' => true,
            ],
            [
                'name' => 'iPhone 14 Pro',
                'slug' => 'iphone-14-pro',
                'category' => 'iphone14',
                'price' => 14000000,
                'stock' => 5,
                'description' => 'A magical new way to interact with iPhone.',
                'features' => ['Dynamic Island', 'Always-On display', '48MP Main camera'],
                'image' => 'img/tes1.png',
                'is_featured' => true,
            ],
            [
                'name' => 'iPhone 15',
                'slug' => 'iphone-15',
                'category' => 'iphone15',
                'price' => 15000000,
                'stock' => 8,
                'description' => 'New camera. New design. New possibilities.',
                'features' => ['USB-C', 'Dynamic Island', '48MP Main camera'],
                'image' => 'img/tes1.png',
                'is_featured' => true,
            ],
            [
                'name' => 'Softlens Blue Ray',
                'slug' => 'softlens-blue-ray',
                'category' => 'softlens',
                'price' => 150000,
                'stock' => 50,
                'description' => 'Comfortable softlens with blue ray protection.',
                'features' => ['Comfortable', 'Blue Ray Protection', '1 Year use'],
                'image' => 'img/tes.png',
                'is_featured' => false,
            ],
            [
                'name' => 'G2G Moisturizer',
                'slug' => 'g2g-moisturizer',
                'category' => 'g2g',
                'price' => 85000,
                'stock' => 100,
                'description' => 'Glow to Go moisturizer for all skin types.',
                'features' => ['Hyaluronic Acid', 'SPF 30', 'Non-greasy'],
                'image' => 'img/tes.png',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
