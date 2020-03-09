@extends('layouts.base')

<?php
/**
 * @var \App\Models\Category $category
 */
?>

@section('content')
    <New-Product :categories="{{$categories}}"></New-Product>
@endsection
