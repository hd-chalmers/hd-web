<template>
      <router-view/>
</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator'
  import Base from '@/views/layouts/base.vue'

  @Component({
    components: {
      Base
    }
  })
  export default class App extends Vue{}
</script>
 <style>
 .slide-fade-enter-active {
   transition: all .5s ease-out;
 }
 .slide-fade-leave-active {
   transition: all .4s ease-in-out;
 }
 .slide-fade-enter{
   transform: translateY(100vh);
   opacity: 0;
 }
 .slide-fade-leave-to{
   opacity: 0;
   transform: translateY(-100vh);
   height: 0;
   padding: 0;
   box-sizing: border-box;
 }
 </style>
