# مشروع توصيلة (Tawselah API)

نظام خلفي (Backend API) متكامل لإدارة خدمات التوصيل والمتاجر، مبني باستخدام إطار العمل Laravel 11 ومطبق عليه معمارية Clean Architecture لضمان فصل المسؤوليات وقابلية التوسع والصيانة العالية.

## Features

- **Shop Management** — إنشاء وإدارة المتاجر مع تطبيق نطاقات البحث لجلب المتاجر النشطة فقط.
- **Order Management** — إنشاء، وتحديث، وإدارة طلبات العملاء عبر طبقات الخدمات.
- **Driver Assignment** — خدمة مخصصة لتعيين وإدارة السائقين وتوزيعهم على الطلبات.
- **Dynamic Delivery Pricing** — حساب تكلفة التوصيل باستخدام استراتيجيات مرنة (سريعة وقياسية) وتوظيف نمط المصنع (Factory & Strategy Patterns).
- **Domain Exceptions** — معالجة الأخطاء بنظام استثناءات نطاق مخصصة (BaseDomainException, InactiveEntityException).
- **Database Triggers** — إدارة ومزامنة حالات الطلبات تلقائياً على مستوى قاعدة البيانات.

## End Points

- `POST /api/orders`
```json
{
    "shop_id": 1,
    "customer_name": "Asma",
    "customer_phone": "0999999999",
    "delivery_type": "express",
    "items_count": 3
}
```

- `POST /api/orders/{order}/status`
```json
{
    "status": "processing"
}
```

- `GET /api/shops/active`
*body: none*

- `POST /api/drivers/assign`
```json
{
    "order_id": 1,
    "driver_id": 5
}
```

## Price Strategy
The project uses the Strategy Pattern to calculate delivery prices based on the delivery type (express or standard), managed through a dedicated factory.

## Dependency Injection
The project uses Laravel's Service Container to bind service interfaces to their implementations.

## Error Handling
API exceptions are handled in bootstrap/app.php using Laravel's withExceptions, with custom exception classes for specific errors and consistent JSON responses via the ApiResponse trait.

## Project Structure

```text
app/
├── Enums/                  # الثوابت المحددة (مثل OrderStatus)
├── Exceptions/             # استثناءات النظام المخصصة (BaseDomainException, InactiveEntityException)
├── Http/
│   └── Controllers/Api/    # متحكمات الـ API (OrderController, AdminReportController)
├── Models/                 # نماذج قاعدة البيانات ونطاقات الاستعلام (Shop, Order, ActiveShopScope)
├── Providers/              # مزودات الخدمة
├── Services/               # منطق الأعمال الأساسي
│   ├── Contracts/          # واجهات الخدمات (Interfaces)
│   └── Price/              # حزمة استراتيجيات ومصنع التسعير (Factory & Strategies)
└── Traits/                 # الخصائص المشتركة (ApiResponse لتوحيد هيكل JSON)

database/
├── migrations/             # جداول قاعدة البيانات ومشغلات الـ Triggers (مثل create_order_status_trigger)
└── seeders/                # بيانات التهيئة الأولية

routes/
└── api.php                 # مسارات الـ API بالنظام