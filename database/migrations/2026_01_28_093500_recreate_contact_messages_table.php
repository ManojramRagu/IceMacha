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
        Schema::dropIfExists('contact_messages');

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->integer('MessageId')->autoIncrement();
            $table->unsignedBigInteger('UserId')->nullable();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Email');
            $table->string('Subject');
            $table->text('Message');
            $table->timestamp('CreatedAt')->useCurrent();
            
            $table->foreign('UserId')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        
        // Optionally recreate the old table here if rollback is needed strictly, 
        // but typically dropping is enough for a 'recreate' migration unless strict history is needed.
    }
};
