<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description'); // Changed from desc to description
            $table->string('promo_code')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_usage')->default(-1); // -1 indicates unlimited usage
            $table->integer('usage_per_user')->default(-1); // -1 indicates unlimited per user
            $table->string('criteria')->nullable(); // e.g., "certain event, minimum spend, food type, new customer"
            $table->string('condition')->nullable(); // e.g., "date-date, 50.00, A001, 10 days"
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); // Automatically adds created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
