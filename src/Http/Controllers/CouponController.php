<?php

namespace Ashadozzaman\Coupon\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ashadozzaman\Coupon\Models\Coupon;
use Ashadozzaman\Coupon\Http\Traits\CouponGenerate;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    use CouponGenerate;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['coupons'] = Coupon::where('status',1)->orderBy('id','desc')->get();
        // dd($data);
        return view('coupon::coupon.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = config('coupon.coupon_for_single_table');
        $data['courses'] = $course::get();
        return view('coupon::coupon.create', $data);
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
            'course_id' => 'required',
            'start_date' => 'required|before:expire_date',
            'expire_date' => 'required',
            'coupon_type' => 'required',
            'coupon_rate' => 'required',
        ]);
        $checkCourse = Coupon::where('course_id',$request->course_id)->where('status',1)->where('expire_date','>=',date('Y-m-d'))->first();
        if(!empty($checkCourse)){
            Session::flash('message', 'This course has already active coupon');
            return redirect()->route('coupon.create');
        }
        $data = $request->except('_token');
        $code = $this->generate();
        $data['code'] = $code;
        Coupon::create($data);
        return redirect()->route('coupon.index')->with('success','Coupon Generate Successfull');
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
        $course = config('coupon.coupon_for_single_table');
        $data['courses'] = $course::get();
        $data['coupon'] = Coupon::findOrFail($id);
        return view('coupon::coupon.edit', $data);
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
            'course_id' => 'required',
            'start_date' => 'required|before:expire_date',
            'expire_date' => 'required',
            'coupon_type' => 'required',
            'coupon_rate' => 'required',
        ]);
        
        $checkCourse = Coupon::where('course_id',$request->course_id)->where('id','!=',$id)->where('status',1)->where('expire_date','>=',date('Y-m-d'))->first();
        if(!empty($checkCourse)){
            Session::flash('message', 'This course has already active coupon');
            return redirect()->back();
        } 

        $coupon = Coupon::findOrFail($id);
        $data = $request->except('_token','put');
        $coupon->update($data);
        return redirect()->route('coupon.index')->with('success','Coupon Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Coupon::findOrFail($id);
        Coupon::destroy($id);
        return redirect()->route('coupon.index')->with('success','Coupon Delete Successfull');
    }
}
