const mix = require('laravel-mix');

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

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.version()
}
mix.disableNotifications();

mix.js('resources/admin/js/app.js', 'public/assets/admin/js')
    .sass('resources/admin/sass/app.scss', 'public/assets/admin/css', {
        implementation: require('node-sass')
    });

mix.copyDirectory([
    'resources/admin/img',
], 'public/assets/admin/img');

