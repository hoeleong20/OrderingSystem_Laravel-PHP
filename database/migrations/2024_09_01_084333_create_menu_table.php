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
            $table->timestamps();                   // Created_at and Updated_at timestamps
        });

        Schema::create('remarks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // The remark name (e.g., "No veg", "Add an egg")
            $table->decimal('price', 8, 2)->default(0.00); // Extra cost for this remark
            $table->timestamps(); // Timestamps to track creation and updates
        });

        Schema::create('menu_remark', function (Blueprint $table) {
            $table->id();

            // Foreign key reference to the 'menu' table using menu_code
            $table->string('menu_code');
            $table->foreign('menu_code')->references('menu_code')->on('menu')->onDelete('cascade');

            // Foreign key reference to the 'remarks' table using remark_id
            $table->foreignId('remark_id')->constrained()->onDelete('cascade');

            $table->timestamps(); // Timestamps to track when records are created/updated
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the pivot table 'menu_remark' first due to foreign key constraints
        Schema::dropIfExists('menu_remark');

        // Then drop the 'remarks' table
        Schema::dropIfExists('remarks');

        // Finally, drop the 'menu' table
        Schema::dropIfExists('menu');
    }
};
