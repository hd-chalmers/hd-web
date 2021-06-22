
<template>
<v-app id="app" v-bind:style="backgroundProperties">
<Navbar></Navbar>
    <!--@yield('loehk') -->
        <v-main>
          <slot style="width: 70%; margin: auto;"></slot>
        </v-main>
    <!--ChassitOpenIcon></ChassitOpenIcon-->
<FooterElement></FooterElement>
</v-app>
</template>
<!--script src="/resources/js/app.js"></script-->
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Navbar from '../common/navbar.vue'
import FooterElement from '../common/footer.vue'
//  import ChassitOpenIcon from '../../js/components/ChassitOpenIcon.vue'

  @Component({
    components: {
      Navbar,
      FooterElement
      //  ChassitOpenIcon
    }
  })
export default class Base extends Vue {
    private backgroundProperties: string = 'background-image: url("/img/background_image.jpg");' +
      'background-repeat: no-repeat;' +
      'background-position: center;' +
      'background-attachment: fixed;' +
      'background-size: cover ;"'
}
</script>
