<template>
    <v-container>
      <footer-card/>
    </v-container>
</template>

<script lang="ts">
    import {Component, Vue} from 'vue-property-decorator'
    import footerCard from '@/components/footerCard.vue'

    @Component({
      components: {
        footerCard
      }
    })
    export default class ContactPage extends Vue{}
</script>
