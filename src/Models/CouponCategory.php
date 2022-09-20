<?php

namespace Ashadozzaman\Coupon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'code',
        'start_date',
        'expire_date',
        'coupon_type',
        'coupon_rate',
        'title',
        'status'
    ];

    public function category(){
        $course = config('coupon.coupon_for_category_table');
        return $this->belongsTo($course,'category_id','id');
    }

    public function getRemainingDateAttribute() {
        $value = ((strtotime($this->expire_date) - strtotime($this->start_date))/86400);
        $day  = ($value > 1)?" Days":" Day";
        return ($value > 0)?$value.$day : '0'. $day;
    }
    public function getTypeAttribute() {
        $type = $this->coupon_type;
        return ($type == 1)?'Fixed Price':'Percentage';
    }
    public function getRateSymbolAttribute() {
        $type = $this->coupon_type;
        return ($type == 1)?config('coupon.money_symbol'):'%';
    }
}
