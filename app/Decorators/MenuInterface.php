<?php

namespace App\Decorators;


interface MenuInterface
{
    /**
     * Get the description of the menu item.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the price of the menu item.
     *
     * @return float
     */
    public function getPrice();
}
