<?php

namespace app\Models\Composite;

// Author Khor Zhi Ying 

use app\Models\Menu;

class DishReservation extends ReservableComponent {
    protected $dishes = [];

    public function __construct(array $dish)
    {
        $this->dishes = $dish;
    }

    public function reserve()
    {
        foreach ($this->dishes as $dish) {
            $dish->reserve();
        }
    }

    public function cancel()
    {
        foreach ($this->dishes as $dish) {
            $dish->cancel();
        }
    }

    public function getDetails()
    {
        return [
            'type' => 'dish',
            'dishes' => $this->dishes
        ];
    }
}