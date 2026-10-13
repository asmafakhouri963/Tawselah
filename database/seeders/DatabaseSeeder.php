<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء مستخدمين (زبائن وسائقين)
        $customers = User::factory()->count(50)->create();
        $drivers = User::factory()->count(20)->create();

        // 2. إنشاء محلات (بعضها نشط وبعضها موقوف للإدارة)
        $shops = collect();
        for ($i = 1; $i <= 10; $i++) {
            $shops->push(Shop::create([
                'name' => "مطعم ومتجر رقم {$i}",
                'is_active' => $i <= 8, // 8 محلات نشطة ومحلين موقوفين
            ]));
        }

        // 3. توليد آلاف الطلبات (أكثر من 1000 طلب لاختبار الأداء والـ Indexes)
        $statuses = [OrderStatus::PENDING->value, OrderStatus::ACCEPTED->value, OrderStatus::PICKED_UP->value, OrderStatus::DELIVERED->value, OrderStatus::CANCELLED->value];

        $ordersData = [];
        $orderItemsData = [];
        $now = now();

        for ($i = 1; $i <= 1200; $i++) {
            $orderId = $i;
            $ordersData[] = [
                'customer_id' => $customers->random()->id,
                'shop_id' => $shops->random()->id,
                'driver_id' => rand(0, 1) ? $drivers->random()->id : null,
                'status' => $statuses[array_rand($statuses)],
                'total_amount' => rand(5000, 100000) / 100,
                'created_at' => $now->copy()->subMinutes(rand(1, 10000)),
                'updated_at' => $now,
            ];

            // عناصر الطلب لكل طلب
            for ($j = 1; $j <= rand(1, 4); $j++) {
                $orderItemsData[] = [
                    'order_id' => $orderId,
                    'item_name' => "وجبة أو منتج رقم {$j}",
                    'quantity' => rand(1, 5),
                    'price' => rand(1000, 15000) / 100,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // إدخال على دفعات لتجنب الضغط على الذاكرة
            if ($i % 500 === 0) {
                Order::insert($ordersData);
                OrderItem::insert($orderItemsData);
                $ordersData = [];
                $orderItemsData = [];
            }
        }

        if (!empty($ordersData)) {
            Order::insert($ordersData);
            OrderItem::insert($orderItemsData);
        }
    }
}