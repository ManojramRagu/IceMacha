<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop standard Laravel tables if they exist to avoid conflicts
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cartitems');
        Schema::dropIfExists('cart');

        Schema::create('cart', function (Blueprint $table) {
            $table->increments('CartId'); // int(11) PK Auto Increment
            $table->unsignedBigInteger('UserId');
            $table->timestamp('CreatedAt')->useCurrent();
            
            $table->foreign('UserId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cartitems', function (Blueprint $table) {
            $table->increments('CartItemId'); // int(11) PK
            $table->unsignedInteger('CartId');
            $table->unsignedBigInteger('ProductId');
            $table->unsignedBigInteger('PromotionId')->nullable();
            $table->integer('Quantity')->default(1);

            $table->foreign('CartId')->references('CartId')->on('cart')->onDelete('cascade');
            // Assuming products table uses 'id' (bigint)
            $table->foreign('ProductId')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
        Schema::dropIfExists('cart');
    }
};
