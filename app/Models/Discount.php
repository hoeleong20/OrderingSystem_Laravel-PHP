<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'discounts';

    // Define the fillable attributes
    protected $fillable = [
        'name',
        'description',
        'promo_code',
        'start_date',
        'end_date',
        'total_usage', // -1 for unlimited usage
        'usage_per_user', // -1 for unlimited usage
        'criteria', // comma-separated values, contains new_user, and min_purchase
        'condition', // condition for each criteria
        'discount_type',
        'discount_value',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // criteria and condition example

    // new_user : 10 days
    // means that the discount only can be used by new user within 10 days after they registered

    // min_purchase : 100.00
    // means that the discount only can be used if the total purchase is more than 100.00
}
