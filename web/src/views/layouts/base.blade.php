<!DOCTYPE html>
<html style="
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>H-Sektionens Datorförening</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>
</head>
<body>
<v-app id="app" style="background-image: url({{\App\Models\ActiveYear::getLatest()->background_image ? Storage::url(\App\Models\ActiveYear::getLatest()->background_image) : "/img/back5.jpg"}});
          background-repeat: no-repeat;
          background-position: center;
          background-attachment: fixed;
          background-size: cover ;">
        @yield('navbar', View::make('common.navbar'))
    @yield('loehk')
        <v-main>
            @yield('content')
        </v-main>
    <Chassit-Open-Icon></Chassit-Open-Icon>
    @yield('footer', View::make('common.footer'))
</v-app>
<script src="https://kit.fontawesome.com/458d5475f8.js" crossorigin="anonymous"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
