
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar></Navbar>
        <v-main>
          <v-scroll-y-reverse-transition leave-absolute>
            <router-view/>
          </v-scroll-y-reverse-transition>

          <v-expand-transition>
            <v-alert v-if="!consent" color="info" style="position: fixed; width: 100%; bottom: 0; margin: 0;" dense>
              <v-container style="display: flex; justify-content: space-between; align-items: center; padding-top: 0; padding-bottom: 0;" :style="$vuetify.breakpoint.xsOnly ? 'flex-direction: column;' : ''">
                <p style="display: inline-block; margin: 0;">
                  Denna sidan använder sig av Google Analytics för att samla anonym statistik. Läs om deras
                  <a href="https://support.google.com/analytics/answer/7318509" target="_blank" style="z-index: 11">
                    integritets policy här. <external-link-icon size="1x"/>
                  </a>
                </p>
                <v-btn color="warning" @click="setConsent(true)" style="z-index: 11;" :width="$vuetify.breakpoint.xsOnly ? '100%' : ''"> Jag förstår </v-btn>
              </v-container>
            </v-alert>
          </v-expand-transition>
        </v-main>
<!--FooterElement></FooterElement-->
</v-app>
</template>
<!--script src="/resources/js/app.js"></script-->
<style>
.v-application .elevation-6.theme--dark {
  box-shadow: 0px 3px 5px -1px rgb(0 0 0 / 20%),
  0px 6px 10px 0px rgb(0 0 0 / 14%),
  0px 1px 18px 0px rgb(0 0 0 / 90%) !important;
}

.v-application .elevation-7.theme--dark {
  box-shadow: 0px 4px 5px -2px rgb(0 0 0 / 20%),
  0px 7px 10px 1px rgb(0 0 0 / 14%),
  0px 2px 16px 1px rgb(0 0 0 / 95%) !important;
}

@media  screen and (min-width: 2450px) {
  .v-application .container{
    max-width: 80%;
  }

  .v-application .container *:not(h1, h2, h3, h4, h5, h6, .v-card__title) {
    font-size: 1.05em;
  }

  .v-application .container .subtitle-2, .v-application .container .subtitle-1, .v-application .container .body-1, .v-application .container .body-2 {
    font-size: 1.05em !important;
  }
}
</style>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator'
import Navbar from '../../components/common/navbar.vue'
import {ExternalLinkIcon} from "vue-feather-icons";
//import FooterElement from '../../components/common/footer.vue'

  @Component({
    components: {
      Navbar,
      ExternalLinkIcon
    }
  })
export default class Base extends Vue {
    created(): void {
      this.getConsent()
      this.getData()
    }
    backgroundProperties = ''
    consent = false;

    getData(): void{
      fetch(process.env.VUE_APP_API_URL + '/background').then(res =>res.json()).then((res: {background_image: string | null}) => {
        this.backgroundProperties = `background-image: url(${res.background_image});` +
          'background-repeat: no-repeat;' +
          'background-position: center;' +
          'background-attachment: fixed;' +
          'background-size: cover ;"'
      })
        .finally(() => this.$analytics.trackTiming('Initial Load', 'Load layout', Math.round(performance.now())))
    }

    getCookie(cname: string): string {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    getConsent(): void{
      console.log(document.cookie)
      console.log(this.getCookie("consent") === 'true')
      this.consent = this.getCookie("consent") === 'true'
    }

    setConsent(consent: boolean): void{
      document.cookie = "consent=" + consent + ';'
      console.log(document.cookie)

      this.getConsent()
    }
}
</script>
