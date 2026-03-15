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
        Schema::create('menu', function (Blueprint $table) {
            $table->string('menu_code')->primary(); // Use menu_code as the primary key
            $table->string('name');                 // Name of the menu item
            $table->text('desc')->nullable();       // Optional description of the menu item
            $table->decimal('price', 8, 2);         // Price of the menu item
            $table->enum('status', ['active', 'soldOut', 'archived'])
                ->default('active');                // Enum status
            $table->json('remarkable')->nullable(); // Store array of remarkable tags
            $table->timestamps();                   // Created_at and Updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
