# LARAVEL 後臺管理系統

前端頁面可使用 [react-boilerplate](https://github.com/fantasy9830/react-boilerplate) 搭配

# Installation
## Composer
```bash
composer install
```

## Recovery .env
```bash
cp .env.example .env
php artisan key:generate
```

## Migrate
```bash
php artisan migrate
```

## Seeder
假資料
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

# Features

* [x] CORS
* [x] 登入認證功能(JWT)
* [x] 權限管理(laravel-permission)
* [x] Repository and Services Pattern
* [x] Laravel Modules
* [ ] ...