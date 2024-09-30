<?php

namespace App\Factories;

// Author : Chong Soon He

use App\Models\Discount;

interface DiscountInterface {
    public function applyDiscount($amount);
}