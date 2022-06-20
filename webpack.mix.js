require('dotenv').config();
const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .sass("resources/sass/app.scss", "public/css/main.css")
    .version();
mix.sass("resources/sass/date-picker.scss", "public/css/date-picker.css");

mix.js("resources/js/range-bar.js", "public/js")
    .sass("resources/sass/range-bar.scss", "public/css/range-bar.css")
    .version();

mix.js("resources/js/dropzone.min.js", "public/js")
.sass("resources/sass/dropzone.scss", "public/css/dropzone.css")
.version();

mix.js("resources/js/googlemaps.js", "public/js").version();

mix.js("resources/js/show-more.js", "public/js").version();
