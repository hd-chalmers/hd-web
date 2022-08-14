<template>
  <div>
    <v-container>
      <v-card style="z-index: 1;">
        <v-card-title>
          <h2> <alert-octagon-icon size="0.8x"/>  Error {{error.statusCode}}</h2>
        </v-card-title>
        <v-card-subtitle>
          <h2>{{error.statusCode === 404 ? "Sidan som söktes finns inte" : "Något gick fel"}}</h2>
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

import {Component, Prop, Vue} from "vue-property-decorator";
import {HomeIcon, AlertOctagonIcon} from "vue-feather-icons";

/**
 * An error page that shown when a client side error occurs such as 404 when a page is not found or 500 when a crash occurs.
 * There is a button that directs to the homepage. While the page is in the layouts folder
 * it is used as a page. See the Nuxt documentation for more information.
 */
@Component<Error404>({
  components:{
    HomeIcon,
    AlertOctagonIcon
  }
})
export default class Error404 extends Vue{
  mounted(): void {
    this.$ga.event("Load error", "error " + this.$props.error.statusCode, this.$router.currentRoute.path)
  }

  /**
   * The error object that is passed to the component that contains the status code and the message.
   */
  @Prop({type: Object, default: null}) error!: {statusCode: number, message: string}


  toHome(): void{
    this.$router.push("/")
  }
}
</script>
