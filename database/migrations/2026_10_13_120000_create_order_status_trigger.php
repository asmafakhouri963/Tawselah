<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // تريغر على مستوى قاعدة البيانات لضمان سلامة وتوافق الحالات والتواريخ 
        DB::unprepared('
            CREATE TRIGGER check_order_status_update BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                -- مثال: إذا تم تسليم الطلب، يجب تسجيل وقت الاستلام أو التحقق من صحة الحالة
                IF NEW.status = "delivered" AND OLD.status = "cancelled" THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "لا يمكن تحويل الطلب الملغى إلى مسلّم";
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS check_order_status_update');
    }
};