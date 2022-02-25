import Vue from 'vue'
import vuetify from './plugins/vuetify'
import App from './App.vue'
import router from './router'
import Component from "vue-class-component";
import './registerServiceWorker'
import "@/plugins/analytics";

Vue.config.productionTip = false

new Vue({
  vuetify,
  render: h => h(App),
  router,
}).$mount('#app')

Component.registerHooks([
  'beforeRouteEnter',
  'beforeRouteLeave',
  'beforeRouteUpdate'
])
