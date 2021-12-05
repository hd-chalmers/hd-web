<template>
  <div>
    <v-container>
      <v-card style="z-index: 1;">
        <v-card-title>
          <h2> <alert-octagon-icon size="0.8x"/>  Error 404</h2>
        </v-card-title>
        <v-card-subtitle>
          <h2>Sidan som söktes finns inte</h2>
        </v-card-subtitle>
        <v-card-text>
          <v-img src="/img/droopy-sad.webp" width="100%" max-width="800px" style="margin: auto;"/>
          <v-btn x-large @click="toHome()" color="primary" width="100%" style="margin: 10px 0;"> <home-icon size="1.2x" style="margin-right: 5px;"/> Mot startsidan </v-btn>
        </v-card-text>
      </v-card>
    </v-container>
    <iframe style="position: absolute; width: 100%; height: 100%; top: 0;" src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=1&controls=0&fs=0&loop=1&modestbranding=1"
            title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
            encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>
</template>

<script lang="ts">

import {Component, Vue} from "vue-property-decorator";
import {HomeIcon, AlertOctagonIcon} from "vue-feather-icons";

@Component({
  components:{
    HomeIcon,
    AlertOctagonIcon
  }
})
export default class Error404 extends Vue{
  toHome(): void{
    this.$router.push("/")
  }
}
</script>
