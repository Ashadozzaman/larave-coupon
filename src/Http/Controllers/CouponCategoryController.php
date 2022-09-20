<?php

namespace Ashadozzaman\Coupon\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ashadozzaman\Coupon\Models\CouponCategory;
use Ashadozzaman\Coupon\Http\Traits\CouponGenerate;
use Illuminate\Support\Facades\Session;

class CouponCategoryController extends Controller
{
    use CouponGenerate;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['category_coupons'] = CouponCategory::where('status',1)->orderBy('id','desc')->get();
        return view('coupon::coupon-category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_course = config('coupon.coupon_for_category_table');
        $data['categories'] = $category_course::get();
        return view('coupon::coupon-category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'start_date' => 'required|before:expire_date',
            'expire_date' => 'required',
            'coupon_type' => 'required',
            'coupon_rate' => 'required',
        ]);
        $checkCategoryCoupon = CouponCategory::where('category_id',$request->category_id)->where('status',1)->where('expire_date','>=',date('Y-m-d'))->first();
        if(!empty($checkCategoryCoupon)){
            Session::flash('message', 'This course has already active coupon');
            return redirect()->route('coupon.create');
        }
        $data = $request->except('_token');
        $code = $this->generate();
        $data['code'] = $code;
        CouponCategory::create($data);
        return redirect()->route('coupon_category.index')->with('success','Coupon Generate Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_course = config('coupon.coupon_for_category_table');
        $data['categories'] = $category_course::get();
        $data['category_coupon'] = CouponCategory::findOrFail($id);
        return view('coupon::coupon-category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'start_date' => 'required|before:expire_date',
            'expire_date' => 'required',
            'coupon_type' => 'required',
            'coupon_rate' => 'required',
        ]);
        
        $checkCategoryCoupon = CouponCategory::where('category_id',$request->category_id)->where('id','!=',$id)->where('status',1)->where('expire_date','>=',date('Y-m-d'))->first();
        if(!empty($checkCategoryCoupon)){
            Session::flash('message', 'This category has already active coupon');
            return redirect()->back();
        } 

        $coupon = CouponCategory::findOrFail($id);
        $data = $request->except('_token','put');
        $coupon->update($data);
        return redirect()->route('coupon_category.index')->with('success','Category Coupon Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CouponCategory::findOrFail($id);
        CouponCategory::destroy($id);
        return redirect()->route('coupon_category.index')->with('success','Category Coupon Delete Successfully');
    }
}
