<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Legacy Schema for Carts
        Schema::create('cart', function (Blueprint $table) {
            $table->id('CartId');
            $table->foreignId('UserId')->constrained('users')->onDelete('cascade');
            $table->timestamp('CreatedAt')->useCurrent();
        });

        // Legacy Schema for CartItems
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id('CartItemId');
            $table->foreignId('CartId')->constrained('cart', 'CartId')->onDelete('cascade');
            $table->foreignId('ProductId')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('PromotionId')->nullable()->constrained('promotions')->onDelete('cascade');
            $table->integer('Quantity')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cartitems');
        Schema::dropIfExists('cart');
    }
};
