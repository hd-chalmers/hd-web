@php
    /** @var \Illuminate\Database\Eloquent\Collection $categories */
    /** @var \App\Models\Category $category */
    $sum = 0;
    foreach ($categories as $category) {
        $sum += count($category->products);
    }
    $sum += count($categories);

    if ($temp = ($sum / 53 <= 1)) {
        $class = 'col-12';
    } else if ($temp <= 2) {
        $class = 'col-6';
    } else if ($temp <= 3) {
        $class = 'col-4';
    } else {
        $class = 'col-3';
    }
    $class = 'col-3';
    $count = 0;
    $countCol = 0;
@endphp
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>H-Sektionens Datorförening</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}"/>
</head>
<body>
<style>
    @page {
        size: A4;
        margin: 5px;
    }

    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
        }
    }
</style>
@foreach($categories as $category)
    @if($count === 0)
        <table>
            @endif
            <tr>
                <td colspan="2">
                    <strong>{{$category->name}}</strong>
                    @php
                        $count++;
                    @endphp
                </td>
            </tr>
            @if($count === 47)
        </table>
        @php
            $count = 0;
        @endphp
    @endif
    @foreach($category->products as $product)
        @if($count === 0)
            <table>
                @endif
                <tr>
                    <td>
                        {{$product->name}}
                        @php
                            $count++;
                        @endphp
                    </td>
                    <td>
                        {{$product->price/100}}:-
                    </td>
                </tr>
                @if($count === 47)
            </table>
            @php
                $count = 0;
            @endphp
        @endif
    @endforeach
@endforeach
</body>
</html>
