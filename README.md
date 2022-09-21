Laravel Coupon 🎟<br>
This package generate coupon/discount for any kinds of course or product selling website...🎟

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ashadozzaman/coupon.svg?style=flat-square)](https://packagist.org/packages/ashadozzaman/coupon)
[![Total Downloads](https://img.shields.io/packagist/dt/ashadozzaman/coupon.svg?style=flat-square)](https://packagist.org/packages/ashadozzaman/coupon)
<br>
Here is an example of how you can create coupon them:
## Installation

You can install the package via composer:

```bash
composer require ashadozzaman/coupon
```
Now you should register CouponServiceProvider in config/app.php
```bash
'providers' => [
  Ashadozzaman\Coupon\CouponServiceProvider::class,
]
```
The package will automatically register itself.

You can publish the migration with below command, it's copy generate file config/coupon.php also crate folde views/vendor/coupon for create coupon, it you want you can change all file design. But don't cut form structure...

```bash
php artisan vendor:publish --provider="Ashadozzaman\Coupon\CouponServiceProvider"
```

config/coupon.php file show bellow. here you set you necessary information
```bash
<?php
return [
    //this table/model use for single coupon generate, like Product/products, Course/courses
    'coupon_for_single_table' => App\Models\Course::class,


    //this table/model use for specific category coupon generate, like Product/products, Course/courses
    'coupon_for_category_table' => App\Models\Category::class,


    //money symbol
    'money_symbol' => '৳',


    //is_admin middleware define here
    //'is_admin' => \App\Http\Middleware\IsAdmin::class, example default action this

    'IsAdmin' => 'is_admin',

];
```

After the migration has been published you can create the vouchers table by running the migrations:

```bash
php artisan migrate
```

