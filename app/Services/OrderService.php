<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * جلب الطلبات الحالية بـ Select دقيق وعلاقات محملة مسبقاً (Eager Loading) لمنع N+1
     */
    public function getCurrentOrders(): Collection
    {
        return Order::active()
            ->select('id', 'customer_id', 'shop_id', 'driver_id', 'status', 'total_amount', 'created_at')
            ->with([
                'customer:id,name',
                'shop:id,name',
                'driver:id,name',
                'items:id,order_id,quantity' // جلب عدد عناصر الطلب فقط دون جلب الأعمدة الزائدة
            ])
            ->latest()
            ->get();
    }
}