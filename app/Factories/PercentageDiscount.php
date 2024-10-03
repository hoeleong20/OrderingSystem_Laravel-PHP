<?php

namespace App\Factories;

// Author : Chong Soon He

class PercentageDiscount implements DiscountInterface {
    protected $percentage;

    public function __construct($percentage) {
        $this->percentage = $percentage;
    }

    public function applyDiscount($amount) {
        return $amount - ($amount * $this->percentage / 100);
    }
}
