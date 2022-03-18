<template>
<v-app-bar app elevate-on-scroll clipped-left>
  <v-container style="display: flex; align-items: center;">
    <v-img src="/img/HD_logo.png" id="hd-logo" max-width="100" style="z-index: 10; cursor: pointer;" @click="$router.push('/')"></v-img>
  <nuxt-link to="/">
    <v-toolbar-title @click.once="setLoad(true, $event)">
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
            text
            :small="$vuetify.breakpoint.xs">
            <span style="color: #E0218A">H</span>
          <span>D</span>
        </v-btn>
    </v-toolbar-title>
  </nuxt-link>
    <v-spacer></v-spacer>
    <v-toolbar-items :show-arrows="false" :style="$vuetify.breakpoint.smAndDown ? 'height: 56px;' : 'height: 64px;'">
        <v-tabs optional id="navbarBtns" right>
        <v-tab nuxt to="/committee" @click.once="setLoad(true, $event)">
          <users-icon class="navbar-icon"></users-icon>
          <span class="hidden-sm-and-down">
            Sittande
          </span>
        </v-tab>
        <v-tab nuxt to="/events" @click.once="setLoad(true, $event)">
          <calendar-icon class="navbar-icon"></calendar-icon>
          <span class="hidden-sm-and-down">
            Evenemang
          </span>
        </v-tab>
          <v-tab nuxt to="/games" @click.once="setLoad(true, $event)">
            <layers-icon class="navbar-icon"/>
            <span class="hidden-sm-and-down">
            Spel
          </span>
          </v-tab>
        <!--
        @if(false)
            <v-btn text href="products">Prislista</v-btn>
            @if (\Illuminate\Support\Facades\Auth::check())
                <v-btn text href="strecklista">Strecklista</v-btn>
            @endif
            <v-btn text href="games">Våra Spel</v-btn>
        @endif
        -->
          <v-tab style="color: #ea1d86;" target="_blank" href="https://www.facebook.com/HsektionenChalmers/" @click="$analytics.trackEvent('Social', 'Htek link')">
            <v-img contain id="h-tek-img" width="28px" height="28px" src="/img/H-sektionen.svg" />
          </v-tab>
          <v-btn style="background-color: transparent; height: 100%; border-radius: 0;" class="navBtn" depressed x-small @click="scrollToFooter()">
            <phone-call-icon class="navbar-icon"></phone-call-icon>
            <!--span class="hidden-sm-and-down">
              Kontakta Oss
            </span-->
          </v-btn>
          <!--v-tab style="color: #2196F3;" href="https://www.facebook.com/HDChalmers/">
              <facebook-icon/>
          </v-tab>
          <v-tab style="color: #9C27B0;" icon href="https://www.instagram.com/hdchalmers/">
              <instagram-icon/>
          </v-tab-->

        <v-btn style="background-color: transparent; height: 100%; border-radius: 0;" class="navBtn" depressed x-small @click="toggleTheme()">
          <sun-icon :hidden="$vuetify.theme.dark"/> <moon-icon :hidden="!$vuetify.theme.dark"/>
        </v-btn>
        </v-tabs>
        <!--<v-btn icon href="https://www.facebook.com/HDChalmers/"><v-icon>mdi-instagram</v-icon></v-btn>-->
    </v-toolbar-items>
  </v-container>
  <v-progress-linear v-if="getLoad()" color="primary" fixed bottom indeterminate></v-progress-linear>
</v-app-bar>
</template>

<style lang="scss">

  .v-toolbar a{
  text-decoration: none;
  }

  .v-tab:hover #h-tek-img .v-image__image{
    background-image: url("/img/H-sektionen-colored.svg") !important;
  }
  .v-tab #h-tek-img .v-image__image{
    transition: background-image 0.28s;
  }

  .v-toolbar .v-tab > svg, .navBtn svg {
    width: 21px;
    height: 21px;
  }

  .navbar-icon{
    margin-right: 5px;
  }

  .v-app-bar .v-toolbar__content .v-tabs.theme--light > .v-tabs-bar .v-tab:not(.v-tab--active){
    color: rgba(0, 0, 0, 0.87);
  }

  .v-app-bar .v-toolbar__content .v-tabs.theme--dark > .v-tabs-bar .v-tab:not(.v-tab--active){
    color: #fff;
  }

  .v-app-bar .v-toolbar__content .v-tabs > .v-tabs-bar .v-tab, .v-tabs-bar__content > .navBtn.v-btn{
    padding: 0 5px !important;
    min-width: 32px !important;
  }

  .v-app-bar .v-toolbar__content .v-tabs > .v-tabs-bar > .v-slide-group__next.v-slide-group__next--disabled,
  .v-app-bar .v-toolbar__content .v-tabs > .v-tabs-bar > .v-slide-prev.v-slide-prev--disabled{
    display: none !important;
    width: 0;
  }

  #navbarBtns, #navbarBtns > .v-tabs-bar {
    height: 100%;
    background-color: transparent;
  }

  @media only screen and (max-width: 1264px){
    .v-app-bar .v-toolbar__content .v-tabs > .v-tabs-bar .v-tab > span{
      font-size: 0.775rem;
    }
  }

  @media only screen and (max-width: 960px) {
    .navbar-icon{
      margin-right: 0;
    }
  }

  @media only screen and (max-width: 600px) {
     .v-toolbar .v-tab > svg, .navBtn svg {
      width: 16px;
      height: 16px;
    }

    .v-app-bar .v-toolbar__content .v-tabs > .v-tabs-bar .v-tab, .v-tabs-bar__content > .navBtn.v-btn{
      min-width: 21px !important;
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
import {CalendarIcon, UsersIcon, PhoneCallIcon, SunIcon, MoonIcon, ShoppingCartIcon, LayersIcon } from 'vue-feather-icons'

@Component({
  components: {
    UsersIcon,
    CalendarIcon,
    PhoneCallIcon,
    SunIcon,
    MoonIcon,
    ShoppingCartIcon,
    LayersIcon
  }
})
export default class navbar extends Vue {
  constructor () {
    super()
    const setLoad = this.setLoad

    this.$router.afterEach((to, from) => {
      //console.log('router after')
      setLoad(false, to.path)
    })
  }

  loading = false
  lock = false

  getLoad(): boolean{
    return this.loading
  }

  toggleTheme(): void{
    this.$vuetify.theme.dark = !this.$vuetify.theme.dark

   /* if(this.$vuetify.theme.dark){
      this.$analytics.trackEvent("Theme", "Switched to Dark mode")
    } else {
      this.$analytics.trackEvent("Theme", "Switched to Light mode")
    }*/
  }

  scrollToFooter(): void{
    this.$vuetify.goTo('#footer')
    //this.$analytics.trackEvent('Footer', 'Scroll to footer card')
  }

  setLoad(value: boolean, path?: string): void{
    // sometimes the router event is faster than the click event so a lock check is used
    if(value === this.loading){
      this.lock = true
      //console.log('locked')
    }
    else if(!this.lock || !value) {
      this.loading = value

      if(value){
        performance.mark('loadStart')
      } else {
        performance.mark('loadEnd')
        performance.measure('load', 'loadStart', 'loadEnd')
        //this.$analytics.trackTiming("Routing", path ?? '', Math.round(performance.getEntriesByName('load')[0].duration))
        performance.clearMarks()
        performance.clearMeasures()
      }
      //console.log('set ' + this.loading + ' ' + value)
    }
    else {
      this.lock = false
      //console.log('unlocked')
    }
  }
}
</script>
