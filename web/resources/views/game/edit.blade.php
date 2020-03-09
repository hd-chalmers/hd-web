@extends('layouts.base')

@section('content')
    <div class="container bg-light" id="app">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Redigera Spel</h1>
            </div>
        </div>
        <edit-game-form :game="{{$game}}" :platforms="{{json_encode($platforms)}}"></edit-game-form>
    </div>
@endsection
