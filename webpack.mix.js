const mix = require('laravel-mix').setPublicPath('cadastro/public/');

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

mix.js('resources/js/app.js', 'public/js', 'public/js/jsuites.js', 'resources/js/script.js')
    .postCss('resources/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ]);

if (mix.inProduction()) {
    mix.version();
}
