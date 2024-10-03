<?php

namespace App\Factories;

// Author : Chong Soon He

class FixedDiscount implements DiscountInterface {
    protected $amount;

    public function __construct($amount) {
        $this->amount = $amount;
    }

    public function applyDiscount($amount) {
        return max($amount - $this->amount, 0);
    }
}
