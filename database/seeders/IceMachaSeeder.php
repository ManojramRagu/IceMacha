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
            ['name' => 'Americano', 'price' => 400.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Americano.webp', 'desc' => 'Bold black coffee, smooth and strong.'],
            ['name' => 'Cafe Latte', 'price' => 450.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Cafe-Latte.webp', 'desc' => 'Espresso with silky steamed milk.'],
            ['name' => 'Cappuccino', 'price' => 500.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Cappuccino.webp', 'desc' => 'Espresso, milk, and foam in balance.'],
            ['name' => 'Espresso', 'price' => 350.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Espresso.webp', 'desc' => 'Intense single-shot coffee.'],
            ['name' => 'Green Tea', 'price' => 300.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Green-Tea.webp', 'desc' => 'Light, calming and refreshing brew.'],
            ['name' => 'Hot Cocoa', 'price' => 450.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Hot-Cocoa.webp', 'desc' => 'Rich chocolate comfort in a cup.'],
            ['name' => 'Masala Chai', 'price' => 380.00, 'cat' => 'Hot Drinks', 'img' => 'img/products/Beverages/Hot/Masala-Chai.webp', 'desc' => 'Spiced black tea with warm aromatics.'],
            
            // Cold Drinks
            ['name' => 'Chilled Coffee', 'price' => 500.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Chilled-Coffee.webp', 'desc' => 'Iced coffee with a smooth, creamy finish.'],
            ['name' => 'Chocolate Frappe', 'price' => 650.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Chocolate-Frappe.webp', 'desc' => 'Blended chocolate drink—thick and frosty.'],
            ['name' => 'Iced Americano', 'price' => 450.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Iced-Americano.webp', 'desc' => 'Bold, refreshing black coffee on ice.'],
            ['name' => 'Lime Juice', 'price' => 300.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Lime-Juice.webp', 'desc' => 'Freshly squeezed, crisp and zesty.'],
            ['name' => 'Mango Smoothie', 'price' => 700.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Mango-Smoothie.webp', 'desc' => 'Thick tropical blend with ripe mango.'],
            ['name' => 'Peach Iced Tea', 'price' => 450.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Peach-Iced-Tea.webp', 'desc' => 'Sweet peach tea chilled over ice.'],
            ['name' => 'Strawberry Milkshake', 'price' => 700.00, 'cat' => 'Cold Drinks', 'img' => 'img/products/Beverages/Cold/Strawberry-Milkshake.webp', 'desc' => 'Creamy shake with real strawberries.'],
            
            // Breakfast
            ['name' => 'Avocado Toast', 'price' => 550.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Avocado-Toast.webp', 'desc' => 'Toasted bread topped with fresh avocado.'],
            ['name' => 'Chicken Cheese Delight', 'price' => 750.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Chicken-Cheese-Delight.webp', 'desc' => 'Grilled chicken sandwich with melted cheese.'],
            ['name' => 'Chocolate Waffles', 'price' => 700.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Chocolate-Waffles-Delight.webp', 'desc' => 'Waffles served with chocolate syrup.'],
            ['name' => 'Classic English Breakfast', 'price' => 950.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Classic-English-Breakfast.webp', 'desc' => 'Eggs, sausages, beans, and toast.'],
            ['name' => 'Eggs on Toast', 'price' => 500.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Eggs-on-Toast.webp', 'desc' => 'Scrambled eggs served over toasted bread.'],
            ['name' => 'Maple Syrup Pancakes', 'price' => 650.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Maple-Syrup-Pancakes.webp', 'desc' => 'Fluffy pancakes drizzled with maple syrup.'],
            ['name' => 'Omelette with Vegetables', 'price' => 600.00, 'cat' => 'Breakfast', 'img' => 'img/products/Food/Breakfast/Omelette-with-Vegetables.webp', 'desc' => 'Soft omelette packed with seasonal veggies.'],

            // Lunch
            ['name' => 'Chicken Fried Rice', 'price' => 750.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Chicken-Fried-Rice.webp', 'desc' => 'Fried rice with chicken and vegetables.'],
            ['name' => 'Fish Curry', 'price' => 850.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Fish-Curry.webp', 'desc' => 'Spicy Sri Lankan-style fish curry.'],
            ['name' => 'Grilled Chicken Delight', 'price' => 900.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Grilled-Chicken-Delight.webp', 'desc' => 'Grilled chicken breast served with rice.'],
            ['name' => 'Paneer with Naan', 'price' => 800.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Paneer-with-Naan.webp', 'desc' => 'Paneer curry served with butter naan.'],
            ['name' => 'Rice and Curry', 'price' => 700.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Rice-and-Curry.webp', 'desc' => 'Sri Lankan rice with assorted curries.'],
            ['name' => 'Spaghetti Bolognese', 'price' => 950.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Spaghetti-Bolognese.webp', 'desc' => 'Italian spaghetti with beef sauce.'],
            ['name' => 'Vegetable Biriyani', 'price' => 800.00, 'cat' => 'Lunch', 'img' => 'img/products/Food/Lunch/Vegetable-Biriyani.webp', 'desc' => 'Fragrant rice with mixed vegetables and spices.'],

            // Dinner
            ['name' => 'BBQ Chicken Pizza', 'price' => 1200.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/BBQ-Chicken-Pizza.webp', 'desc' => 'Pizza topped with BBQ chicken and cheese.'],
            ['name' => 'Burger and Fries', 'price' => 950.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Burger-and-Fries.webp', 'desc' => 'Beef burger with crispy fries.'],
            ['name' => 'Chicken and Mash', 'price' => 1100.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Chicken-and-Mash.webp', 'desc' => 'Roast chicken served with mashed potatoes.'],
            ['name' => 'Chicken Kottu', 'price' => 900.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Chicken-Kottu.webp', 'desc' => 'Sri Lankan kottu roti with chicken and spices.'],
            ['name' => 'Margarita Pizza', 'price' => 1000.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Margarita-Pizza.webp', 'desc' => 'Classic pizza with tomato and mozzarella.'],
            ['name' => 'Seafood Pasta', 'price' => 1300.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Seafood-Pasta.webp', 'desc' => 'Pasta served with a mix of seafood.'],
            ['name' => 'Veggie Noodles', 'price' => 800.00, 'cat' => 'Dinner', 'img' => 'img/products/Food/Dinner/Veggie-Noodles.webp', 'desc' => 'Stir-fried noodles with vegetables.'],

            // Snacks
            ['name' => 'Chicken Nuggets', 'price' => 550.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Chicken-Nuggets.webp', 'desc' => 'Crispy golden chicken nuggets.'],
            ['name' => 'Chicken Popcorn', 'price' => 500.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Chicken-Popcorn.webp', 'desc' => 'Bite-sized crunchy chicken popcorn.'],
            ['name' => 'French Fries', 'price' => 400.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/French-Fries.webp', 'desc' => 'Golden fried potato sticks.'],
            ['name' => 'Garlic Bread', 'price' => 450.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Garlic-Bread.webp', 'desc' => 'Toasted bread with garlic and butter.'],
            ['name' => 'Mini Sliders', 'price' => 700.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Mini-Sliders.webp', 'desc' => 'Mini beef burgers served in a set.'],
            ['name' => 'Samosa', 'price' => 350.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Samosa.webp', 'desc' => 'Crispy pastry stuffed with spiced potatoes.'],
            ['name' => 'Veggies Springrolls', 'price' => 450.00, 'cat' => 'Snacks', 'img' => 'img/products/Food/Snacks/Veggies-Springrolls.webp', 'desc' => 'Crispy rolls filled with vegetables.'],

            // Desserts
            ['name' => 'Blueberry Cheesecake', 'price' => 850.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Blueberry-Cheesecake.webp', 'desc' => 'Cheesecake topped with fresh blueberries.'],
            ['name' => 'Chocolate Brownies', 'price' => 600.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Chocolate-Brownies.webp', 'desc' => 'Rich chocolate brownies, chewy and fudgy.'],
            ['name' => 'Chocolate Lava Cake', 'price' => 700.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Chocolate-Lava-Cake.webp', 'desc' => 'Warm cake with molten chocolate center.'],
            ['name' => 'Fruit Salad Delight', 'price' => 500.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Fruit-Salad-Delight.webp', 'desc' => 'Fresh fruit salad drizzled with honey.'],
            ['name' => 'Ice Cream Sundae', 'price' => 650.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Ice-Cream-Sundae.webp', 'desc' => 'Sundae with ice cream and toppings.'],
            ['name' => 'Sweet Donut', 'price' => 300.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Sweet-Donut.webp', 'desc' => 'Soft donut topped with icing and sprinkles.'],
            ['name' => 'Tiramisu', 'price' => 900.00, 'cat' => 'Desserts', 'img' => 'img/products/Food/Desserts/Tiramisu.webp', 'desc' => 'Classic Italian dessert with coffee and cream.'],
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