<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface DriverAssignmentInterface
{
    public function assignBestDriver(Order $order): ?int;
}