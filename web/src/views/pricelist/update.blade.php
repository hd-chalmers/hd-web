@extends('pricelist.src.views.layouts.base')

@section('content')
    <update-product :categories="{{$categories}}" :product_prop="{{$product}}"></update-product>
@endsection
