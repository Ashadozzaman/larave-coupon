<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Coupon</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        @if (Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
        <form action="{{ route('coupon.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="">Course</label>
                    <select class="form-control" name="course_id" required>
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="">Coupon Type</label>
                    <select class="form-control" name="coupon_type" required>
                        <option value="">Select Type</option>
                            <option value="1">Fixed Price</option>
                            <option value="2">Percentage</option>
                    </select>
                    @error('coupon_type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="">Coupon Rate</label>
                    <input class="form-control" type="number" name="coupon_rate" value="{{ old('coupon_rate') }}"
                        placeholder="Enter rate">
                        @error('coupon_rate')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                </div>
                <div class="col-md-6">
                    <label for="">Title</label>
                    <input class="form-control" type="text" name="title" value="{{ old('title') }}"
                        placeholder="Enter title">
                </div>
                <div class="col-md-6">
                    <label for="">Start Date</label>
                    <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}"
                        placeholder="select start date" required>
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="">Expire Date</label>
                    <input class="form-control" type="date" name="expire_date" value="{{ old('expire_date') }}"
                        placeholder="select expire date" required>
                        @error('expire_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <br>
            <button class="btn btn-primary" type="submit"> Save </button>
        </form>
    </div>
</body>

</html>
