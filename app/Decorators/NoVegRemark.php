<?php

namespace App\Decorators;

class NoVegRemark extends RemarkDecorator
{
    /**
     * Modify the menu description to indicate "No Veg".
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->menu->getDescription() . ', No Veg';
    }

    /**
     * No additional cost for "No Veg" remark.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->menu->getPrice();
    }
}
