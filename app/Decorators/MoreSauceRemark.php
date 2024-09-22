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
        return $this->menu->getPrice() + 1.00; // Add 1.00 for More Sauce
    }
}
