<?php

namespace App\Decorators;

class NoSpicyRemark extends RemarkDecorator
{
    /**
     * Modify the menu description to indicate "No Spicy".
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->menu->getDescription() . ', No Spicy';
    }

    /**
     * No additional cost for "No Spicy" remark.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->menu->getPrice();
    }
}
