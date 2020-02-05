<!DOCTYPE html>
<html style="height: auto; min-height: 100%;">
<head profile="http://www.w3.org/2005/10/profile">
    <title>{{$city}} ÖDM</title>
    <base href="{{url('/')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{asset('images/Logo.png')}}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.2.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition login-page" style="height: auto; min-height: 100%;">
<div id="app" class="wrapper" style="height: auto; min-height: 100%;">
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{$web_address}}"><b>{{$city}}</b>ÖDM</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">
                    Lütfen şifrenizi oluşturunuz.
                </p>
                <form method="post" role="form" action="{{action('Web\Auth\CustomPasswordResetController@reset')}}">
                    @csrf
                    <input type="hidden" value="{{$token}}" name="token">
                    <input type="hidden" value="{{$email}}" name="email">
                    <div class="form-group has-feedback @error('password') has-error @enderror">
                        <input name="password"
                                type="password"
                                class="form-control"
                                placeholder="Şifrenizi giriniz"
                        >
                        <span class="mdi mdi-textbox-password form-control-feedback"></span>
                        @error('password')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback @error('password_confirmation') has-error @enderror">
                        <input type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Şifrenizi tekrar giriniz">
                        <span class="mdi mdi-textbox-password form-control-feedback"></span>
                        @error('password_confirmation')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-xs-offset-4 col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                Oluştur
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
