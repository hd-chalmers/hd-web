<template>
<v-app-bar app elevate-on-scroll>
    <v-img src="/img/HD_logo.png" max-width="100"></v-img>
    <v-toolbar-title>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-sm-and-down"
            text
            href="index">
            <span style="color: #E0218A">H</span>-Sektionens Datorförening
        </v-btn>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-md-and-up"
            text
            href="index">
            <span style="color: #E0218A">H</span><span style="color: black">D</span>
        </v-btn>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-md-and-down">
        <v-btn text href="Comittee">Sittande</v-btn>
        <v-btn text href="event">Evenemang</v-btn>
        <!--
        @if(false)
            <v-btn text href="products">Prislista</v-btn>
            @if (\Illuminate\Support\Facades\Auth::check())
                <v-btn text href="strecklista">Strecklista</v-btn>
            @endif
            <v-btn text href="games">Våra Spel</v-btn>
        @endif
        -->
        <v-btn text href="contact">Kontakta Oss</v-btn>
        <v-btn text href="https://www.facebook.com/HsektionenChalmers/"><span
                style="color: #E0218A">H</span>-Sektionen
        </v-btn>
        <v-btn color="blue" icon href="https://www.facebook.com/HDChalmers/">
            <v-icon>mdi-facebook</v-icon>
        </v-btn>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
    <v-toolbar-items class="hidden-lg-and-up">
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="comittee">
            <v-icon title="Sittande">mdi-account-group</v-icon>
        </v-btn>
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="event">
            <v-icon title="Evenemang">mdi-calendar-star</v-icon>
        </v-btn>
      <!--
        @if(false)
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="products">
            <v-icon title="Prislista">mdi-cash</v-icon>
        </v-btn>
        @if (\Illuminate\Support\Facades\Auth::check())
            <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="account">
                <v-icon title="Strecklista">mdi-format-list-checkbox</v-icon>
            </v-btn>
        @endif
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="games">
            <v-icon title="Våra Spel">mdi-gamepad-variant</v-icon>
        </v-btn>
        @endif
        -->
        <v-btn icon :x-large="!$vuetify.breakpoint.mobile" :small="$vuetify.breakpoint.mobile" href="contact">
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
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component
export default class navbar extends Vue {}
</script>
