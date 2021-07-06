<template>
<v-footer app
          padless
          elevation="5"
>
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
</v-footer>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component
export default class footerElement extends Vue {}
</script>
