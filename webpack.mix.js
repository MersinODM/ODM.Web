const mix = require('laravel-mix')
// const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
  .BundleAnalyzerPlugin
const webpack = require('webpack')

// mix.config.fileLoaderDirs.fonts = 'public/fonts'
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
  plugins: [
    new BundleAnalyzerPlugin(),
    new webpack.IgnorePlugin(/\.\/locale$/),
    new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /tr/)
  ],
  externals: {
    jquery: 'jQuery',
    'jquery.dataTables': 'jquery.dataTables',
    moment: 'moment'
  }
})

// mix.babelConfig({
//   presets: ['@babel/preset-env'],
//   plugins: ['@babel/plugin-syntax-dynamic-import']
// })

mix.copyDirectory('resources/images', 'public/images')
// mix.copyDirectory('node_modules/@mdi/font/fonts', 'public/fonts')
// mix.copyDirectory('node_modules/@mdi/font/fonts', 'public/fonts')

mix.js('resources/js/main.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false
  })
  .extract(['vue', 'vue-router', 'vee-validate', 'sweetalert', 'bootstrap'])

if (!mix.inProduction()) {
  mix.sourceMaps()
}

if (mix.inProduction()) {
  mix.setResourceRoot('/otomasyon')
}
