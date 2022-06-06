<template>
<v-footer app
          padless
          elevation="5"
>
  <div @click="$vuetify.goTo('#footer')" style="width: 100%;" v-ripple>
    <v-row
        justify="center"
        no-gutters
        align-content="center"
    >
        <v-spacer class="my-2"></v-spacer>
            <v-icon x-small>mdi-copyright</v-icon>
            {{"2021"}} <strong class="mx-1">H-Sektionens Datorförening</strong>
        <v-spacer></v-spacer>
    </v-row>
  </div>
</v-footer>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

/**
 * A footer component that is fixed to the bottom of the page. With a small HD watermark.
 * @deprecated
 */
@Component
export default class footerElement extends Vue {}
</script>
