<!DOCTYPE html>
<html style="height: auto; min-height: 100%;">
<head profile="http://www.w3.org/2005/10/profile">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base-url" content="{{url('/')}}">
  <title>Nevşehir ÖDM</title>
  <link rel="icon" type="image/png" href="{{asset("images/Logo.png")}}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="skin-blue-light fixed sidebar-mini" style="height: auto; min-height: 100%;">
<div id="app" class="wrapper" style="height: auto; min-height: 100%;">
</div><!-- ./wrapper -->
<script>
  window.Laravel = { csrfToken: '{{ csrf_token() }}' };
</script>
<script src="{{asset('js/manifest.js')}}"></script>
<script src="{{asset('js/vendor.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
</body>
</html>
