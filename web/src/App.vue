<template>
  <Base>
      <eventPage></eventPage>
  </Base>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Base from './views/layouts/base.vue'
import eventPage from '@/views/events.vue'
// import IndexPage from './views/index.vue'

@Component({
  components: {
    Base,
    eventPage
    //IndexPage
  }
})
export default class App extends Vue {}
</script>
