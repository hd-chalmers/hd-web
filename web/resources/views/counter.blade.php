@extends('layouts.base')
<?php
/**
 * @var \App\Models\ActiveYear $active_year
 */
?>

@section('content')
    <counter :counter="{{$counter}}"></counter>
@endsection
