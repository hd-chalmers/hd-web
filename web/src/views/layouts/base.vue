
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar></Navbar>
        <v-main>
          <v-scroll-y-reverse-transition leave-absolute>
            <router-view/>
          </v-scroll-y-reverse-transition>
        </v-main>
<FooterElement></FooterElement>
</v-app>
</template>
<!--script src="/resources/js/app.js"></script-->
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Navbar from '../../components/common/navbar.vue'
import FooterElement from '../../components/common/footer.vue'

  @Component({
    components: {
      Navbar,
      FooterElement
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
