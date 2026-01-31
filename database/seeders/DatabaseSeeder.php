<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding Categories...');
        // 1. Seed Categories
        $categories = [
            ['name' => 'Hot Drinks', 'description' => 'Bold and comforting hot beverages.'],
            ['name' => 'Cold Drinks', 'description' => 'Refreshing chilled drinks and frappes.'],
            ['name' => 'Breakfast', 'description' => 'Start your day with wholesome meals.'],
            ['name' => 'Lunch', 'description' => 'Spicy and savory midday delights.'],
            ['name' => 'Dinner', 'description' => 'Satisfying evening meals.'],
            ['name' => 'Snacks', 'description' => 'Crispy and crunchy bite-sized favorites.'],
            ['name' => 'Desserts', 'description' => 'Sweet treats to end your meal.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
        $this->command->info('Categories Seeded.');

        // Set parent relationships for subcategories
        $this->command->info('Setting category parent relationships...');
        Category::whereIn('name', ['Hot Drinks', 'Cold Drinks'])->update(['parent' => 'Beverages']);
        Category::whereIn('name', ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Desserts'])->update(['parent' => 'Food']);
        $this->command->info('Category parent relationships set.');

        $this->command->info('Seeding Products...');
        // 2. Seed Products (Correctly mapped to IDs 1-49 from SQL dump)
        $products = [
            // Hot Drinks
            ['name' => 'Americano', 'price' => 400.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Americano.webp', 'description' => 'Bold black coffee, smooth and strong.'],
            ['name' => 'Cafe Latte', 'price' => 450.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Cafe-Latte.webp', 'description' => 'Espresso with silky steamed milk.'],
            ['name' => 'Cappuccino', 'price' => 500.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Cappuccino.webp', 'description' => 'Espresso, milk, and foam in balance.'],
            ['name' => 'Espresso', 'price' => 350.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Espresso.webp', 'description' => 'Intense single-shot coffee.'],
            ['name' => 'Green Tea', 'price' => 300.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Green-Tea.webp', 'description' => 'Light, calming and refreshing brew.'],
            ['name' => 'Hot Cocoa', 'price' => 450.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Hot-Cocoa.webp', 'description' => 'Rich chocolate comfort in a cup.'],
            ['name' => 'Masala Chai', 'price' => 380.00, 'category_id' => 1, 'image_path' => 'img/products/Beverages/Hot/Masala-Chai.webp', 'description' => 'Spiced black tea with warm aromatics.'],
            
            // Cold Drinks
            ['name' => 'Chilled Coffee', 'price' => 500.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Chilled-Coffee.webp', 'description' => 'Iced coffee with a smooth, creamy finish.'],
            ['name' => 'Chocolate Frappe', 'price' => 650.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Chocolate-Frappe.webp', 'description' => 'Blended chocolate drink—thick and frosty.'],
            ['name' => 'Iced Americano', 'price' => 450.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Iced-Americano.webp', 'description' => 'Bold, refreshing black coffee on ice.'],
            ['name' => 'Lime Juice', 'price' => 300.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Lime-Juice.webp', 'description' => 'Freshly squeezed, crisp and zesty.'],
            ['name' => 'Mango Smoothie', 'price' => 700.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Mango-Smoothie.webp', 'description' => 'Thick tropical blend with ripe mango.'],
            ['name' => 'Peach Iced Tea', 'price' => 450.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Peach-Iced-Tea.webp', 'description' => 'Sweet peach tea chilled over ice.'],
            ['name' => 'Strawberry Milkshake', 'price' => 700.00, 'category_id' => 2, 'image_path' => 'img/products/Beverages/Cold/Strawberry-Milkshake.webp', 'description' => 'Creamy shake with real strawberries.'],

            // Breakfast
            ['name' => 'Avocado Toast', 'price' => 550.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Avocado-Toast.webp', 'description' => 'Toasted bread topped with fresh avocado.'],
            ['name' => 'Chicken Cheese Delight', 'price' => 750.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Chicken-Cheese-Delight.webp', 'description' => 'Grilled chicken sandwich with melted cheese.'],
            ['name' => 'Chocolate Waffles', 'price' => 700.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Chocolate-Waffles-Delight.webp', 'description' => 'Waffles served with chocolate syrup.'],
            ['name' => 'Classic English Breakfast', 'price' => 950.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Classic-English-Breakfast.webp', 'description' => 'Eggs, sausages, beans, and toast.'],
            ['name' => 'Eggs on Toast', 'price' => 500.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Eggs-on-Toast.webp', 'description' => 'Scrambled eggs served over toasted bread.'],
            ['name' => 'Maple Syrup Pancakes', 'price' => 650.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Maple-Syrup-Pancakes.webp', 'description' => 'Fluffy pancakes drizzled with maple syrup.'],
            ['name' => 'Omelette with Vegetables', 'price' => 600.00, 'category_id' => 3, 'image_path' => 'img/products/Food/Breakfast/Omelette-with-Vegetables.webp', 'description' => 'Soft omelette packed with seasonal veggies.'],

            // Lunch
            ['name' => 'Chicken Fried Rice', 'price' => 750.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Chicken-Fried-Rice.webp', 'description' => 'Fried rice with chicken and vegetables.'],
            ['name' => 'Fish Curry', 'price' => 850.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Fish-Curry.webp', 'description' => 'Spicy Sri Lankan-style fish curry.'],
            ['name' => 'Grilled Chicken Delight', 'price' => 900.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Grilled-Chicken-Delight.webp', 'description' => 'Grilled chicken breast served with rice.'],
            ['name' => 'Paneer with Naan', 'price' => 800.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Paneer-with-Naan.webp', 'description' => 'Paneer curry served with butter naan.'],
            ['name' => 'Rice and Curry', 'price' => 700.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Rice-and-Curry.webp', 'description' => 'Sri Lankan rice with assorted curries.'],
            ['name' => 'Spaghetti Bolognese', 'price' => 950.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Spaghetti-Bolognese.webp', 'description' => 'Italian spaghetti with beef sauce.'],
            ['name' => 'Vegetable Biriyani', 'price' => 800.00, 'category_id' => 4, 'image_path' => 'img/products/Food/Lunch/Vegetable-Biriyani.webp', 'description' => 'Fragrant rice with mixed vegetables and spices.'],

            // Dinner
            ['name' => 'BBQ Chicken Pizza', 'price' => 1200.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/BBQ-Chicken-Pizza.webp', 'description' => 'Pizza topped with BBQ chicken and cheese.'],
            ['name' => 'Burger and Fries', 'price' => 950.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Burger-and-Fries.webp', 'description' => 'Beef burger with crispy fries.'],
            ['name' => 'Chicken and Mash', 'price' => 1100.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Chicken-and-Mash.webp', 'description' => 'Roast chicken served with mashed potatoes.'],
            ['name' => 'Chicken Kottu', 'price' => 900.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Chicken-Kottu.webp', 'description' => 'Sri Lankan kottu roti with chicken and spices.'],
            ['name' => 'Margarita Pizza', 'price' => 1000.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Margarita-Pizza.webp', 'description' => 'Classic pizza with tomato and mozzarella.'],
            ['name' => 'Seafood Pasta', 'price' => 1300.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Seafood-Pasta.webp', 'description' => 'Pasta served with a mix of seafood.'],
            ['name' => 'Veggie Noodles', 'price' => 800.00, 'category_id' => 5, 'image_path' => 'img/products/Food/Dinner/Veggie-Noodles.webp', 'description' => 'Stir-fried noodles with vegetables.'],

            // Snacks
            ['name' => 'Chicken Nuggets', 'price' => 550.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Chicken-Nuggets.webp', 'description' => 'Crispy golden chicken nuggets.'],
            ['name' => 'Chicken Popcorn', 'price' => 500.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Chicken-Popcorn.webp', 'description' => 'Bite-sized crunchy chicken popcorn.'],
            ['name' => 'French Fries', 'price' => 400.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/French-Fries.webp', 'description' => 'Golden fried potato sticks.'],
            ['name' => 'Garlic Bread', 'price' => 450.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Garlic-Bread.webp', 'description' => 'Toasted bread with garlic and butter.'],
            ['name' => 'Mini Sliders', 'price' => 700.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Mini-Sliders.webp', 'description' => 'Mini beef burgers served in a set.'],
            ['name' => 'Samosa', 'price' => 350.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Samosa.webp', 'description' => 'Crispy pastry stuffed with spiced potatoes.'],
            ['name' => 'Veggies Springrolls', 'price' => 450.00, 'category_id' => 6, 'image_path' => 'img/products/Food/Snacks/Veggies-Springrolls.webp', 'description' => 'Crispy rolls filled with vegetables.'],

            // Desserts
            ['name' => 'Blueberry Cheesecake', 'price' => 850.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Blueberry-Cheesecake.webp', 'description' => 'Cheesecake topped with fresh blueberries.'],
            ['name' => 'Chocolate Brownies', 'price' => 600.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Chocolate-Brownies.webp', 'description' => 'Rich chocolate brownies, chewy and fudgy.'],
            ['name' => 'Chocolate Lava Cake', 'price' => 700.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Chocolate-Lava-Cake.webp', 'description' => 'Warm cake with molten chocolate center.'],
            ['name' => 'Fruit Salad Delight', 'price' => 500.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Fruit-Salad-Delight.webp', 'description' => 'Fresh fruit salad drizzled with honey.'],
            ['name' => 'Ice Cream Sundae', 'price' => 650.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Ice-Cream-Sundae.webp', 'description' => 'Sundae with ice cream and toppings.'],
            ['name' => 'Sweet Donut', 'price' => 300.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Sweet-Donut.webp', 'description' => 'Soft donut topped with icing and sprinkles.'],
            ['name' => 'Tiramisu', 'price' => 900.00, 'category_id' => 7, 'image_path' => 'img/products/Food/Desserts/Tiramisu.webp', 'description' => 'Classic Italian dessert with coffee and cream.'],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }
        $this->command->info('Products Seeded.');

        $this->command->info('Seeding Bundles...');
        // 3. Seed Bundles (Promotions)
        $bundles = [
            [
                'name' => 'Morning Kickstart',
                'description' => 'Start your day right with an Americano and Avocado Toast.',
                'price' => 850.00, // Bundle price (vs 950 individual)
                'image_path' => 'img/products/Promotions/Healthy Mornings.webp',
                'products' => ['Americano', 'Avocado Toast']
            ],
            [
                'name' => 'Coffee Lovers',
                'description' => 'Double the caffeine, double the fun. Latte and Espresso.',
                'price' => 700.00,
                'image_path' => 'img/products/Promotions/Coffee Lovers.webp',
                'products' => ['Cafe Latte', 'Espresso']
            ],
            [
                'name' => 'Sweet Treat',
                'description' => 'Indulge in a Chocolate Frappe and Brownie.',
                'price' => 1100.00,
                'image_path' => 'img/products/Promotions/Festive Treats.webp',
                'products' => ['Chocolate Frappe', 'Chocolate Brownies']
            ],
             [
                'name' => 'Summer Coolers',
                'description' => 'Beat the heat with Lime Juice and Mango Smoothie.',
                'price' => 900.00,
                'image_path' => 'img/products/Promotions/Summer Coolers.webp',
                'products' => ['Lime Juice', 'Mango Smoothie']
            ],
             [
                'name' => 'Midnight Snacks',
                'description' => 'Late night hunger? Grab a Burger and Fries.',
                'price' => 900.00,
                'image_path' => 'img/products/Promotions/Midnight Snacks.webp',
                'products' => ['Burger and Fries']
            ]
        ];

        foreach ($bundles as $bundleData) {
            $productsToAttach = $bundleData['products'];
            unset($bundleData['products']);

            $promotion = Promotion::create($bundleData);

            // Find product IDs and attach
            $productIds = Product::whereIn('name', $productsToAttach)->pluck('id');
            $promotion->products()->attach($productIds);
        }
        $this->command->info('Bundles Seeded.');

        // 4. Create User
        $this->command->info('Seeding User...');
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->command->info('User Seeded.');
    }
}
