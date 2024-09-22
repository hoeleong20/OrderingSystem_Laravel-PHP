<?php

namespace App\Decorators;

// Author : Lim Jia Qing

class LessSpicyRemark extends RemarkDecorator
{
    /**
     * Modify the menu description to indicate "Less Spicy".
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->menu->getDescription() . ', Less Spicy';
    }

    /**
     * No additional cost for "Less Spicy" remark.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->menu->getPrice();
    }
}
