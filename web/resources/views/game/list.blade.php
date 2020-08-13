@extends('layouts.base')

@section('content')
        <Game-List>

        </Game-List>
@endsection
@section('autocomplete')
    <script>
        import GameList from "../../js/components/games/GameList";
        export default {
            components: {GameList}
        }
    </script>
@endsection
