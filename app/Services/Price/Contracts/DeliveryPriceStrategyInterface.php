<?php

namespace App\Services\Price\Contracts;

interface DeliveryPriceStrategyInterface
{
    public function calculate(array $orderData): float;
}