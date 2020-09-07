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
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.2.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition login-page" style="height: auto; min-height: 100%;">
<div id="app" class="wrapper" style="height: auto; min-height: 100%;">
    <div class="hold-transition login-page">
        <div class="login-box mt-4">
            <div class="login-logo">
                <a href="{{$web_address}}"><b>{{$city}}</b>ÖDM</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <div class="login-box-body">
                        <p class="login-box-msg">
                            Lütfen şifrenizi oluşturunuz.
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" role="form"
                                      action="{{action('Web\Auth\CustomPasswordResetController@reset')}}">
                                    @csrf
                                    <input type="hidden" value="{{$token}}" name="token">
                                    <input type="hidden" value="{{$email}}" name="email">
                                    <div class="input-group mb-3">
                                        <input name="password"
                                               type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Şifrenizi giriniz"
                                        >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="mdi mdi-textbox-password form-control-feedback"></span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="Şifrenizi tekrar giriniz">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="mdi mdi-textbox-password form-control-feedback"></span>
                                            </div>
                                        </div>
                                        @error('password_confirmation')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                Oluştur
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="nav flex-column">
                                            @foreach ($errors->all() as $error)
                                                <li class="nav-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
