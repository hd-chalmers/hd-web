@extends('committee.src.views.layouts.base')
<?php
/**
 * @var \App\Models\ActiveYear $active_year
 */
?>

@section('content')
    <v-container>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <h1>HD {{$active_year->displayed_year}}</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-img lazy-src="/img/unknown_group.png" src="{{$active_year->group_photo ? Storage::url($active_year->group_photo) : '/img/unknown_group.png'}}" class="mx-auto" max-height="400px" contain></v-img>
                        {{$active_year->description}}
                    </v-col>
                </v-row>
                <v-row class="mb-3 text-center justify-center">
                    @foreach($active_year->committee_members as $member)
                        <v-col cols="12" md="6" lg="4" xl="3">
                            <v-avatar size="200px" class="elevation-4 mb-2">
                                <v-img lazy-src="/img/unknown_profile.png" src="{{$member->image ? Storage::url($member->image) : "/img/unknown_profile.png"}}" class="mx-auto" max-height="200px" contain></v-img>
                            </v-avatar>
                            <v-card elevation="1" rounded>
                                <v-card-title class="justify-center">
                                    {{$member->name}}
                                </v-card-title>
                                <v-card-subtitle class="text-center">
                                    {{ucfirst($member->role)}}
                                </v-card-subtitle>
                                <v-card-text class="py-0">
                                    <v-list class="py-0">
                                        @if($member->quote)
                                            <v-list-item class="mx-0 py-0 text-center" style="min-height: 20px">
                                                <v-list-item-subtitle>
                                                    "{{$member->quote}}"
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                        @endif
                                        @if($member->description)
                                            <v-list-item class="mx-0 py-0 text-center" style="min-height: 20px">
                                                <v-list-item-subtitle>
                                                    {{$member->description}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                        @endif
                                        @if($member->favourite_game)
                                            <v-list-item class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                                                <v-list-item-title>
                                                    Favoritspel
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{$member->favourite_game}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                        @endif
                                        @if($member->favourite_sugar)
                                            <v-list-item class="mx-0 py-0 px-0 text-left" style="min-height: 20px">
                                                <v-list-item-title>
                                                    Favoritsocker
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{$member->favourite_sugar}}
                                                </v-list-item-subtitle>
                                            </v-list-item>
                                        @endif
                                    </v-list>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    @endforeach
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
@endsection
