const mix = require("laravel-mix");

mix.js("resources/js/filament-phone-input.js", "dist")
.postCss("resources/css/filament-phone-input.css","dist")
.copy("./node_modules/intl-tel-input/build/js/utils.js", "dist/intl-tel-input/utils.js")
