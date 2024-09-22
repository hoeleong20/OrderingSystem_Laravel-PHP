<?php

namespace App\Decorators;

// Author : Lim Jia Qing

class AddCheeseRemark extends RemarkDecorator
{
    public function getDescription()
    {
        return $this->menu->getDescription() . ', Add Cheese';
    }

    public function getPrice()
    {
        return $this->menu->getPrice() + 2.00; // Add 2.00 for Add Cheese
    }
}
