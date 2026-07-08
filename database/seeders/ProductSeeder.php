<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $data = [
            'Electronics' => [
                'brands' => ['Apple', 'Samsung', 'Sony', 'Xiaomi', 'Dell', 'HP', 'Logitech'],
                'items' => ['iPhone 15 Pro', 'Galaxy S24 Ultra', 'WH-1000XM5 Headphones', 'Redmi Note 13', 'XPS 15 Laptop', 'Pavilion Gaming', 'MX Master 3S Mouse', 'Smart TV 4K', 'AirPods Pro']
            ],
            'Fashion' => [
                'brands' => ['Nike', 'Adidas', 'Gucci', 'Zara', 'Puma', 'Levi\'s', 'H&M'],
                'items' => ['Air Max Sneakers', 'Ultraboost 22', 'Luxury Leather Bag', 'Summer Floral Dress', 'Men\'s Denim Jacket', 'Cotton T-Shirt', 'Running Shorts', 'Formal Suit']
            ],
            'Home & Lifestyle' => [
                'brands' => ['IKEA', 'Philips', 'Dyson', 'Tupperware', 'Bosch'],
                'items' => ['Ergonomic Chair', 'LED Smart Bulb', 'V15 Cordless Vacuum', 'Storage Container Set', 'Electric Kettle', 'Coffee Maker', 'Sofa Bed']
            ],
            'Automotive' => [
                'brands' => ['Michelin', 'Castrol', '3M', 'Kenwood', 'Brembo'],
                'items' => ['Performance Tires', 'Synthetic Engine Oil', 'Car Wax Polish', 'Android Car Stereo', 'Brake Pad Kit']
            ],
            'Sports & Outdoors' => [
                'brands' => ['Wilson', 'Decathlon', 'Shimano', 'Yonex', 'Coleman'],
                'items' => ['Tennis Racket', 'Mountain Bike', 'Camping Tent', 'Yoga Mat', 'Badminton Set', 'Football Size 5']
            ]
        ];

        $categories = [];
        foreach(array_keys($data) as $catName) {
            $categories[$catName] = \App\Models\Category::create([
                'name' => $catName,
                'slug' => \Illuminate\Support\Str::slug($catName),
                'company_id' => rand(1, 2)
            ])->id;
        }

        // Pre-fetch some base64 images to reuse (to speed up seeding)
        $imageBase64Pool = [];
        $keywords = ['tech', 'clothes', 'furniture', 'car', 'sports'];
        foreach($keywords as $key) {
            $url = "https://loremflickr.com/320/320/$key?lock=" . rand(1, 100);
            $imgData = @file_get_contents($url);
            if($imgData) {
                $imageBase64Pool[] = 'data:image/jpeg;base64,' . base64_encode($imgData);
            }
        }
        
        // Final fallback if fetch failed
        if(empty($imageBase64Pool)) {
             $imageBase64Pool[] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
        }

        $products = [];
        $totalProducts = 500;
        
        for ($i = 1; $i <= $totalProducts; $i++) {
            $catKey = array_rand($data);
            $catInfo = $data[$catKey];
            $brand = $catInfo['brands'][array_rand($catInfo['brands'])];
            $item = $catInfo['items'][array_rand($catInfo['items'])];
            $productName = "$brand $item " . ($i % 10 == 0 ? "Special Edition" : "");

            $products[] = [
                'company_id' => rand(1, 2),
                'category_id' => $categories[$catKey],
                'name' => $productName,
                'price' => rand(50, 2000) - 0.01,
                'stock' => rand(5, 500),
                'description' => "$productName is a premium quality product from $brand. " . $faker->paragraph,
                'image' => $imageBase64Pool[array_rand($imageBase64Pool)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            if ($i % 10 === 0) {
                \App\Models\Product::insert($products);
                $products = [];
            }
        }
        
        if (count($products) > 0) {
            \App\Models\Product::insert($products);
        }
    }
}
