const { resolve } = require('path')
const { getWebpackConfig } = require('nuxt')

const FILTERED_PLUGINS = [
  'WebpackBarPlugin',
  'VueSSRClientPlugin',
  'HotModuleReplacementPlugin',
  'FriendlyErrorsWebpackPlugin',
  'HtmlWebpackPlugin'
]

/** @type import("vue-styleguidist").Config */
module.exports = async () => {
  // get the webpack config directly from nuxt
  const nuxtWebpackConfig = await getWebpackConfig('client', {
    for: 'dev'
  })

  const webpackConfig = {
    module: {
      rules: [
        ...nuxtWebpackConfig.module.rules.filter(
          // remove the eslint-loader
          a => a.loader !== 'eslint-loader'
        )
      ]
    },
    resolve: { ...nuxtWebpackConfig.resolve },
    plugins: [
      ...nuxtWebpackConfig.plugins.filter(
        // And some other plugins that could conflcit with ours
        p => FILTERED_PLUGINS.indexOf(p.constructor.name) === -1
      )
    ]
  }

  return {
    //components: './components/**/*.vue',
    sections: [
      {
        content: "../README.md"
      },
      {
        name: "Components",
        components: 'components/**/*.vue'
      },
      {
        name: "Pages",
        components: "pages/**/*.vue"
      }
    ],
    renderRootJsx: resolve(__dirname, 'styleguide/styleguide.root.js'),
    webpackConfig,
    usageMode: 'expand',
    styleguideDir: 'dist'
  }
}
