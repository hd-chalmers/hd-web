@extends('layouts.base')


@section('content')
    <?php $counter = 0; ?>
    <div class="container bg-light">
        <div class="row">
            <div class="col-12 text-center">
                <h1>HD {{($active_year->year)}}/{{$active_year->year+1}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                @if($active_year->group_photo !== '' && $active_year->group_photo !== NULL )
                    <img src="{{$active_year->group_photo}}">
                @else
                    <img src="/img/unknown_group.png" alt="unknown_group"
                         class="rounded mx-auto d-block img-fluid">
                @endif
                {{$active_year->description}}
            </div>
        </div>
        @foreach($active_year->committee_members as $member)
            @if(!($counter % 2))
                <div class="row mb-3">
                    @endif
                    <div class="col-lg-6 col-12">
                        @if($member->image_data !== NULL)
                            <img src="{{$member->img_data}}">
                        @else
                            <img src="/img/unknown_profile.png" alt="unknown_profile" style="max-height: 200px"
                                 class="rounded mx-auto d-block  img-fluid">
                        @endif
                        <div class="row">
                            <div class="col-12 text-center">
                                <h3>{{$member->name}}</h3>
                                <div class="text-muted font-weight-bold">{{ucfirst($member->role)}}</div>
                            </div>
                        </div>
                        @if($member->quote !== '' && $member->quote !== NULL)
                            <div class="row small">
                                <div class="col-12 text-center">
                                    <span class="text-muted">"{{$member->quote}}"</span>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                {{$member->description}}<br/><br/>
                                @if($member->favourite_game !== '' && $member->favourite_game !== NULL)
                                    <div class="row">
                                        <div class="col-12">
                                            <span
                                                class="font-weight-bold">Favorit Spel: </span>{{$member->favourite_game}}
                                        </div>
                                    </div>
                                @endif
                                @if($member->favourite_sugar !== '' && $member->favourite_sugar !== NULL)
                                    <div class="row">
                                        <div class="col-12">
                                        <span
                                            class="font-weight-bold">Favorit Socker: </span>{{$member->favourite_sugar}}
                                        </div>
                                    </div>
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
