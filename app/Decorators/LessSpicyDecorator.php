<?php

namespace App\Decorators;

use App\Models\Menu;

class LessSpicyDecorator implements DecoratorInterface
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function getDescription(): string
    {
        return $this->menu->desc . ' (Less Spicy)';
    }

    public function getPriceAdjustment(): float
    {
        // Adjust price if needed for "Less Spicy"
        return 0.0; // Example: Add $0.00 for "Less Spicy"
    }
}