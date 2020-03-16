@extends('layouts.base')

<?php
/**
 * @var \App\Models\Category $category
 * @var \App\Models\Product  $product
 */
?>

@section('content')
        @php
            $counter = 0;
        @endphp
        <div class="container bg-light">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Prislista</h1>
                </div>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-6 {{(count($categories) > 2) ? 'col-lg-4' : ''}} col-sm-12">
                        <h4 class="font-weight-bold">{{ucfirst($category->name)}}</h4>
                        <table class="table table-sm table-hover">
                            <caption hidden>{{ucfirst($category->name)}}</caption>
                            <thead>
                            <tr>
                                <th id="{{$category->name}}-name-header">
                                    Namn
                                </th>
                                <th class="text-right" id="{{$category->name}}-price-header">
                                    Pris
                                </th>
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category->products as $product)
                                <tr>
                                    <td>
                                        {{ucfirst($product->name)}}
                                    </td>
                                    <td class="text-right">
                                        {{$product->price/100}} Kr
                                    </td>
                                    <template>
                                        @if(\Illuminate\Support\Facades\Auth::check())
                                            <list-product product_id="{{$product->id}}"
                                                          base_url="{{route('products.index')}}"
                                                          product_name="{{$product->name}}"></list-product>
                                        @endif
                                    </template>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
@endsection
