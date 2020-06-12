@extends('layouts.base')


@section('content')
    <div class="container bg-light pt-2 pb-1 rounded" style="flex: 1">

        @if($event)
            <div class="alert alert-info mt-1 mb-1">
                <strong>Nästa Event: </strong>
                {{substr($event->date, 0, 16) . ' - ' . $event->title}}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <img src="{{$active_year->front_image ? Storage::url($active_year->front_image): "/img/unknown_group.png"}}" alt="unknown_group"
                     class="rounded mx-auto d-block img-fluid">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2><strong>Vad är <span style="color: #E0218A">H</span><span style="color: black">D</span>?</strong></h2>
                <p>Vi arrar dator- och spelrelaterade (självklart även datorspelrelaterade) aktiviteter. Vårt paradnummer är 'Chilla med HD', ett event som hålls minst två gånger per läsperiod. Då spelar vi spel (brädspel, tv-spel,
                    datorspel)
                    och intar socker i olika former.</p>
                <p>Vi tillhandahåller även hjälp i diverse datorrelaterade kurser.</p>
                <p>Vi leverar socker samt högupplöst kärlek till alla och några till. Våra arr är alkoholfria, med undantag för våra spelpubar som vi har några gånger per år.</p>
                <p>Så om ni vill spela spel, ha hjälp med programmering eller bara få er en sockerchock är det oss ni ska vända er till.</p>
                <p>Vårt tillhåll är vid lilla FöreningsTorget i källaren av Svea-huset.</p>
                <!----<p>Vi håller till i katakomberna under Lindholmen.</p>----->
                <p><strong>TL;DR:</strong> Socker, spel, datorer, kakor, läsk, SOCKER!!1!</p>
            </div>
        </div>
    </div>

@endsection
