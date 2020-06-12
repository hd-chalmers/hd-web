@extends('layouts.base')

<?php
    /**
     * @var \App\Models\ActiveYear $active_year
     */
?>
@section('content')
    <div class="container bg-light">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <edit-committee-form :route="'{{route("committee.update", ['committee' => $active_year->id])}}'"
                             :active_year_prop="{{$active_year}}"></edit-committee-form>
    </div>
@endsection
