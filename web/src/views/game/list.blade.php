@extends('game.src.views.layouts.base')

@section('content')
        <Game-List>

        </Game-List>
@endsection
@section('autocomplete')
    <script>
        import GameList from "../../components/games/GameList";
        export default {
            components: {GameList}
        }
    </script>
@endsection
