const mix = require("laravel-mix");

mix.js("resources/js/filament-phone-input.js", "dist/js")
.postCss("resources/css/intl-tel-input.css","dist/css")
.postCss('resources/css/filament-phone-input.css', 'dist/css', [
    require('tailwindcss')
])
.copy("./node_modules/intl-tel-input/build/js/utils.js", "dist/intl-tel-input/utils.js")
