<template>
  <Base>
      <IndexPage></IndexPage>
  </Base>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
// import HelloWorld from './components/HelloWorld.vue'
import Base from '../resources/views/layouts/base.vue'
import IndexPage from '../resources/views/index.vue'

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
