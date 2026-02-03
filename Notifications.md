# Notifications

## 1. توليد الإشعارات 
يتم تنفيذ هذا الأمر في `Terminal` لتوليد الملف `InvoicePaid` داخل `app\Notifications`
```bash
php artisan make:notification InvoicePaid
```

## 2. لإرسال الإشعارات عبر الإيميل 
### 1. قم بوضع هذا الكود داخل InvoicePaid الذي انشأته
[الكود هنا](Code.md#كود-InvoicePaid)

### 2. قم بتضمين هذا السطر داخل صف ال `model`

```bash
class User extends Authenticatable
{
    use Notifiable; // هذا السطر المراد تضمينه
}
```
## 3. إرسال إشعار عند إنشاء فاتورة جديدة

قم بإضافة الكود التالي في **`Controller`** الذي ترغب في إرسال إشعار عند تنفيذ أحد الأحداث فيه.

حيث أن `$invoice_id` هو معرف الفاتورة التي تم إنشاؤها.
```php
$user = User::first();
Notification::send($user, new InvoicePaid($invoice_id));
```


# 4. إرسال الإشعارات عبر `DB`

## 1. قم بإنشاء جدول الإشعارات الخاص 

```bash
php artisan notifications:table
php artisan migrate
```
## 2. قم بهذه الخطوة [هنا](#2-قم-بتضمين-هذا-السطر-داخل-صف-ال-model)
## 3.ومن ثم قم إنشاء ال `Class`
```bash
php artisan make:notification OrderCreated
```
وقم بوضع هذا الكود داخله [هنا](Code.md#كود-ordercreated)


## 4. إرسال إشعار عند إنشاء فاتورة جديدة

قم بإضافة الكود التالي في **`Controller`** الذي ترغب في إرسال إشعار عند تنفيذ أحد الأحداث فيه.

حيث أن `$invoice_id` هو معرف الفاتورة التي تم إنشاؤها.
```php
$user = User::first();
Notification::send($user, new InvoicePaid($invoice_id));
```



