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

## Use Coupon In Frontend 🎟

Coupon use basically in your checkout page. So you just use coupon easily in checkout page with same route. Show example bellow code:-

## route/web.php  (<small>It's only example, you write code in your own way</small>)
```bash
Route::match(array('GET', 'POST'), 'checkout/{id?}', [HomeController::class,'checkout_course'])->name('checkout.course');
```
## Http/Controllers/HomeController.php  (<small>It's only example, you write code in your own way</small>)
In controller must be use bellow Trait:-
```bash

use Ashadozzaman\Coupon\Http\Traits\CouponGenerate;
class HomeController extends Controller
{
    use CouponGenerate;
    --
    --
    --
 }
```
This function is work in my side. It's show for example perpose.
```bash
public function checkout_course(Request $request,$id = null){
    $data['course'] = Course::findOrFail($id);
    $course = Course::findOrFail($id);
    if($request->coupon){
        $coupon = $request->coupon;
        $item = $id;
        $item_category = $course->category->id;
        $customer_id = auth()->user->id; //user, student, customer //login user

        //must be call with 4 perameter 1.coupon 2. coupon item id(course) 3.item category id 4.Customer id
        $response = $this->checkCoupunStatus($coupon,$item,$item_category,$customer_id);
        if($response['status'] == "error"){
            Session::flash('message',$response['message']);
            return redirect()->back();
        }else{
            $data['coupon'] = $response;
        }

    }
    return view('checkout',$data);

}
```
Using this trait function check coupon status, for use coupon time. Must be pass necesary all perameter. This function return response in array.
In array pass two type status 1. success 2. error.
```bash
//must be call with 4 perameter 1.coupon 2. coupon item id(course) 3.item category id 4.Customer id //login user
$response = $this->checkCoupunStatus($coupon,$item,$item_category,$customer_id);
```
Response example bellow show:-
```bash
//error
array:2 [▼
  "status" => "error"
  "message" => "This coupon is not vaild for this product"
]
//success
array:6 [▼
  "status" => "success"
  "price" => 65.0
  "final_price" => 55.0
  "rate" => 10
  "coupon" => "O4BY-TSKO"
  "type" => "৳"
]
```

## checkout.blade.php (<small>It's only example, you write code in your own way</small>)
```bash
<section>
  <h3><u> Course</u></h3>
  @if (Session::has('message'))
      <p class="alert alert-info">{{ Session::get('message') }}</p>
  @endif
  <div class="row">
      <div class="col-md-6">
          <form action="{{ route('submit.checkout') }}" method="post">
              @csrf
              <label for="">Name : {{ $course->name }}</label><br>
              <input type="hidden" name="course_id" value="{{$course->id}}">
              <label for="">Price : {{ $course->amount }}</label><br>
              <hr>
              @if (isset($coupon))
                  <label for="">Discount: - {{ $coupon['rate'] }} {{ $coupon['type'] }}</label><br>
                  <label for="">Final Price</label>
                  <input class="form-control" type="text" name="price"
                      value="{{ $coupon['final_price'] }}" readonly>
                  <label for="">Use Coupon</label>
                  <input class="form-control" type="text" name="coupon" value="{{ $coupon['coupon'] }}" readonly>
              @else
                  <label for="">Final Price</label><br>
                  <input class="form-control" type="text" name="price" value="{{ $course->amount }}"
                      readonly>
              @endif
              <button class="btn btn-success" type="submit">Checkout</button>
          </form>
      </div>
      <div class="col-md-6">
          <form action="{{ route('checkout.course', $course->id) }}" method="post">
              @csrf
              <label for="">Use Coupon</label>
              <input type="text" name="coupon" class="form-control" placeholder="Enter coupon">
              <button class="btn btn-primary btn-sm">Use Coupon</button>
          </form>
      </div>
  </div>
</section>
```
After use coupon, when you submit checkout form that's mean when you save checkout details. You must be call bellow trail function:-
```bash
//must be pass 2 perameter customer_id(login user id),coupon_code;
$response = $this->useCouponByUser($data['customer_id'],$request->coupon);
```
Using this function store coupon used user and coupon code. So must be call this after save checkout details. Bellow show details example:-
```bash
 public function checkout_submit(Request $request){
      $data['customer_id'] = auth()->user->id;//login user id
      $data['course_id'] = $request->course_id; // course/product
      $data['price'] = $request->price;
      $booking = Booking::create($data);
      if(isset($booking)){
          if($request->coupon){
              //must be pass 2 perameter customer_id(login user id),coupon_code;
              $response = $this->useCouponByUser($data['customer_id'],$request->coupon);
          }
      }
  }
```
Respone example show bellow:-
```bash
$data = [
    'status' => 'success',
    'message'  => 'Coupon use successfully',
];
```

# Support
For any query please send email to shovoua@gmail.com

