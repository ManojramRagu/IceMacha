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

        $allProducts = [
            // Hot Drinks
            ['name' => 'Americano', 'price' => 400.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/americano.webp', 'desc' => 'Bold black coffee, smooth and strong.'],
            ['name' => 'Cafe Latte', 'price' => 450.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/cafe-latte.webp', 'desc' => 'Espresso with silky steamed milk.'],
            ['name' => 'Cappuccino', 'price' => 500.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/cappuccino.webp', 'desc' => 'Espresso, milk, and foam in balance.'],
            ['name' => 'Espresso', 'price' => 350.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/espresso.webp', 'desc' => 'Intense single-shot coffee.'],
            ['name' => 'Green Tea', 'price' => 300.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/green-tea.webp', 'desc' => 'Light, calming brew.'],
            ['name' => 'Hot Cocoa', 'price' => 450.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/hot-cocoa.webp', 'desc' => 'Rich chocolate comfort.'],
            ['name' => 'Masala Chai', 'price' => 380.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/masala-chai.webp', 'desc' => 'Spiced black tea.'],
            
            // Cold Drinks
            ['name' => 'Chilled Coffee', 'price' => 500.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/chilled-coffee.webp', 'desc' => 'Smooth, creamy iced coffee.'],
            ['name' => 'Chocolate Frappe', 'price' => 650.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/chocolate-frappe.webp', 'desc' => 'Blended frosty chocolate.'],
            ['name' => 'Iced Americano', 'price' => 450.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/iced-americano.webp', 'desc' => 'Bold coffee on ice.'],
            ['name' => 'Lime Juice', 'price' => 300.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/lime-juice.webp', 'desc' => 'Fresh and zesty.'],
            ['name' => 'Mango Smoothie', 'price' => 700.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/mango-smoothie.webp', 'desc' => 'Tropical mango blend.'],
            ['name' => 'Peach Iced Tea', 'price' => 450.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/peach-iced-tea.webp', 'desc' => 'Sweet peach chilled tea.'],
            ['name' => 'Strawberry Milkshake', 'price' => 700.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/strawberry-milkshake.webp', 'desc' => 'Creamy real strawberries.'],
            
            // Breakfast
            ['name' => 'Avocado Toast', 'price' => 550.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/avocado-toast.webp', 'desc' => 'Fresh avocado on toast.'],
            ['name' => 'Chicken Cheese Delight', 'price' => 750.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/chicken-cheese-delight.webp', 'desc' => 'Grilled chicken and melted cheese.'],
            ['name' => 'Chocolate Waffles', 'price' => 700.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/chocolate-waffles-delight.webp', 'desc' => 'Waffles with chocolate syrup.'],
            ['name' => 'Classic English Breakfast', 'price' => 950.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/classic-english-breakfast.webp', 'desc' => 'The full classic spread.'],
            ['name' => 'Eggs on Toast', 'price' => 500.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/eggs-on-toast.webp', 'desc' => 'Scrambled eggs on toast.'],
            
            // Lunch & Dinner Highlights
            ['name' => 'Fish Curry', 'price' => 850.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/fish-curry.webp', 'desc' => 'Spicy Sri Lankan style.'],
            ['name' => 'Chicken Fried Rice', 'price' => 750.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/chicken-fried-rice.webp', 'desc' => 'Classic fried rice.'],
            ['name' => 'Chicken Kottu', 'price' => 900.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/chicken-kottu.webp', 'desc' => 'Spicy kottu roti.'],
            ['name' => 'BBQ Chicken Pizza', 'price' => 1200.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/bbq-chicken-pizza.webp', 'desc' => 'Pizza with BBQ chicken.'],
            
            // Snacks & Desserts
            ['name' => 'Chicken Nuggets', 'price' => 550.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/chicken-nuggets.webp', 'desc' => 'Crispy golden nuggets.'],
            ['name' => 'Tiramisu', 'price' => 900.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/tiramisu.webp', 'desc' => 'Classic coffee dessert.'],
        ];

        foreach ($allProducts as $p) {
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