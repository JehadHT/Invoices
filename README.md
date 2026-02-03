<link href="public/assets/css/styleReadMe.css" rel="stylesheet">

# أوامر Laravel
## تشغيل السيرفر
```bash
php artisan serve 
```

## إنشاء Controller
```bash
php artisan make:controller UserController
 ```

## إنشاء Model
```bash
php artisan make:model User
```

## إنشاء Model , Controller(Resource) , Table
```bash
php artisan make:model User -mcr
```
## إنشاء جدول flights
```bash
php artisan make:migration create_flights_table
```

## ترحيل الجداول 
```bash
php artisan migrate
```
## التراجع عن اخر migrate 
```bash
php artisan migrate:rollback
```

## لحذف الجداول وإعادة ترحيلها 
```bash
php artisan migrate:fresh
```
>في هذا الأمر يقوم بحذف جميع الجداول والبيانات الموجودة داخلها بلا استثناء
<hr>

##  لإنشاء seeder User
```bash
php artisan make:seeder UserSeeder
```

## لتنفيذ الseeder الاساسي 
```bash
php artisan db:seed
```

## لتنفيذ الseeder معين  
```bash
php artisan db:seed --class=UserSeeder
```

### [شرح اضافة Notifications](Notifications.md)

```bash
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
```
### [شرح اضافة Notifications](Notifications.md)

```bash
git clone repo-url
cd project
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

```

