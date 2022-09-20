<?php

namespace Ashadozzaman\Coupon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use HasFactory;
    protected $fillable =[
        'coupon_code','user_id','use_date'
    ];
}
