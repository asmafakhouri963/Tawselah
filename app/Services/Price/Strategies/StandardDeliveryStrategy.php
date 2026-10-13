<?php

namespace App\Services\Price\Strategies;

use App\Services\Price\Contracts\DeliveryPriceStrategyInterface;

class StandardDeliveryStrategy implements DeliveryPriceStrategyInterface
{
    public function calculate(array $orderData): float
    {
        // حساب السعر العادي للتوصيل
        return 15.00;
    }
}