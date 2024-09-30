<?php

namespace App\Decorators;

// Author : Lim Jia Qing

class DecoratorFactory
{
    /**
     * Apply the correct remark decorator to the menu based on the remark type.
     *
     * @param MenuInterface $menu
     * @param Remark $remark
     * @return MenuInterface
     */
    public static function applyRemark(MenuInterface $menu, string $remarkName)
    {
        switch ($remarkName) {
            case 'No Veg':
                return new NoVegRemark($menu);
            case 'No Spicy':
                return new NoSpicyRemark($menu);
            case 'Less Spicy':
                return new LessSpicyRemark($menu);
                case 'More Sauce':
                    return new MoreSauceRemark($menu);
                case 'Add Cheese':
                    return new AddCheeseRemark($menu);
            // Add more cases for additional remark types as needed...
            default:
                return $menu; // If no matching remark, return the menu unchanged
        }
    }

    /**
     * Return all available remarks with corresponding decorators.
     *
     * @return array
     */
    public static function getAvailableRemarks()
    {
        return [
            ['name' => 'No Veg', 'price' => 0.00],
            ['name' => 'No Spicy', 'price' => 0.00],
            ['name' => 'Less Spicy', 'price' => 0.00],
            ['name' => 'More Sauce', 'price' => 1.00],
            ['name' => 'Add Cheese', 'price' => 2.00],
            // Add more available remarks here...
        ];
    }
}
