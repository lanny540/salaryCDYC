const mix = require('laravel-mix');

// mix.js([
//     'resources/js/helper.js',
// ], 'public/js/app.min.js');

mix.browserSync({
    proxy: 'salarycdyc.test'
});
