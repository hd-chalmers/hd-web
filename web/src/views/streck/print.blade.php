<?php
/** @var \App\Models\User[] $users */
?><!DOCTYPE html>
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
    <title>Investeringslista Användare</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>
    <style>
        body {
            width: 210mm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }
        }
    </style>
</head>
<body>

<v-app id="app" class="page">
    <print-view :users="{{\GuzzleHttp\json_encode($users)}}" :inactive="{{\GuzzleHttp\json_encode($inactive)}}" :last="{{\GuzzleHttp\json_encode($last)}}">

    </print-view>
</v-app>
<script src="https://kit.fontawesome.com/458d5475f8.js" crossorigin="anonymous"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
