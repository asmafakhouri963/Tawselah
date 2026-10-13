<?php

namespace App\Services\Price\Strategies;

use App\Services\Price\Contracts\DeliveryPriceStrategyInterface;

class ExpressDeliveryStrategy implements DeliveryPriceStrategyInterface
{
    public function calculate(array $orderData): float
    {
        // حساب السعر السريع (Express) مع ضغطة طلب
        return 30.00;
    }
}