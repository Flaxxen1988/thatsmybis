const mix = require('laravel-mix');

mix.options({
    // options for minification and backwards-compatibility when using .js()
    terser: {
        terserOptions: {
            keep_classnames: true,
            keep_fnames: true, // Don't mangle function names
            compress: {
                // Terser (default minification library) will delete functions that
                // aren't used in the same file they're declared in if this isn't set
                // to false. This is a problem for functions we want to call outside
                // of the file they were declared in.
                unused: false
            }
        }
    }
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

// mix.js('resources/js/app.js',        'public/js')
//     .sass('resources/sass/app.scss', 'public/css')

mix.babel('public/js/autocomplete.js',   'public/js/processed/autocomplete.js')
    .babel('public/js/guildSettings.js', 'public/js/processed/guildSettings.js')
    .babel('public/js/helpers.js',       'public/js/processed/helpers.js')
    .babel('public/js/itemList.js',      'public/js/processed/itemList.js')
    .babel('public/js/itemMassInput.js', 'public/js/processed/itemMassInput.js')
    .babel('public/js/roster.js',        'public/js/processed/roster.js')
    .babel('public/js/raidEdit.js',      'public/js/processed/raidEdit.js')
    .babel('public/js/lodash.js',      'public/js/processed/lodash.js')

    .styles(['public/css/main.css'], 'public/css/processed/main.css');

if (mix.inProduction()) {
    mix.version();
}

mix.disableNotifications(); // Disable desktop notifications of compile results
