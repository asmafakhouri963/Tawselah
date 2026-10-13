<?php

namespace App\Services\Price;

use App\Services\Price\Contracts\DeliveryPriceStrategyInterface;
use App\Services\Price\Strategies\StandardDeliveryStrategy;
use App\Services\Price\Strategies\ExpressDeliveryStrategy;
use Exception;

class DeliveryPriceStrategyFactory
{
    public static function make(string $type): DeliveryPriceStrategyInterface
    {
        return match ($type) {
            'express' => new ExpressDeliveryStrategy(),
            'standard' => new StandardDeliveryStrategy(),
            default => throw new Exception('نوع التوصيل غير صالح'),
        };
    }
}