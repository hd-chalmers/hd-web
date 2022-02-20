
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar></Navbar>
        <v-main>
          <v-scroll-y-reverse-transition leave-absolute>
            <router-view/>
          </v-scroll-y-reverse-transition>
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
import { Component, Vue } from 'vue-property-decorator'
import Navbar from '../../components/common/navbar.vue'
import FooterElement from '../../components/common/footer.vue'

  @Component({
    components: {
      Navbar
    }
  })
export default class Base extends Vue {
    constructor () {
      super();
      this.getData()
    }
    backgroundProperties = ''
    getData(): void{
      fetch(process.env.VUE_APP_API_URL + '/background').then(res =>res.json()).then((res: {background_image: string | null}) => {
        this.backgroundProperties = `background-image: url(${res.background_image});` +
          'background-repeat: no-repeat;' +
          'background-position: center;' +
          'background-attachment: fixed;' +
          'background-size: cover ;"'
      })
    }
}
</script>
