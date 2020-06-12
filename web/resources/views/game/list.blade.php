@extends('layouts.base')


@section('content')
    <div class="container bg-light">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Våra Spel</h1>
            </div>
        </div>
        @if(\Illuminate\Support\Facades\Auth::check())
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="navbar navbar-light">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item active">
                                <h4><a href="{{route('games.create')}}"
                                       style="color: #555555; text-decoration: underline">Nytt
                                        Spel</a></h4>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
        @if(\Illuminate\Support\Facades\Auth::check()) <!-- if logged in -->
        <game-list :game_prop="{{$platforms}}"></game-list>
        @else
            @foreach($platforms as $platform)
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold">{{ucfirst($platform->name)}}</h4>
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th>
                                    Namn
                                </th>
                                <th class="d-none d-md-table-cell">
                                    År
                                </th>
                                <th>
                                    Antal Spelare
                                </th>
                                <th>
                                    Speltid
                                </th>
                                <th class="d-none d-md-table-cell">

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($platform->games->sortBy('name') as $game)
                                <tr>
                                    <td>
                                        <a style="color: black" href="{{route('games.show', $game->id)}}">{{$game->name}}</a>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        {{$game->published_year}}
                                    </td>
                                    <td>
                                        {{$game->min_players}}@if($game->min_players !== $game->max_players)
                                            -{{$game->max_players}} @endif
                                    </td>
                                    <td>
                                        {{$game->min_playtime}}@if($game->min_playtime !== $game->max_playtime)
                                            -{{$game->max_playtime}} @endif min
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <a href="{{route('games.show', $game->id)}}">Mer Info</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
