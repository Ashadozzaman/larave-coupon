<?php

namespace Ashadozzaman\Coupon\Http\Traits;

use Ashadozzaman\Coupon\Models\Coupon;
use Ashadozzaman\Coupon\Models\CouponCategory;
use Ashadozzaman\Coupon\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

trait CouponGenerate
{

    protected $characters;
    protected $mask;
    protected $prefix;
    protected $suffix;
    protected $separator = '-';
    public function __construct(string $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ234567890', string $mask = '****-****')
    {
        $this->characters = $characters;
        $this->mask = $mask;
    }


    public function generate(): string
    {
        $length = substr_count($this->mask, '*');

        $code = $this->getPrefix();
        $mask = $this->mask;
        $characters = collect(str_split($this->characters));

        for ($i = 0; $i < $length; $i++) {
            $mask = Str::replaceFirst('*', $characters->random(1)->first(), $mask);
        }

        $code .= $mask;
        $code .= $this->getSuffix();

        return $code;
    }


    protected function getPrefix(): string
    {
        return $this->prefix !== null ? $this->prefix . $this->separator : '';
    }
    /**
     * @return string
     */
    protected function getSuffix(): string
    {
        return $this->suffix !== null ? $this->separator . $this->suffix : '';
    }

    public function checkCoupunStatus($coupon_code, $item, $item_category, $customer_id)
    {
        $coupon = Coupon::where('code', $coupon_code)->where('status', 1)->where('course_id', $item)
            ->where('start_date', '<=', Carbon::now())
            ->where('expire_date', '>=', Carbon::now())
            ->first();
        $coupon_category = CouponCategory::where('code', $coupon_code)->where('status', 1)->where('category_id', $item_category)
            ->where('start_date', '<=', Carbon::now())
            ->where('expire_date', '>=', Carbon::now())
            ->first();
        if (!empty($coupon)) {
            $coupon = $coupon;
        } elseif (!empty($coupon_category)) {
            $coupon = $coupon_category;
        } else {
            $data = [
                'status' => 'error',
                'message' => 'This coupon is not vaild for this product',
            ];
            return $data;
        }
        if (isset($coupon) && !empty($coupon)) {
            $useCheckCoupon = UserCoupon::where('coupon_code', $coupon->code)->where('user_id', $customer_id)->first();
            if (!empty($useCheckCoupon)) {
                $data = [
                    'status' => 'error',
                    'message' => 'You already use this coupon',
                ];
                return $data;
            } 
        }

        if (isset($coupon) && !empty($coupon)) {
            $model = config('coupon.coupon_for_single_table');
            $course = $model::where('id',$item)->first();
            if(isset($coupon)){
                $type = $coupon->coupon_type;
                $rate = $coupon->coupon_rate;
                if($type == 1){
                    return $this->calculateFixedPrice($type,$rate,$coupon->code,$course->amount);
                }elseif ($type == 2) {
                    return $this->calculatePercentagePrice($type,$rate,$coupon->code,$course->amount);
                }
            }
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Sorry!! something wrong...',
            ];
            return $data;
        }
    
    }

    public function calculateFixedPrice($type,$rate,$code,$amount){
        $final_price = $amount - $rate;
        $data = [
            'status'=> 'success',
            'price'=> $amount,
            'final_price' => ($final_price > 1)?$final_price:0,
            'rate' => $rate,
            'coupon' => $code,
            'type' => config('coupon.money_symbol'),
        ];
        return $data;
    }
    public function calculatePercentagePrice($type,$rate,$code,$amount){
        $discount       = ($amount * $rate)/100;
        $discount_price = $amount - $discount;
        $final_price    = number_format((float)$discount_price, 2, '.', '');
        $data = [
            'status' => 'success',
            'price'  => $amount,
            'final_price' => $final_price,
            'rate'   => $rate,
            'coupon' => $code,
            'type'   => '%',
        ];
        return $data;
    }


    public function useCouponByUser($userId,$coupon_code){
        $data['user_id'] = $userId;
        $data['coupon_code'] = $coupon_code;
        $data['use_date'] = date('Y-m-d');
        $useCheck = UserCoupon::where('user_id',$userId)->where('coupon_code')->first();
        if (isset($useCheck) && !empty($useCheck)) {
            $data = [
                'status' => 'error',
                'message'  => 'This user already use this coupon',
            ];
            return $data;
        }else{
            UserCoupon::create($data);
            $data = [
                'status' => 'success',
                'message'  => 'Coupon use successfully',
            ];
            return $data;
        }
    }

}
