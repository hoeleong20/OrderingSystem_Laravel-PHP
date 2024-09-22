<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuSeeder::class, // Add this line to call the MenuSeeder
        
        ]);

        // User::factory(10)->create();

        
        CartItem::factory(3)->create();
        Order::factory(3)->create();
    }
}
