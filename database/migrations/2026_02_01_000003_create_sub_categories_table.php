<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Hot, Cold, Breakfast, etc.
            $table->text('description')->nullable();
            $table->timestamps();

            // Ensure unique name per category if needed, but globally unique might be safer for simple queries
            // $table->unique(['category_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
