<?php

namespace App\Decorators;


interface DecoratorInterface
{
    public function getDescription(): string;
    public function getPriceAdjustment(): float;
}
