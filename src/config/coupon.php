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