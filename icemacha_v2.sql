-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 09:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icemacha_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-adc7f04411b6372c3a8e10110087386e', 'i:1;', 1769326315),
('laravel-cache-adc7f04411b6372c3a8e10110087386e:timer', 'i:1769326315;', 1769326315);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartId` int(10) UNSIGNED NOT NULL,
  `UserId` bigint(20) UNSIGNED NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartId`, `UserId`, `CreatedAt`) VALUES
(1, 2, '2026-01-25 07:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `CartItemId` int(10) UNSIGNED NOT NULL,
  `CartId` int(10) UNSIGNED NOT NULL,
  `ProductId` bigint(20) UNSIGNED NOT NULL,
  `PromotionId` bigint(20) UNSIGNED DEFAULT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`CartItemId`, `CartId`, `ProductId`, `PromotionId`, `Quantity`) VALUES
(1, 1, 2, NULL, 1),
(2, 1, 12, NULL, 1),
(3, 1, 11, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hot Drinks', 'Bold and comforting hot beverages.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(2, 'Cold Drinks', 'Refreshing chilled drinks and frappes.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(3, 'Breakfast', 'Start your day with wholesome meals.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(4, 'Lunch', 'Spicy and savory midday delights.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(5, 'Dinner', 'Satisfying evening meals.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(6, 'Snacks', 'Crispy and crunchy bite-sized favorites.', '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(7, 'Desserts', 'Sweet treats to end your meal.', '2026-01-23 12:31:01', '2026-01-23 12:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_20_045640_add_two_factor_columns_to_users_table', 1),
(5, '2026_01_20_045719_create_personal_access_tokens_table', 1),
(6, '2026_01_23_160016_create_categories_table', 1),
(7, '2026_01_23_160459_create_promotions_table', 1),
(8, '2026_01_23_160633_create_products_table', 1),
(9, '2026_01_23_160757_add_role_to_users_table', 1),
(10, '2026_01_23_161104_create_carts_table', 1),
(11, '2026_01_23_161155_create_cart_items_table', 1),
(12, '2026_01_23_161235_create_orders_table', 1),
(13, '2026_01_23_161320_create_order_items_table', 1),
(14, '2026_01_23_161411_create_product_promotion_table', 1),
(15, '2026_01_23_161456_create_contact_messages_table', 1),
(16, '2026_01_24_000000_create_legacy_cart_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `promotion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock_quantity`, `image_path`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Americano', 'Bold black coffee, smooth and strong.', 400.00, 50, 'img/products/Beverages/Hot/Americano.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(2, 'Cafe Latte', 'Espresso with silky steamed milk.', 450.00, 50, 'img/products/Beverages/Hot/Cafe-Latte.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(3, 'Cappuccino', 'Espresso, milk, and foam in balance.', 500.00, 50, 'img/products/Beverages/Hot/Cappuccino.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(4, 'Espresso', 'Intense single-shot coffee.', 350.00, 50, 'img/products/Beverages/Hot/Espresso.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(5, 'Green Tea', 'Light, calming and refreshing brew.', 300.00, 50, 'img/products/Beverages/Hot/Green-Tea.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(6, 'Hot Cocoa', 'Rich chocolate comfort in a cup.', 450.00, 50, 'img/products/Beverages/Hot/Hot-Cocoa.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(7, 'Masala Chai', 'Spiced black tea with warm aromatics.', 380.00, 50, 'img/products/Beverages/Hot/Masala-Chai.webp', 1, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(8, 'Chilled Coffee', 'Iced coffee with a smooth, creamy finish.', 500.00, 50, 'img/products/Beverages/Cold/Chilled-Coffee.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(9, 'Chocolate Frappe', 'Blended chocolate drink—thick and frosty.', 650.00, 50, 'img/products/Beverages/Cold/Chocolate-Frappe.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(10, 'Iced Americano', 'Bold, refreshing black coffee on ice.', 450.00, 50, 'img/products/Beverages/Cold/Iced-Americano.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(11, 'Lime Juice', 'Freshly squeezed, crisp and zesty.', 300.00, 50, 'img/products/Beverages/Cold/Lime-Juice.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(12, 'Mango Smoothie', 'Thick tropical blend with ripe mango.', 700.00, 50, 'img/products/Beverages/Cold/Mango-Smoothie.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(13, 'Peach Iced Tea', 'Sweet peach tea chilled over ice.', 450.00, 50, 'img/products/Beverages/Cold/Peach-Iced-Tea.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(14, 'Strawberry Milkshake', 'Creamy shake with real strawberries.', 700.00, 50, 'img/products/Beverages/Cold/Strawberry-Milkshake.webp', 2, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(15, 'Avocado Toast', 'Toasted bread topped with fresh avocado.', 550.00, 50, 'img/products/Food/Breakfast/Avocado-Toast.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(16, 'Chicken Cheese Delight', 'Grilled chicken sandwich with melted cheese.', 750.00, 50, 'img/products/Food/Breakfast/Chicken-Cheese-Delight.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(17, 'Chocolate Waffles', 'Waffles served with chocolate syrup.', 700.00, 50, 'img/products/Food/Breakfast/Chocolate-Waffles-Delight.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(18, 'Classic English Breakfast', 'Eggs, sausages, beans, and toast.', 950.00, 50, 'img/products/Food/Breakfast/Classic-English-Breakfast.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(19, 'Eggs on Toast', 'Scrambled eggs served over toasted bread.', 500.00, 50, 'img/products/Food/Breakfast/Eggs-on-Toast.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(20, 'Maple Syrup Pancakes', 'Fluffy pancakes drizzled with maple syrup.', 650.00, 50, 'img/products/Food/Breakfast/Maple-Syrup-Pancakes.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(21, 'Omelette with Vegetables', 'Soft omelette packed with seasonal veggies.', 600.00, 50, 'img/products/Food/Breakfast/Omelette-with-Vegetables.webp', 3, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(22, 'Chicken Fried Rice', 'Fried rice with chicken and vegetables.', 750.00, 50, 'img/products/Food/Lunch/Chicken-Fried-Rice.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(23, 'Fish Curry', 'Spicy Sri Lankan-style fish curry.', 850.00, 50, 'img/products/Food/Lunch/Fish-Curry.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(24, 'Grilled Chicken Delight', 'Grilled chicken breast served with rice.', 900.00, 50, 'img/products/Food/Lunch/Grilled-Chicken-Delight.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(25, 'Paneer with Naan', 'Paneer curry served with butter naan.', 800.00, 50, 'img/products/Food/Lunch/Paneer-with-Naan.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(26, 'Rice and Curry', 'Sri Lankan rice with assorted curries.', 700.00, 50, 'img/products/Food/Lunch/Rice-and-Curry.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(27, 'Spaghetti Bolognese', 'Italian spaghetti with beef sauce.', 950.00, 50, 'img/products/Food/Lunch/Spaghetti-Bolognese.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(28, 'Vegetable Biriyani', 'Fragrant rice with mixed vegetables and spices.', 800.00, 50, 'img/products/Food/Lunch/Vegetable-Biriyani.webp', 4, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(29, 'BBQ Chicken Pizza', 'Pizza topped with BBQ chicken and cheese.', 1200.00, 50, 'img/products/Food/Dinner/BBQ-Chicken-Pizza.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(30, 'Burger and Fries', 'Beef burger with crispy fries.', 950.00, 50, 'img/products/Food/Dinner/Burger-and-Fries.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(31, 'Chicken and Mash', 'Roast chicken served with mashed potatoes.', 1100.00, 50, 'img/products/Food/Dinner/Chicken-and-Mash.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(32, 'Chicken Kottu', 'Sri Lankan kottu roti with chicken and spices.', 900.00, 50, 'img/products/Food/Dinner/Chicken-Kottu.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(33, 'Margarita Pizza', 'Classic pizza with tomato and mozzarella.', 1000.00, 50, 'img/products/Food/Dinner/Margarita-Pizza.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(34, 'Seafood Pasta', 'Pasta served with a mix of seafood.', 1300.00, 50, 'img/products/Food/Dinner/Seafood-Pasta.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(35, 'Veggie Noodles', 'Stir-fried noodles with vegetables.', 800.00, 50, 'img/products/Food/Dinner/Veggie-Noodles.webp', 5, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(36, 'Chicken Nuggets', 'Crispy golden chicken nuggets.', 550.00, 50, 'img/products/Food/Snacks/Chicken-Nuggets.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(37, 'Chicken Popcorn', 'Bite-sized crunchy chicken popcorn.', 500.00, 50, 'img/products/Food/Snacks/Chicken-Popcorn.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(38, 'French Fries', 'Golden fried potato sticks.', 400.00, 50, 'img/products/Food/Snacks/French-Fries.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(39, 'Garlic Bread', 'Toasted bread with garlic and butter.', 450.00, 50, 'img/products/Food/Snacks/Garlic-Bread.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(40, 'Mini Sliders', 'Mini beef burgers served in a set.', 700.00, 50, 'img/products/Food/Snacks/Mini-Sliders.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(41, 'Samosa', 'Crispy pastry stuffed with spiced potatoes.', 350.00, 50, 'img/products/Food/Snacks/Samosa.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(42, 'Veggies Springrolls', 'Crispy rolls filled with vegetables.', 450.00, 50, 'img/products/Food/Snacks/Veggies-Springrolls.webp', 6, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(43, 'Blueberry Cheesecake', 'Cheesecake topped with fresh blueberries.', 850.00, 50, 'img/products/Food/Desserts/Blueberry-Cheesecake.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(44, 'Chocolate Brownies', 'Rich chocolate brownies, chewy and fudgy.', 600.00, 50, 'img/products/Food/Desserts/Chocolate-Brownies.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(45, 'Chocolate Lava Cake', 'Warm cake with molten chocolate center.', 700.00, 50, 'img/products/Food/Desserts/Chocolate-Lava-Cake.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(46, 'Fruit Salad Delight', 'Fresh fruit salad drizzled with honey.', 500.00, 50, 'img/products/Food/Desserts/Fruit-Salad-Delight.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(47, 'Ice Cream Sundae', 'Sundae with ice cream and toppings.', 650.00, 50, 'img/products/Food/Desserts/Ice-Cream-Sundae.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(48, 'Sweet Donut', 'Soft donut topped with icing and sprinkles.', 300.00, 50, 'img/products/Food/Desserts/Sweet-Donut.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01'),
(49, 'Tiramisu', 'Classic Italian dessert with coffee and cream.', 900.00, 50, 'img/products/Food/Desserts/Tiramisu.webp', 7, '2026-01-23 12:31:01', '2026-01-23 12:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_promotion`
--

CREATE TABLE `product_promotion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('Percentage','Fixed Amount') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('j7eh2lVVslZjk7ovH8PaTImdYT66auGOAfsm4PpK', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYWE5Wk1qc1A5dlBSVW1kWU5EeHJiU1I5ZWhiSW9SbWh3R0ttdEZrQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0IjtzOjU6InJvdXRlIjtzOjQ6ImNhcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1769328412);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Manojram User #2', 'manojram2@gmail.com', NULL, '$2y$12$T9rvmlLmcx2SY9170uNAhe8c2GD.jbiJLiSGG3DfHMFpWz9Lr7nTK', 'customer', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-24 11:08:21', '2026-01-24 11:08:21'),
(2, 'Manojram', 'manojram3@gmail.com', NULL, '$2y$12$8Pis2iGQTKlcei/4aiXQ3O80kP/peMUcpNa4kHFxJ9vIIjtcxpbG6', 'customer', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-24 11:13:16', '2026-01-24 11:13:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartId`),
  ADD KEY `cart_userid_foreign` (`UserId`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`CartItemId`),
  ADD KEY `cartitems_cartid_foreign` (`CartId`),
  ADD KEY `cartitems_productid_foreign` (`ProductId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_promotion`
--
ALTER TABLE `product_promotion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_promotion_product_id_foreign` (`product_id`),
  ADD KEY `product_promotion_promotion_id_foreign` (`promotion_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `CartItemId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `product_promotion`
--
ALTER TABLE `product_promotion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_userid_foreign` FOREIGN KEY (`UserId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_cartid_foreign` FOREIGN KEY (`CartId`) REFERENCES `cart` (`CartId`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartitems_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_promotion`
--
ALTER TABLE `product_promotion`
  ADD CONSTRAINT `product_promotion_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_promotion_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
