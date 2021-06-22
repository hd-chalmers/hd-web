@extends('game.src.views.layouts.base')

@section('content')
    <div class="container bg-light py-1">
        <create-game :platforms="{{$platforms}}"></create-game>
    </div>
@endsection
