
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar></Navbar>
    <!--@yield('loehk') -->
        <v-main>
          <router-view/>
        </v-main>
    <!--ChassitOpenIcon></ChassitOpenIcon-->
<FooterElement></FooterElement>
</v-app>
</template>
<!--script src="/resources/js/app.js"></script-->
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Navbar from '../../components/common/navbar.vue'
import FooterElement from '../../components/common/footer.vue'
//  import ChassitOpenIcon from '../../js/components/ChassitOpenIcon.vue'

  @Component({
    components: {
      Navbar,
      FooterElement
      //  ChassitOpenIcon
    }
  })
export default class Base extends Vue {
    constructor () {
      super();
      this.getData()
    }
    backgroundProperties = ''
    async getData(): Promise<void>{
      fetch('http://localhost:8000/background').then(res =>res.json()).then(res => {
        this.backgroundProperties = `background-image: url(${res});` +
          'background-repeat: no-repeat;' +
          'background-position: center;' +
          'background-attachment: fixed;' +
          'background-size: cover ;"'
      })
    }
}
</script>
