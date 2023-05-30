/* jshint ignore: start */
var path = require('path');
var webpackConfig = require('./webpack.config.js');

//webpackConfig.resolve.root.push(path.join(__dirname, 'assets/js'));

module.exports = {

    /**
     * Paths
     */
    dir: {
        dist:       'public/assets',
        src:        'resources/assets',
        pkg:        'bower_components',
        npm:        'node_modules'
    },

    /**
     * Files
     *
     * @example
     * folder: {
     *  'filename': 'path/to/file' // or []
     * }
     */
    files: {
        'css': {

        },
        'js': {

        },
        'webpack': {

        }
    },

    /**
     * Copy
     */
    copy: {
        'js/shortcodes/': [
            '<%= dir.src %>/js/shortcodes/*',
        ],
        'plugins/ui-select/': [
            '<%= dir.pkg %>/ui-select/dist/*',
        ],
        'fonts': [
            '<%= dir.src %>/fonts/*',
            '<%= dir.pkg %>/font-awesome/fonts/*',
        ]
    },

    /**
     * Files to watch
     */
    watch: {
        scss:       '<%= dir.src %>/sass/**/*.scss',
        js:         '<%= dir.src %>/js/**/*.js',
        img:        '<%= dir.src %>/img/**/*',
    },

    /**
     * Server configuration
     */
    server: {
        base:           'public',
        hostname:       '127.0.0.1',
        port:           9000,
        livereload:     true,
        watch:          true,
    },

    /**
     * Plugins Gulp
     */
    // @see https://github.com/ai/autoprefixer
    autoprefixer: [
        'ie >= 9',
        'ie_mob >= 10',
        'ff >= 30',
        'chrome >= 34',
        'safari >= 7',
        'opera >= 23',
        'ios >= 7',
        'android >= 4.4',
        'bb >= 10',
    ],

    babel: {},

    livereload: [
        '**/*.php',
        '*.php',
        '<%= dir.dist %>/css/*.css',
        '<%= dir.dist %>/js/*.js'
    ],

    imagemin: {
        optimizationLevel: 5,
        progressive: true,
        interlaced: true,
        svgoPlugins: [{ removeUnknownsAndDefaults: false }]
    },

    jshint: {
        browser:        true,
        camelcase:      false,
        curly:          true,
        devel:          true,
        eqeqeq:         true,
        esnext:         true,
        expr:           true,
        freeze:         false,
        globals:        {
            angular: true
        },
        globalstrict:   true,
        jquery:         true,
        latedef:        false,
        newcap:         true,
        nonbsp:         true,
        strict:         true,
        undef:          true,
        unused:         false
    },

    webpack: webpackConfig
};
