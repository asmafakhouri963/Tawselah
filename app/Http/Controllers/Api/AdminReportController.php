<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Scopes\ActiveShopScope;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AdminReportController extends Controller
{
    use ApiResponse;

    /**
     * تقرير الإدارة الشامل للمحلات (يتجاوز الـ Global Scope للمحلات الموقوفة بشكل مقصود)
     */
    public function shopsReport(): JsonResponse
    {
        // استخدام withoutGlobalScope لإظهار المحلات الموقوفة والنشطة معاً في تقارير الإدارة
        $allShopsIncludingInactive = Shop::withoutGlobalScope(ActiveShopScope::class)->get();

        return $this->successResponse($allShopsIncludingInactive, 'تم جلب تقرير المحلات للإدارة بنجاح');
    }
}

