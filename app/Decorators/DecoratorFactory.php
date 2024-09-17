<?php

namespace App\Decorators;

use App\Models\Menu;
use App\Models\Remark;

class DecoratorFactory
{
    public static function createDecorator(Menu $menu, Remark $remark): DecoratorInterface
    {
        // Implement logic to create the appropriate decorator based on the remark
        if ($remark->remark === 'No Veg') {
            return new NoVegDecorator($menu);
        } elseif ($remark->remark === 'Less Spicy') {
            return new LessSpicyDecorator($menu);
        }
        // Add more conditions for other remarks as needed
        return null; // Handle unknown remark
    }
}