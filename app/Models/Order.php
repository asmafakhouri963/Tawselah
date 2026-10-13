<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'shop_id',
        'driver_id',
        'status',
        'total_amount',
        'picked_up_at',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'total_amount' => 'decimal:2',
        'picked_up_at' => 'datetime',
    ];

    // Relations
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // --- Local Scopes ---

    /**
     * الطلبات الفعّالة: التي لم يتم تسليمها ولم يتم إلغاؤها (تعريف مركزي مكان واحد لمنع تضارب الأرقام)
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            OrderStatus::DELIVERED->value,
            OrderStatus::CANCELLED->value,
        ]);
    }

    /**
     * طلبات سائق معين
     */
    public function scopeForDriver(Builder $query, int $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    /**
     * طلبات اليوم الحالي
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * الطلبات التي مضى عليها أكثر من نصف ساعة بدون سائق
     */
    public function scopePendingWithoutDriver(Builder $query, int $minutes = 30): Builder
    {
        return $query->whereNull('driver_id')
            ->where('status', OrderStatus::PENDING->value)
            ->where('created_at', '<=', now()->subMinutes($minutes));
    }
}