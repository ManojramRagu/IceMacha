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
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id('CartItemId');
            $table->foreignId('CartId')->constrained('cart', 'CartId')->onDelete('cascade');
            $table->foreignId('ProductId')->nullable()->constrained('products', 'id')->onDelete('cascade');
            $table->foreignId('PromotionId')->nullable()->constrained('promotions', 'id')->onDelete('set null');
            $table->integer('Quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
