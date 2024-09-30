<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            [
                'name' => 'New Year Discount',
                'description' => 'Celebrate the new year with discounts!',
                'promo_code' => 'NEWYEAR2024',
                'start_date' => Carbon::parse('2024-01-01'),
                'end_date' => Carbon::parse('2024-01-31'),
                'total_usage' => -1, // means unlimited usage
                'usage_per_user' => 3,
                'criteria' => 'min_purchase',
                'condition' => '40',
                'discount_type' => 'fixed',
                'discount_value' => 30.00,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'name' => 'Christmas Discount',
                'description' => 'Celebrate the christmas with discounts for new customer!',
                'promo_code' => 'CHRISTMAS2024',
                'start_date' => Carbon::parse('2024-12-24'),
                'end_date' => Carbon::parse('2024-12-31'),
                'total_usage' => -1, // means unlimited usage
                'usage_per_user' => 3,
                'criteria' => 'new_user',
                'condition' => '10 days',
                'discount_type' => 'percentage',
                'discount_value' => 30.00,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
