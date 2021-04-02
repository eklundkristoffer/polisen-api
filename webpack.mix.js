const mix = require('laravel-mix');

mix.copy('resources/fonts', 'public/fonts', true);

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
        require('postcss-nested')
    ]);
