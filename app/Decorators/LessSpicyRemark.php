<?php

namespace App\Decorators;


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
