<?php

namespace App\Decorators;

// Author : Lim Jia Qing

abstract class RemarkDecorator implements MenuInterface
{
    protected $menu;

    /**
     * Constructor to pass the MenuInterface object.
     *
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Delegate the description call to the decorated menu.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->menu->getDescription();
    }

    /**
     * Delegate the price call to the decorated menu.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->menu->getPrice();
    }
}
