const webpack = require('webpack')

module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'Διαύγεια - Δημιουργία Απόφασης',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { 'http-equiv' : 'X-UA-Compatible', content: 'IE=edge'},
      { name: 'theme-color', content: '#ffffff'},
    ],
    link: [
      { rel: 'apple-touch-icon', sizes: '180x180', href: '/apple-touch-icon.png'},
      { rel: 'icon', type: 'image/png', sizes: '32x32', href: '/favicon-32x32.png'},
      { rel: 'icon', type: 'image/png', size: '16x16', href: '/favicon-16x16.png'},
      { rel: 'manifest', href: '/manifest.json'},
      { rel: 'mask-icon', href: '/safari-pinned-tab.svg', color: '#5bbad5'}
    ]
  },
  css: [
    'bootstrap/dist/css/bootstrap.min.css',
    '~assets/css/style.css',
    'bootstrap-select/dist/css/bootstrap-select.min.css'
  ],
  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#3B8070' },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLINT on save
    */
    vendor: ['jquery','bootstrap', 'autosize', 'bootstrap-select', 'axios'],
    plugins: [
      new webpack.ProvidePlugin({
        jQuery: 'jquery',
        $: 'jquery',
        jquery: 'jquery'
      })
    ],
    extend (config, ctx) {
      if (ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
