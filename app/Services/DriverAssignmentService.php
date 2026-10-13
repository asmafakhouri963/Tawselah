<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Contracts\DriverAssignmentInterface;

class DriverAssignmentService implements DriverAssignmentInterface
{
    public function assignBestDriver(Order $order): ?int
    {
        // ناختيار السائق الأنسب (مثلاً الأقرب أو الأقل طلباً)
        
        return null; 
    }
}