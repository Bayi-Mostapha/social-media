const mix = require('laravel-mix');
const webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
.js('resources/js/chat.js', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
    //
]);

mix.options({
    hmrOptions: {
        host: 'localhost',
        port: 8081
    }
});

mix.webpackConfig({
   plugins: [
      new webpack.DefinePlugin({
         'process.env.MIX_PUSHER_APP_KEY': JSON.stringify(process.env.PUSHER_APP_KEY),
         'process.env.MIX_PUSHER_APP_CLUSTER': JSON.stringify(process.env.PUSHER_APP_CLUSTER),
      }),
   ],
});
