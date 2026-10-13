<?php

namespace App\Models;

use App\Models\Scopes\ActiveShopScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([ActiveShopScope::class])]
class Shop extends Model
{
    protected $fillable = ['name', 'is_active'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}