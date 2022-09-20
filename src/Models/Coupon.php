<?php

namespace Ashadozzaman\Coupon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use HasFactory;
    public $remaining;
    protected $fillable = [
        'course_id',
        'code',
        'start_date',
        'expire_date',
        'coupon_type',
        'coupon_rate',
        'title',
        'status'
    ];

    public function course(){
        $course = config('coupon.coupon_for_single_table');
        return $this->belongsTo($course,'course_id','id');
    }

    public function getRemainingDateAttribute() {
        $start_date = strtotime($this->start_date);
        $current_date = strtotime(date('Y-m-d'));
        if($start_date > $current_date){
            $date = $start_date;
        }else{
            $date = $current_date;
        }
        $value = ((strtotime($this->expire_date) - $date)/86400);
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
