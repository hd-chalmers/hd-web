
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar class="hidden-print-only"></Navbar>
        <v-main>
          <v-scroll-y-reverse-transition leave-absolute>
            <Nuxt/> <!-- Page content selected by Nuxt router -->
          </v-scroll-y-reverse-transition>

          <!-- Consent pop up dialog -->
          <v-expand-transition class="d-print-none">
            <v-alert v-if="consent === null" color="info" style="position: fixed; width: 100%; margin: 0;" :style="$vuetify.breakpoint.xsOnly ? 'bottom: 56px;' : 'bottom: 0;'" class="d-print-none" dense>
              <v-container style="display: flex; justify-content: space-between; align-items: center; padding-top: 0; padding-bottom: 0;" :style="$vuetify.breakpoint.xsOnly ? 'flex-direction: column;' : ''">
                <p style="display: inline-block; margin: 0;">
                  Denna sidan använder sig av Google Analytics för att samla anonym statistik. Läs om deras
                  <a href="https://support.google.com/analytics/answer/7318509" target="_blank" style="z-index: 11">
                    integritets policy här. <external-link-icon size="1x"/>
                  </a>
                </p>
                <span :style="$vuetify.breakpoint.xsOnly ? 'width: 100%' : ''">
                  <v-btn color="error" @click="setConsent(false)" style="z-index: 11;" :width="$vuetify.breakpoint.xsOnly ? '49%' : '130px'"> Jag nekar </v-btn>
                  <v-btn color="warning" @click="setConsent(true)" style="z-index: 11;" :width="$vuetify.breakpoint.xsOnly ? '49%' : '130px'"> Jag medger </v-btn>
                </span>
              </v-container>
            </v-alert>
          </v-expand-transition>
        </v-main>
<!--FooterElement></FooterElement-->
</v-app>
</template>
<!--script src="/resources/js/app.js"></script-->
<style>

/* Make shadows darker in dark mode */
.v-application .elevation-6.theme--dark {
  box-shadow: 0 3px 5px -1px rgb(0 0 0 / 20%),
  0 6px 10px 0 rgb(0 0 0 / 14%),
  0 1px 18px 0 rgb(0 0 0 / 90%) !important;
}

.v-application .elevation-7.theme--dark {
  box-shadow: 0px 4px 5px -2px rgb(0 0 0 / 20%),
  0 7px 10px 1px rgb(0 0 0 / 14%),
  0 2px 16px 1px rgb(0 0 0 / 95%) !important;
}

/* Increase container size and font size for UHD screens */
@media  screen and (min-width: 2450px) {
  .v-application .container{
    max-width: 80%;
  }

  .v-application .container *:not(h1, h2, h3, h4, h5, h6, .v-card__title) {
    font-size: 1.05em;
  }

  .v-application .container .text-subtitle-2, .v-application .container .text-subtitle-1, .v-application .container .text-body-1, .v-application .container .text-body-2 {
    font-size: 1.05em !important;
  }
}
</style>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator'
import Navbar from '@/components/common/navbar.vue'
import {ExternalLinkIcon} from "vue-feather-icons";
//import FooterElement from '../../components/common/footer.vue'

/**
 * The default layout for the web application. Any child components that are connected to this layout by Nuxt will be rendered under the Nuxt tag.
 * The navbar is rendered above the Nuxt tag.
 * When the layout is initialized, it will check if the user has consented to the use of Google Analytics. If not, it will display an alert.
 * And check what theme the user has selected which is applied to Vuetify.
 * The background image is set when received from the API.
 */
  @Component({
    components: {
      Navbar,
      ExternalLinkIcon
    }
  })
  export default class Base extends Vue {
    /**
     * The constructor for the default layout. It will check if the user has consented to the use of Google Analytics. If not, it will display an alert.
     * And check what theme the user has selected which is applied to Vuetify.
     */
    created(): void {

      try {
        if (window.localStorage.getItem("theme")) {
          this.$vuetify.theme.dark = window.localStorage.getItem("theme") === "dark"
        } else {
          this.$vuetify.theme.dark = window.matchMedia('(prefers-color-scheme: dark)').matches
        }
      } catch (e) {
        console.error(e)
      }

      this.getConsent()
      this.getData()
    }

    // The css rules for the background image. To be set on the v-app tag.
    backgroundProperties = ''
    // A boolean that is set to true when the user has consented to the use of Google Analytics. It is set to null when the user has not chosen yet.
    consent: boolean | null = false;

  /**
   * A function that gets the background image from the API. And sets the background image to the css rules for v-app.
   * @public
   */
  getData(): void{
      fetch(process.env.NUXT_ENV_API_URL + '/background').then(res =>res.json()).then((res: {background_image: string | null}) => {
        this.backgroundProperties = `background-image: url(${res.background_image});` +
          'background-repeat: no-repeat;' +
          'background-position: center;' +
          'background-attachment: fixed;' +
          'background-size: cover ;"'
      })
       .finally(() => this.$ga.time('Initial Load', 'Load layout', Math.round(performance.now())))
    }

    /**
     * A function that gets the consent from the local cache. If the consent is not set, it will set it to null.
     * @public
     */
    getConsent(): void{
      let c: string | null

      try {
        c = window.localStorage.getItem("consent")
      } catch (e) {
        console.error(e)
        this.$ga.disable()
        return
      }

      if(c === null){
        this.consent = null
      } else {
        this.consent = c === 'true'
      }

      if(this.consent === false){
        this.$ga.disable()
      }
    }

    /**
     * A function that sets the consent to the local cache.
     * @public
     * @param {boolean} consent - The consent to set.
     */
    setConsent(consent: boolean): void{
      try {
        window.localStorage.setItem("consent", '' + consent)
      } catch (e){
        console.error(e)
        return
      }

      this.$ga.event("Tracking", "consent")

      this.getConsent()
    }
}
</script>
