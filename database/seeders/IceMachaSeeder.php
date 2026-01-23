<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class IceMachaSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Hot Drinks' => 'Bold and comforting hot beverages.',
            'Cold Drinks' => 'Refreshing chilled drinks and frappes.',
            'Breakfast' => 'Start your day with wholesome meals.',
            'Lunch' => 'Spicy and savory midday delights.',
            'Dinner' => 'Satisfying evening meals.',
            'Snacks' => 'Crispy and crunchy bite-sized favorites.',
            'Desserts' => 'Sweet treats to end your meal.',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $desc) {
            $categoryModels[$name] = Category::create(['name' => $name, 'description' => $desc]);
        }

        $products = [
            // Hot Drinks
            ['name' => 'Americano', 'price' => 400.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/americano.webp', 'desc' => 'Bold black coffee, smooth and strong.'],
            ['name' => 'Cafe Latte', 'price' => 450.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/cafe-latte.webp', 'desc' => 'Espresso with silky steamed milk.'],
            ['name' => 'Cappuccino', 'price' => 500.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/cappuccino.webp', 'desc' => 'Espresso, milk, and foam in balance.'],
            // Cold Drinks
            ['name' => 'Chilled Coffee', 'price' => 500.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/chilled-coffee.webp', 'desc' => 'Iced coffee with a smooth, creamy finish.'],
            ['name' => 'Mango Smoothie', 'price' => 700.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/mango-smoothie.webp', 'desc' => 'Thick tropical blend with ripe mango.'],
            // Breakfast
            ['name' => 'Avocado Toast', 'price' => 550.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/avocado-toast.webp', 'desc' => 'Toasted bread topped with fresh avocado.'],
            // Lunch
            ['name' => 'Fish Curry', 'price' => 850.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/fish-curry.webp', 'desc' => 'Spicy Sri Lankan-style fish curry.'],
            // Dinner
            ['name' => 'Chicken Kottu', 'price' => 900.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/chicken-kottu.webp', 'desc' => 'Sri Lankan kottu roti with chicken and spices.'],
            // Snacks
            ['name' => 'Chicken Nuggets', 'price' => 550.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/chicken-nuggets.webp', 'desc' => 'Crispy golden chicken nuggets.'],
            // Desserts
            ['name' => 'Tiramisu', 'price' => 900.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/tiramisu.webp', 'desc' => 'Classic Italian dessert with coffee and cream.'],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'description' => $p['desc'],
                'price' => $p['price'],
                'stock_quantity' => 50,
                'category_id' => $categoryModels[$p['cat']]->id,
                'image_path' => $p['img'],
            ]);
        }
    }
}