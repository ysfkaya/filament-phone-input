const mix = require("laravel-mix");

mix.postCss("resources/css/filament-phone-input.css", "dist/css", [
    require("tailwindcss"),
]);
