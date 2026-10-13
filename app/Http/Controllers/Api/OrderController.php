<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(protected OrderService $orderService) {}

    /**
     * شاشة الطلبات الحالية لموظف المتابعة
     */
    public function currentOrders(): JsonResponse
    {
        $orders = $this->orderService->getCurrentOrders();

        return $this->successResponse($orders, 'تم جلب الطلبات الحالية بنجاح');
    }
}