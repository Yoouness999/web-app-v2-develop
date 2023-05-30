const path = require('path');
const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

mix
    .setPublicPath('./public')
    .browserSync(process.env.MIX_DEBUG_URL || 'localhost:3000')
    .webpackConfig({
        externals: {
            angular: 'angular',
            crypto: 'crypto',
            jquery: 'jQuery',
        },
        plugins: [
            //new BundleAnalyzerPlugin(),
        ],
    });

mix
    .sass('resources/assets/scss/main.scss', 'assets/css')
    .options({ processCssUrls: false });

mix
    .js('resources/assets/js/main.js', 'assets/js')
    .autoload({
        angular: ['window.angular'],
        // crypto: ['window.crypto'],
        jquery: ['$', 'window.jQuery'],
    })
    .alias({
        '@': path.resolve('resources/assets'),
        '@css': path.resolve('resources/assets/css'),
        '@img': path.resolve('resources/assets/img'),
        '@js': path.resolve('resources/assets/js'),
        'owl-carousel': path.resolve(__dirname, 'node_modules/owl-carousel/owl-carousel/owl.carousel.js'),
        'fancybox': path.resolve(__dirname, 'node_modules/fancybox/dist/js/jquery.fancybox.js'),
        'jquery-validation/additional-methods': path.resolve(__dirname, 'node_modules/jquery-validation/dist/additional-methods.js'),
    })
    .extract();

mix
    .copy([
        'resources/assets/fonts/*',
        'node_modules/font-awesome/fonts/*',
        'node_modules/bootstrap-sass/assets/fonts/**/*',
    ], 'public/assets/fonts')
    .copy('resources/assets/html/*.html', 'public/assets/html')
    .copy([
        'resources/assets/img/*',
        'node_modules/intl-tel-input/build/img/*',
    ], 'public/assets/img')
    .copy([
        // 'node_modules/angular/angular.js',
        // 'node_modules/jquery/dist/jquery.min.js',
        // 'node_modules/jquery/dist/jquery.min.map',
        'node_modules/jquery-migrate/dist/jquery-migrate.js',
    ], 'public/assets/js/vendor')
    .copy('node_modules/jquery-validation/dist/additional-methods.js', 'public/assets/js/jquery-validation')
    .copy('node_modules/jquery-validation/dist/localization/*', 'public/assets/js/jquery-validation/localization');

mix
    .sourceMaps()
    .version();
