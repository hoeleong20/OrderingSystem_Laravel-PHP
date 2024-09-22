<!-- Author Khor Zhi Ying -->

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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('email'); 
            $table->string('phone'); 
            $table->integer('pax')->default(1);  // Default pax to 1, used for dish reservations
            $table->dateTime('datetime');
            $table->enum('reservation_type', ['table', 'table_with_dish', 'dish', 'event']);
            $table->string('extra_info')->nullable();  // Store additional information based on reservation type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
