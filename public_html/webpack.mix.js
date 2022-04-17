const mix = require('laravel-mix');
require('laravel-mix-purgecss');
require('laravel-mix-postcss-config');
const glob = require('glob-all');
const env = process.env.NODE_ENV;

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

mix.options({
    publicPath: './',
});

/**
 * JS
 */
mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
});

// Generate scripts.min.js file
mix.js('assets/js/scripts.js', 'assets/dist/js/scripts.min.js')
    .version();

/**
 * CSS
 */
mix.sass('assets/_scss/main.scss', 'assets/dist/css/style.min.css').options({
    processCssUrls: false,
    postCss: [
        require('postcss-css-variables')({
            preserve: true, // --vh variable problem solve
        })
    ]
}).purgeCss({
    enabled: env === 'production',
    paths: () => glob.sync([
        path.join(__dirname, '../private/resources/views/web/**/**/**/**/*.blade.php'),
        path.join(__dirname, '../private/resources/views/web/**/**/**/*.blade.php'),
        path.join(__dirname, '../private/resources/views/web/**/**/*.blade.php'),
        path.join(__dirname, '../private/resources/views/web/**/*.blade.php'),
        path.join(__dirname, 'assets/js/*.js'),
        path.join(__dirname, 'assets/js/include/*.js'),
    ]),
    extensions: ['html', 'js', 'php', 'vue'],
    whitelistPatterns: [
        /svg/, // Laravel Blade

        /tooltip/, // Bootstrap Tooltip
        /pagination/, // Bootstrap Pagination
        /page-item/, // Bootstrap Pagination
        /page-link/, // Bootstrap Pagination
        /active/, // Bootstrap General
        /disabled/, // Bootstrap General
    ],
}).version();

/**
 * Browsersync
 */
mix.browserSync({
    files: [
        'assets/dist/js/*.js',
        'assets/dist/css/*.css',
        '../private/resources/views/web/**/**/**/**/*.blade.php',
        '../private/resources/views/web/**/**/**/*.blade.php',
        '../private/resources/views/web/**/**/*.blade.php',
        '../private/resources/views/web/**/*.blade.php',
    ],
    proxy: 'laravel-starter-kit.test',
    host: 'laravel-starter-kit.test',
    open: 'external',
});
