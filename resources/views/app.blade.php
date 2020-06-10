<!DOCTYPE html>
<html lang="tr" style="height: auto; min-height: 100%;" >
<head>
  <title>{{$city}} ÖDM</title>
  <base href="{{ url('/') }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base-url" content="{{ url('/') }}">
  <link rel="icon" type="image/png" href="{{asset('images/Logo.png')}}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
  <script src="https://kit.fontawesome.com/f0acb77160.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit&hl=tr" async defer>
  </script>
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed"
      style="height: auto;">
  <div id="app" class="wrapper" style="height: auto; min-height: 100%;">
</div><!-- ./wrapper -->
<script>
  window.Laravel = { csrfToken: '{{ csrf_token() }}' };
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/tr.js" integrity="sha256-nVA6aRSQuRLGLSqtxE/RRKTymG1QwvyvvH5w8jORUwM=" crossorigin="anonymous"></script>
<script src="{{ asset('js/manifest.js') }}" type="application/javascript"></script>
<script src="{{ asset('js/vendor.js') }}" type="application/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="application/javascript"></script>
</body>
</html>
