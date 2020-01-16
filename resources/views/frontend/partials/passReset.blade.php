<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
    <title>গ্রন্থিক</title>
</head>
<body>
    <div class="container" style="margin-top:5%;">
        <div class="row">
            <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
                <br><br>
                <form action="{{ route('user.passwordreset') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <input type="hidden"  name="email" value="{{$email}}">   
                    <input type="hidden"  name="token" value="{{$code}}">                                  
                    <div class="form-group">
                      <label for="name">New password</label>
                      <input type="password" class="form-control" name="password" aria-describedby="emailHelp" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="name">Confirm password</label>
                        <input type="password" class="form-control" name="c_password" aria-describedby="emailHelp" placeholder="Confirm your password">
                      </div>
                    <button type="submit" class="btn btn-success">Update Password</button>
                  </form>
            </div>
        </div>
    </div>
</body>
</html>