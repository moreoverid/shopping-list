const mix = require('laravel-mix');

mix.webpackConfig({
    stats: {
        children: true,
    },
});

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

mix.js('resources/js/app.js', 'public/js').vue() // including .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.copy('resources/img', 'public/img');

if (mix.inProduction()) {
    mix.version();
}
