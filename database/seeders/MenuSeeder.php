<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu; // Make sure to include the Menu model

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert your current menu data
        Menu::insert([
            [
                'menu_code' => 'A001',
                'name' => 'Spaghetti Bolognese',
                'desc' => 'Delicious spaghetti with Bolognese sauce.',
                'price' => 12.99,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'A002',
                'name' => 'Caesar Salad',
                'desc' => 'Fresh Caesar salad with chicken and croutons.',
                'price' => 8.50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'A003',
                'name' => 'Grilled Cheese Sandwich',
                'desc' => 'Classic grilled cheese sandwich with melted cheddar.',
                'price' => 6.75,
                'status' => 'soldOut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'A004',
                'name' => 'Pizza',
                'desc' => 'Bread with cheese for 2.',
                'price' => 20.20,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'A005',
                'name' => 'Spaghetti White Sauce',
                'desc' => 'Noodle with a lot of sauce.',
                'price' => 16.50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_code' => 'A006',
                'name' => 'Chicken Chop',
                'desc' => 'A chicken deep fried.',
                'price' => 18.20,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
