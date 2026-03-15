<?php

namespace App\Factories;



use App\Models\Discount;

interface DiscountInterface {
    public function applyDiscount($amount);
}