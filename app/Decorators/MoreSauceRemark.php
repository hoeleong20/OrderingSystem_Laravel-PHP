<?php

namespace App\Decorators;

// Author : Lim Jia Qing

class MoreSauceRemark extends RemarkDecorator
{
    public function getDescription()
    {
        return $this->menu->getDescription() . ', More Sauce';
    }

    public function getPrice()
    {
        // Add 1.00 to the base price
        return $this->menu->getPrice() + 1.00;
    }
}
