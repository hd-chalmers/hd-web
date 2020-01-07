@extends('layouts.base')


@section('content')
    <?php $counter = 0; ?>
    <div class="container bg-light" style="flex: 1">
        <div class="row">
            <div class="col-12 text-center">
                <h1>HD {{(substr($active_year->year, 0, 4))}}/{{substr($active_year->year, 0, 4)+1}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                @if($active_year->group_photo !== '' && $active_year->group_photo !== NULL )
                    <img src="{{$active_year->group_photo}}">
                @else
                    <img src="/img/unknown_group.png" alt="unknown_group"
                         class="rounded mx-auto d-block">
                @endif
                {{$active_year->description}}
            </div>
        </div>
        @foreach($active_year->committee_members as $member)
            @if(!($counter % 2))
                <div class="row mb-3">
                    @endif
                    <div class="col-md-6 col-12">
                        @if($member->image_data !== NULL)
                            <img src="{{$member->img_data}}">
                        @else
                            <img src="/img/unknown_profile.png" alt="unknown_profile" height="200px"
                                 class="rounded mx-auto d-block">
                        @endif
                        <div class="row">
                            <div class="col-12 text-center">
                                <h3>{{$member->name}}</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{$member->description}}<br/><br/>
                                @if($member->favourite_game !== '')
                                    <span class="font-weight-bold">Favorit Spel: </span>{{$member->favourite_game}}<br/>
                                @endif
                                @if($member->favourite_sugar !== '')
                                    <span class="font-weight-bold">Favorit Socker: </span>{{$member->favourite_sugar}}
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(($counter % 2))
                </div>
            @endif
            <?php $counter++; ?>
        @endforeach
        @if(($counter % 2))
    </div>
    @endif
    </div>

@endsection
