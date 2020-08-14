@extends('layouts.base')
<?php
/**
 * @var \App\Models\ActiveYear $active_year
 */
?>

@section('content')
    <?php $counter = 0; ?>
    <v-container>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <h1>HD {{($active_year->year)}}/{{$active_year->year+1}}</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-img src="{{$active_year->group_photo ? Storage::url($active_year->group_photo) : '/img/unknown_group.png'}}" class="mx-auto" max-height="400px" contain></v-img>
                        {{$active_year->description}}
                    </v-col>
                </v-row>
                <v-row class="mb-3 text-center">
                    @foreach($active_year->committee_members as $member)
                        <v-col cols="12" md="6" lg="4" xl="3">
                            <v-img src="{{$member->image ? Storage::url($member->image) : "/img/unknown_profile.png"}}" class="mx-auto" max-height="200px" contain></v-img>
                            <v-row>
                                <v-col cols="12" class="text-center">
                                    <h3>{{$member->name}}</h3>
                                    <div class="subtitle-1 font-weight-bold">{{ucfirst($member->role)}}</div>
                                </v-col>
                            </v-row>
                            @if($member->quote)
                                <v-row>
                                    <v-col cols="12" class="text-center">
                                        <span class="subtitle-2">"{{$member->quote}}"</span>
                                    </v-col>
                                </v-row>
                            @endif
                            <v-row>
                                <v-col cols="12">
                                    {{$member->description}}<br/><br/>
                                    @if($member->favourite_game)
                                        <v-row>
                                            <v-col cols="12">
                                            <span
                                                class="font-weight-bold">Favorit Spel: </span>{{$member->favourite_game}}
                                            </v-col>
                                        </v-row>
                                    @endif
                                    @if($member->favourite_sugar)
                                        <v-row>
                                            <v-col cols="12">
                                        <span
                                            class="font-weight-bold">Favorit Socker: </span>{{$member->favourite_sugar}}
                                            </v-col>
                                        </v-row>
                                    @endif
                                </v-col>
                            </v-row>
                        </v-col>
                    @endforeach
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
@endsection
