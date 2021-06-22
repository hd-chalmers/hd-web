@extends('errors.src.views.layouts.base')

@section('content')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100%;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
            font-family: 'Nunito', sans-serif;
        }

        .message {
            font-family: 'Nunito', sans-serif;
            font-size: 18px;
            text-align: center;
        }
    </style>
    <div class="flex-center position-ref full-height bg-light">
        <div class="code">
            @yield('code')
        </div>

        <div class="message" style="padding: 10px;">
            @yield('message')
        </div>
    </div>
@endsection
