<template>
<v-app-bar app elevate-on-scroll clipped-left>
  <v-container style="display: flex; align-items: center;">
    <v-img src="/img/HD_logo.png" id="hd-logo" max-width="100"></v-img>
  <router-link to="/">
    <v-toolbar-title>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-sm-and-down"
            text
            :small="$vuetify.breakpoint.mobile"
        >
            <span style="color: #E0218A">H</span>-Sektionens Datorförening
        </v-btn>
        <v-btn
            :hidden="$vuetify.breakpoint.mobile"
            class="hidden-md-and-up"
            text>
            <span style="color: #E0218A">H</span>
          <span>D</span>
        </v-btn>
    </v-toolbar-title>
  </router-link>
    <v-spacer></v-spacer>
    <v-toolbar-items  :style="$vuetify.breakpoint.smAndDown ? 'height: 56px;' : 'height: 64px;'">
        <v-btn to="/committee" text :icon="$vuetify.breakpoint.smAndDown"  :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly" :x-small="$vuetify.breakpoint.xsOnly">
          <users-icon class="navbar-icon"></users-icon>
          <span class="hidden-sm-and-down">
            Sittande
          </span>
        </v-btn>
        <v-btn to="/events" text :icon="$vuetify.breakpoint.smAndDown" :x-small="$vuetify.breakpoint.xs" :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly">
          <calendar-icon class="navbar-icon"></calendar-icon>
          <span class="hidden-sm-and-down">
            Evenemang
          </span>
        </v-btn>
        <!--
        @if(false)
            <v-btn text href="products">Prislista</v-btn>
            @if (\Illuminate\Support\Facades\Auth::check())
                <v-btn text href="strecklista">Strecklista</v-btn>
            @endif
            <v-btn text href="games">Våra Spel</v-btn>
        @endif
        -->
        <v-btn to="/contact" text :icon="$vuetify.breakpoint.smAndDown" :x-small="$vuetify.breakpoint.xs" :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly">
          <phone-call-icon class="navbar-icon"></phone-call-icon>
          <span class="hidden-sm-and-down">
            Kontakta Oss
          </span>
        </v-btn>
        <v-btn icon color="pink" href="https://www.facebook.com/HsektionenChalmers/" :x-large="!$vuetify.breakpoint.mobile" :x-small="$vuetify.breakpoint.xs" :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly">
          <v-img contain id="h-tek-img" width="28px" height="28px" src="/img/H-sektionen.svg" />
        </v-btn>
        <v-btn color="blue" icon href="https://www.facebook.com/HDChalmers/" :x-large="!$vuetify.breakpoint.mobile" :x-small="$vuetify.breakpoint.xs" :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly">
            <facebook-icon/>
        </v-btn>

      <v-btn @click="$vuetify.theme.dark = !$vuetify.theme.dark" icon :x-large="!$vuetify.breakpoint.mobile" :x-small="$vuetify.breakpoint.xs" :small="$vuetify.breakpoint.mobile && !$vuetify.breakpoint.xsOnly">
        <sun-icon :hidden="$vuetify.theme.dark"/> <moon-icon :hidden="!$vuetify.theme.dark"/>
      </v-btn>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
  </v-container>
</v-app-bar>
</template>

<style>
  .v-toolbar a{
  text-decoration: none;
  }

  .v-btn:hover span #h-tek-img .v-image__image{
    background-image: url("/img/H-sektionen-colored.svg") !important;
  }
  .v-btn span #h-tek-img .v-image__image{
    transition: background-image 0.28s;
  }

  .v-toolbar .v-btn__content > svg {
    width: 21px;
    height: 21px;
  }

  .navbar-icon{
    margin-right: 5px;
  }

  .v-app-bar .v-toolbar__content .v-btn.theme--light{
    color: rgba(0, 0, 0, 0.87);;
  }

  .v-app-bar .v-toolbar__content .v-btn--active {
    border-bottom: 3px solid #E0218A;
    padding-top: 3px !important;
  }

  .v-app-bar .v-toolbar__content .v-btn--active::before {
    opacity: 0;
  }

  @media only screen and (max-width: 960px) {
    .v-app-bar .v-btn--icon{
      margin: 0 5px;
    }

    .navbar-icon{
      margin-right: 0;
    }
  }

  @media only screen and (max-width: 600px) {
     .v-toolbar .v-btn__content > svg {
      width: 16px;
      height: 16px;
    }

    #hd-logo {
      max-width: 50px !important;
    }

    #h-tek-img{
      width: 16px !important;
      height: 16px !important;
    }
  }
</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import {CalendarIcon, UsersIcon, PhoneCallIcon, SunIcon, FacebookIcon, MoonIcon} from 'vue-feather-icons'

@Component({
  components: {
    UsersIcon,
    CalendarIcon,
    PhoneCallIcon,
    SunIcon,
    FacebookIcon,
    MoonIcon
  }
})
export default class navbar extends Vue {}
</script>
