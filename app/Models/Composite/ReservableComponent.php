<?php

namespace app\Models\Composite;

// Author Khor Zhi Ying 

abstract class ReservableComponent {
    abstract public function reserve();
    abstract public function cancel();
    abstract public function getDetails();
}