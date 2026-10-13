<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true); // لفلترة المحلات الموقوفة عبر Global Scope
            $table->timestamps();

            // Index للفلترة على حالة المحل
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};