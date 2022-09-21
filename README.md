## Laravel Coupon 🎟<br>
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
## Usage
The basic concept of this package is that you can create coupon by admin for specific course/product and course/product category. For access this feature you declure your admin authentication middleware in <b>config/coupon.php</b> file like bellow:-

```bash
return [
     --------
     --------
    'IsAdmin' => 'is_admin', //you should replace your middleware to is_admin thanks
]
```
## Model Declare
You must be declare your coupon related items models like products/coures and categories table model example show bellow:-
```bash
<?php
return [
    //this table/model use for single coupon generate, like Product/products, Course/courses
    'coupon_for_single_table' => App\Models\Course::class,


    //this table/model use for specific category coupon generate, like Product/products, Course/courses
    'coupon_for_category_table' => App\Models\Category::class,
    
]
```
After complete middleware register. Now you able to access create coupon in you admin section. Now you just call two route for creating coupon. Two route show bellow:-

```bash
Route name: route(coupon.index), Route Url: /coupon <br>
Route name: route(coupon_category.index), Route Url: /coupon_category
//use example
<a href="{{route('coupon.index')}}">Coupon</a><br>
<a href="{{route('coupon_category.index')}}">Coupon Category</a>
```
## Admin coupon create process done here

## Use Coupon In Frontend

