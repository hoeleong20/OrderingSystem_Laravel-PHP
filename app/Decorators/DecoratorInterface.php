<?php

namespace App\Decorators;

// Author : Lim Jia Qing

interface DecoratorInterface
{
    public function getDescription(): string;
    public function getPriceAdjustment(): float;
}
