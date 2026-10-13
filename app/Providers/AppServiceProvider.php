<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\DriverAssignmentInterface;
use App\Services\DriverAssignmentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // استخدام مبرر وحقيقي لـ bind للخدمات المركزية في الـ Service Container
        $this->app->bind(
            DriverAssignmentInterface::class,
            DriverAssignmentService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تفعيل منع الـ Lazy Loading تلقائياً في بيئة التطوير لكشف أي N+1 فوراً
        Model::preventLazyLoading(! app()->isProduction());
    }
}