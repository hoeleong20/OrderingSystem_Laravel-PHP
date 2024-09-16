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
                ->default('active');       // Enum status
            $table->timestamps();                   // Created_at and Updated_at timestamps
        });

        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->string('menu_code');        // Foreign key reference to menus
            $table->string('remark');           // Remark description (e.g., "No veg", "Less spicy")
            $table->foreign('menu_code')
                ->references('menu_code')
                ->on('menu')
                ->onDelete('cascade');
            $table->timestamps();               // Created_at and Updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remarks');
        Schema::dropIfExists('menu');
    }
};
