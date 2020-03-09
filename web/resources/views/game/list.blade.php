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
                                <a class="nav-link" href="{{route('games.create')}}">Nytt Spel</a>
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($platform->games->sortBy('name') as $game)
                                <tr>
                                    <td>
                                        {{$game->name}}
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
