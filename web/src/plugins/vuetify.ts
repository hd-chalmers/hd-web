import Vue from 'vue'
import Vuetify from 'vuetify/lib/framework'

Vue.use(Vuetify)

const browserTheme = window.matchMedia('(prefers-color-scheme: dark)')

export default new Vuetify({
  theme: {
    dark: browserTheme.matches
  }
})
