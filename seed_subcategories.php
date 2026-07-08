<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Subcategory;

$categories = Category::all();

$data = [
    'Electronics' => ['Smartphones', 'Laptops', 'Headphones', 'Cameras', 'Smart Watches', 'Audio Systems'],
    'Fashion' => ['Men\'s Clothing', 'Women\'s Clothing', 'Shoes', 'Watches', 'Bags & Accessories'],
    'Home & Lifestyle' => ['Furniture', 'Kitchen Appliances', 'Home Decor', 'Bedding', 'Gardening'],
    'Automotive' => ['Car Accessories', 'Motorcycle Gear', 'Tools', 'Car Care', 'Lubricants'],
    'Sports & Outdoors' => ['Exercise equipment', 'Cycling', 'Outdoor Recreation', 'Sports Shoes', 'Swimwear']
];

foreach ($categories as $cat) {
    if (isset($data[$cat->name])) {
        foreach ($data[$cat->name] as $subName) {
            Subcategory::updateOrCreate([
                'category_id' => $cat->id,
                'name' => $subName
            ]);
        }
    }
}

echo "Subcategories seeded successfully!\n";
