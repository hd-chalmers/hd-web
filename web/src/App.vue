<template>
  <Base>
      <ContactPage></ContactPage>
  </Base>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Base from './views/layouts/base.vue'
import ContactPage from '@/views/contact.vue'
// import IndexPage from './views/index.vue'

@Component({
  components: {
    Base,
    ContactPage
    //IndexPage
  }
})
export default class App extends Vue {}
</script>
