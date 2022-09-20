<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coupon List</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
            padding: 8px;
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container" style="margin-top: 10px;">
        <a class="btn btn-primary" href="{{ route('coupon.create') }}">Add Coupon</a>
        <table border="2"  style="margin-top: 10px;">
            <tr>
                <th>SL</th>
                <th>Course</th>
                <th>Code</th>
                <th>Coupon Type</th>
                <th>Coupon Rate</th>
                <th>Start Date</th>
                <th>Expire Date</th>
                <th>Remaining Days</th>
                <th>Action</th>
            </tr>
            @foreach ($coupons as $key => $coupon)
            <tr>
                <td>{{$key +1}}</td>
                <td>{{$coupon->course->name}}</td>
                <td>{{$coupon->code}}</td>
                <td>{{$coupon->type}}</td>
                <td>{{$coupon->coupon_rate}} {{$coupon->rate_symbol}}</td>
                <td>{{$coupon->start_date}}</td>
                <td>{{$coupon->expire_date}}</td>
                <td>{{$coupon->remaining_date}}</td>
                <td>
                    <div style="display: flex;">
                        <a href="{{route('coupon.edit',$coupon->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{route('coupon.destroy',$coupon->id)}}" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm">Delete</button>  
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
