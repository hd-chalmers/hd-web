<template>
  <Base>
      <IndexPage></IndexPage>
  </Base>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
// import HelloWorld from './components/HelloWorld.vue'
import Base from './views/layouts/base.vue'
import IndexPage from './views/index.vue'

interface eventType {
  title: string;
  date: string;
}

@Component({
  components: {
    //   HelloWorld,
    Base,
    IndexPage
  }
})
export default class App extends Vue {}
</script>
