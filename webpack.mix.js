const mix = require("laravel-mix");

mix.js("resources/js/filament-phone-input.js", "dist/js").postCss('resources/css/filament-phone-input.css', 'dist/css', [
    require('tailwindcss')
]);
