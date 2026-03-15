<?php

namespace App\Factories;



use App\Models\Discount;
use Illuminate\Support\Facades\Log;

class DiscountFactory {
    public static function createDiscount($type, $value) {
        Log::info('DiscountFactory: Creating discount of type ' . $type . ' with value ' . $value);
        switch ($type) {
            case 'percentage':
                return new PercentageDiscount($value);
            case 'fixed':
                return new FixedDiscount($value);
            default:
                throw new InvalidArgumentException("Unknown discount type: $type");
        }
    }
}
