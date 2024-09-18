<?php

namespace app\Models\Composite;

abstract class ReservableComponent {
    abstract public function reserve();
    abstract public function cancel();
    abstract public function getDetails();
}