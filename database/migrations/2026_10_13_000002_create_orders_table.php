<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default(OrderStatus::PENDING->value);
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamps();

            // Indexes متطلبات الأداء والفلترة والترتيب
            $table->index('status'); // للبحث عن الطلبات الفعّالة والحالية
            $table->index('driver_id'); // لطلبات سائق معين
            $table->index(['shop_id', 'status']); // استعلامات المحل وحالات طلباته
            $table->index('created_at'); // لترتيب الطلبات من الأقدم للأحدث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};