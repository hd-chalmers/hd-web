@extends('layouts.base')

<?php
/**
 * @var \App\Models\Category $category
 */
?>

@section('content')
    <new-product :categories="{{$categories}}"></new-product>
@endsection
