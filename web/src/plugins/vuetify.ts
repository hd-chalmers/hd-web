import Vue from 'vue'
import Vuetify from 'vuetify/lib/framework'

Vue.use(Vuetify)

const browserTheme = window.matchMedia('(prefers-color-scheme: dark)')

export default new Vuetify({
  theme: {
    dark: browserTheme.matches,
    themes: {
      light:{
        primary: '#DE3163',
        error: '#ff3d00',
        success: '#28aa85',
        warning: '#decf31',
        info: '#31a8de'

      },
      dark: {
        primary: '#DE3163',
        error: '#ff3d00',
        success: '#31deac',
        warning: '#decf31',
        info: '#31a8de'
      }
    }
  }
})
