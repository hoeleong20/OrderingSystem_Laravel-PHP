<?php

namespace App\Decorators;

// Author : Lim Jia Qing

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
