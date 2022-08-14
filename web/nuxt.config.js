export default {
  // Enable server-side pre rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: true,

  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - HD',
    title: 'H-sektionens Datorförening',
    htmlAttrs: {
      lang: 'sv'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    'plugins/class-route-guards.js'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/typescript
    '@nuxt/typescript-build',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',

    '@nuxtjs/router-extras',

    '@nuxtjs/eslint-module',

    '@nuxtjs/pwa',

    '@nuxtjs/google-analytics'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
  ],

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    treeShaking: true,
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: true,
      themes: {
        light:{
          'primary': '#d2017a',
          'error': '#ff3d00',
          'success': '#28aa85',
          'warning': '#decf31',
          'info': '#31a8de'

        },
        dark: {
          'primary': '#f2008d',
          'error': '#ff3d00',
          'success': '#31deac',
          'warning': '#decf31',
          'info': '#31a8de'
        }
      }
    }
  },

  pwa: {
    meta: {
      nativeUI: true,
      lang: "se",
      themeColor: "#f2008d"
    }
  },

  googleAnalytics: {
    id: process.env.NUXT_ENV_TRACKING_ID,
    autoTracking: {
      exception: true
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
