<v-app-bar app elevate-on-scroll>
    <v-img src="/img/HD_logo.png" max-width="100"></v-img>
    <v-toolbar-title>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-sm-and-down"
            text
            href="{{route('index')}}">
            <span style="color: #E0218A">H</span>-Sektionens Datorförening
        </v-btn>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-md-and-up"
            text
            href="{{route('index')}}">
            <span style="color: #E0218A">H</span><span style="color: black">D</span>
        </v-btn>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-md-and-down">
        <v-btn text href="{{route('committee.index')}}">Sittande</v-btn>
        @if(false)
            <v-btn text href="{{route('event.index')}}">Evenemang</v-btn>
            <v-btn text href="{{route('products.index')}}">Prislista</v-btn>
            @if (\Illuminate\Support\Facades\Auth::check())
                <v-btn text href="{{route('account.index')}}">Strecklista</v-btn>
            @endif
            <v-btn text href="{{route('games.index')}}">Våra Spel</v-btn>
        @endif
        <v-btn text href="{{route('contact')}}">Kontakta Oss</v-btn>
        <v-btn text href="https://www.facebook.com/HsektionenChalmers/"><span
                style="color: #E0218A">H</span>-Sektionen
        </v-btn>
        <v-btn color="blue" icon href="https://www.facebook.com/HDChalmers/">
            <v-icon>mdi-facebook</v-icon>
        </v-btn>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
    <v-toolbar-items class="hidden-lg-and-up">
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('committee.index')}}">
            <v-icon title="Sittande">mdi-account-group</v-icon>
        </v-btn>
        @if(false)
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('event.index')}}">
            <v-icon title="Evenemang">mdi-calendar-star</v-icon>
        </v-btn>
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('products.index')}}">
            <v-icon title="Prislista">mdi-cash</v-icon>
        </v-btn>
        @if (\Illuminate\Support\Facades\Auth::check())
            <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('account.index')}}">
                <v-icon title="Strecklista">mdi-format-list-checkbox</v-icon>
            </v-btn>
        @endif
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('games.index')}}">
            <v-icon title="Våra Spel">mdi-gamepad-variant</v-icon>
        </v-btn>
        @endif
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="{{route('contact')}}">
            <v-icon title="Kontakta Oss">mdi-phone</v-icon>
        </v-btn>
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" href="https://www.facebook.com/HsektionenChalmers/">
            <span style="color: #E0218A">H</span>
        </v-btn>
        <v-btn color="blue" icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="https://www.facebook.com/HDChalmers/">
            <v-icon>mdi-facebook</v-icon>
        </v-btn>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
</v-app-bar>
