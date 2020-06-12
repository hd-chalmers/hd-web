<!DOCTYPE html>
<html style="
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>H-Sektionens Datorförening</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>
</head>
<body style="display: flex; min-height: 100vh; flex-direction: column; background-image: url('/img/back5.jpg');
          background-color: rgb(209, 230, 255);
          background-repeat: no-repeat;
          background-position: center;
          background-attachment: fixed;
          background-size: cover ;">
<div style="flex: 1" id="app">
@yield('navbar', View::make('common.navbar'))
    <vue-snotify></vue-snotify>
@yield('content')
</div>
@yield('footer', View::make('common.footer'))
<script src="https://kit.fontawesome.com/458d5475f8.js" crossorigin="anonymous"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
