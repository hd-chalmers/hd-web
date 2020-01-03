<!DOCTYPE html>
<html style="
        background-image: url('/img/WayaBG-Desktop.webp');
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
<body>
@yield('navbar', View::make('common.navbar'))
@yield('content')
@yield('footer', View::make('common.footer'))
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
