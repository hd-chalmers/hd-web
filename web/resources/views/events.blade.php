@extends('layouts.base')


@section('content')
    <v-container>
        <v-card>
            <v-card-title>
                Kommande Arrangemang
            </v-card-title>
            <v-card-text>
                @forelse($events as $event)
                    <v-card class="mb-3" elevation="5">
                        <v-card-title>
                            {{$event->date}} {{$event->time}} - {{$event->title}}

                            @if($event->facebook_event_link)
                                <v-btn icon href="{{$event->facebook_event_link}}">
                                    <v-icon>mdi-facebook</v-icon>
                                </v-btn>
                            @endif
                        </v-card-title>
                        <v-card-text>
                            @if($event->location)
                                Plats: {{$event->location}}<br/><br/>
                            @endif
                            {{$event->description}}
                        </v-card-text>
                    </v-card>
                @empty
                    Inga arrangemang är just nu inlagda
                @endforelse
            </v-card-text>
        </v-card>
    </v-container>
@endsection
