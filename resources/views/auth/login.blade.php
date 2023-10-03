<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Custom Authentication</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>
<body>
<div class="container" >
        <div class="row col-md-4 col-md-offset-4 mt-8" style="margin-top:100px">
            <div class="col-md-8 col-md-offset-8" style="margin-top:20px" ></div>
            <h4 class="text-center">Login</h4>
            <hr>
            <form action="{{ route('login-action') }}" method="POST">
                @csrf
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                <!-- Phone input -->
                <div class="form-group mb-4">
                    <input type="tel"  class="form-control" name="phone" value="{{old('phone')}}"/>
                    <label class="form-label" for="form2Example1">Phone</label>
                    <span class="text-danger">@error('phone') {{$message}} @enderror</span>

                </div>

                <!-- Password input -->
                <div class="form-group mb-4">
                    <input type="password" name="password" class="form-control"  />
                    <label class="form-label" for="form2Example2">Password</label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                    <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                </div>
            </form>
        </div>
  </div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</html>
