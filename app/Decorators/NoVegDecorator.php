<?php

namespace App\Decorators;

use App\Models\Menu;

class NoVegDecorator implements DecoratorInterface
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function getDescription(): string
    {
        return $this->menu->desc . ' (No Veg)';
    }

    public function getPriceAdjustment(): float
    {
        // Adjust price if needed for "No Veg"
        return 0.0; // Example: No price adjustment for "No Veg"
    }
}
