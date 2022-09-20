<?php

use Ashadozzaman\Coupon\Http\Controllers\CouponCategoryController;
use Ashadozzaman\Coupon\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;

    Route::get('/couponsss', function () {
        return config('coupon.is_admin');
    });

    Route::group(['namespeace'=> 'Ashadozzaman\Coupon\Http\Controllers','middleware' => ['web',config('coupon.IsAdmin')]],function(){
        Route::resource('coupon', CouponController::class);
        Route::resource('coupon_category', CouponCategoryController::class);
    })
?>