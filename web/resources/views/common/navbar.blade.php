<v-app-bar app>
    <v-img src="/img/HD_logo.png" max-width="100"></v-img>
    <v-toolbar-title>
        <v-btn
            text
            href="{{route('index')}}">
            <span style="color: #E0218A">H</span>-Sektionens Datorförening
        </v-btn>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>
        <v-btn text href="{{route('committee.index')}}">Sittande</v-btn>
        <v-btn text href="{{route('event.index')}}">Evenemang</v-btn>
        <v-btn text href="{{route('products.index')}}">Prislista</v-btn>
        @if (\Illuminate\Support\Facades\Auth::check())
            <v-btn text href="{{route('account.index')}}">Strecklista</v-btn>
        @endif
        <v-btn text href="{{route('games.index')}}">Våra Spel</v-btn>
        <v-btn text href="{{route('contact')}}">Kontakta Oss</v-btn>
        <v-btn text href="https://www.facebook.com/HsektionenChalmers/"><span
                style="color: #E0218A">H</span>-Sektionen
        </v-btn>
        <v-btn color="blue" icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-facebook</v-icon></v-btn>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
</v-app-bar>
