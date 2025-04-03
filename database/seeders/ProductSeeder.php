<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Electronics category
        Product::create([
            'name' => 'Smartphone',
            'price' => 699.99,
            'description' => 'Latest smartphone with high-end features and 5G connectivity.',
            'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);
        
        Product::create([
            'name' => 'Laptop',
            'price' => 1299.99,
            'description' => 'Powerful laptop for work and gaming with dedicated graphics card.',
            'image' => 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);
        
        Product::create([
            'name' => 'Wireless Headphones',
            'price' => 199.99,
            'description' => 'Noise-cancelling wireless headphones with long battery life.',
            'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);
        
        Product::create([
            'name' => 'Smart Watch',
            'price' => 349.99,
            'description' => 'Fitness tracker with heart rate monitor and GPS.',
            'image' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);
        
        Product::create([
            'name' => 'Bluetooth Speaker',
            'price' => 129.99,
            'description' => 'Waterproof speaker with 360° sound and 20-hour battery life.',
            'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);
        
        Product::create([
            'name' => 'Tablet',
            'price' => 499.99,
            'description' => 'Lightweight tablet with high-resolution display and stylus support.',
            'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'electronics'
        ]);

        // Fashion category
        Product::create([
            'name' => 'Watch',
            'price' => 250,
            'description' => 'Elegant wristwatch with leather strap and stainless steel case.',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=989&q=80',
            'category' => 'fashion'
        ]);
        
        Product::create([
            'name' => 'Bag',
            'price' => 350,
            'description' => 'Premium leather bag with multiple compartments and adjustable strap.',
            'image' => 'https://images.unsplash.com/photo-1491637639811-60e2756cc1c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=669&q=80',
            'category' => 'fashion'
        ]);
        
        Product::create([
            'name' => 'Sunglasses',
            'price' => 120,
            'description' => 'Stylish sunglasses with UV protection and polarized lenses.',
            'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'fashion'
        ]);
        
        Product::create([
            'name' => 'Leather Wallet',
            'price' => 79.99,
            'description' => 'Handcrafted leather wallet with RFID protection and multiple card slots.',
            'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'fashion'
        ]);
        
        Product::create([
            'name' => 'Sneakers',
            'price' => 149.99,
            'description' => 'Comfortable athletic shoes with breathable mesh and cushioned insoles.',
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'fashion'
        ]);
        
        Product::create([
            'name' => 'Scarf',
            'price' => 59.99,
            'description' => 'Soft cashmere scarf in a versatile neutral color.',
            'image' => 'https://images.unsplash.com/photo-1609803384069-19f3e5a70e75?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'category' => 'fashion'
        ]);

        // Beauty category
        Product::create([
            'name' => 'Perfume',
            'price' => 100,
            'description' => 'Luxury fragrance with long-lasting scent for any occasion.',
            'image' => 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=1868&q=80',
            'category' => 'beauty'
        ]);
        
        Product::create([
            'name' => 'Skincare Set',
            'price' => 89.99,
            'description' => 'Complete skincare set with cleanser, toner, and moisturizer.',
            'image' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'beauty'
        ]);
        
        Product::create([
            'name' => 'Makeup Palette',
            'price' => 65.99,
            'description' => 'Versatile eyeshadow palette with matte and shimmer finishes.',
            'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'beauty'
        ]);
        
        Product::create([
            'name' => 'Hair Styling Tools',
            'price' => 159.99,
            'description' => 'Professional-grade hair dryer with multiple attachments and ionic technology.',
            'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'beauty'
        ]);

        // Home category
        Product::create([
            'name' => 'Coffee Maker',
            'price' => 149.99,
            'description' => 'Smart coffee maker with programmable settings and thermal carafe.',
            'image' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'home'
        ]);
        
        Product::create([
            'name' => 'Desk Lamp',
            'price' => 79.99,
            'description' => 'Adjustable desk lamp with multiple brightness levels and USB charging port.',
            'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'home'
        ]);
        
        Product::create([
            'name' => 'Throw Blanket',
            'price' => 69.99,
            'description' => 'Soft and warm throw blanket made of premium materials.',
            'image' => 'https://images.unsplash.com/photo-1503602642458-232111445657?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'home'
        ]);
        
        Product::create([
            'name' => 'Plant Pot',
            'price' => 34.99,
            'description' => 'Ceramic plant pot with drainage hole and minimalist design.',
            'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'home'
        ]);
        
        // Sports category
        Product::create([
            'name' => 'Yoga Mat',
            'price' => 45.99,
            'description' => 'Non-slip yoga mat with carrying strap and eco-friendly materials.',
            'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'sports'
        ]);
        
        Product::create([
            'name' => 'Water Bottle',
            'price' => 29.99,
            'description' => 'Insulated stainless steel water bottle that keeps drinks cold for 24 hours.',
            'image' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'sports'
        ]);
        
        Product::create([
            'name' => 'Fitness Tracker',
            'price' => 129.99,
            'description' => 'Waterproof fitness tracker with heart rate monitor and sleep tracking.',
            'image' => 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'sports'
        ]);
        
        Product::create([
            'name' => 'Dumbbell Set',
            'price' => 199.99,
            'description' => 'Adjustable dumbbell set with stand for home workouts.',
            'image' => 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80',
            'category' => 'sports'
        ]);
    }
}
