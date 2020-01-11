<!DOCTYPE html>
<html style="height: auto; min-height: 100%;">
<head profile="http://www.w3.org/2005/10/profile">
  <title>Nevşehir ÖDM</title>
  <base href="{{ url('/') }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="base-url" content="{{ url('/') }}">
  <link rel="icon" type="image/png" href="{{asset('images/Logo.png')}}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.2.95/css/materialdesignicons.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit&hl=tr" async defer>
  </script>
</head>
<body class="skin-blue-light fixed sidebar-mini" style="height: auto; min-height: 100%;">
<div id="app" class="wrapper" style="height: auto; min-height: 100%;">
</div><!-- ./wrapper -->
<script>
  window.Laravel = { csrfToken: '{{ csrf_token() }}' };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/tr.js" integrity="sha256-nVA6aRSQuRLGLSqtxE/RRKTymG1QwvyvvH5w8jORUwM=" crossorigin="anonymous"></script>
<script src="{{ asset('js/manifest.js') }}" type="application/javascript"></script>
<script src="{{ asset('js/vendor.js') }}" type="application/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="application/javascript"></script>
</body>
</html>
