/* jshint ignore: start */
var path = require('path');
var webpack = require('webpack');

module.exports = {

    /**
     * Paths
     */
    dir: {
        dist:       'Assets',
        src:        'Resources/assets',
        pkg:        'bower_components',
        views:      'Resources/views',
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
            'datamanager.css': '<%= dir.src %>/scss/datamanager.scss',
        },
        'js': {
            'datamanager.js': [
                '<%= dir.src %>/js/datamanager.js'
            ],
            'form-validator.js': [
                '<%= dir.src %>/js/form-validator.js'
            ],
            'form-builder.js': [
                '<%= dir.src %>/js/form-builder.js'
            ],
            'form-rules.js': [
                '<%= dir.src %>/js/form-rules.js'
            ]
        },
        'webpack': {

        },
        'html': [
            '<%= dir.src %>/html/*.html'
        ]
    },

    /**
     * Copy
     */
    copy: {
        'plugins': [
            '<%= dir.src %>/plugins/**/*',
        ],
    },

    /**
     * Files to watch
     */
    watch: {
        scss:       '<%= dir.src %>/scss/**/*.scss',
        js:         '<%= dir.src %>/js/**/*.js',
        img:        '<%= dir.src %>/img/**/*',
        html:       '<%= dir.src %>/html/**/*.html',
    },

    /**
     * Server configuration
     */
    server: {
        base:           'public',
        hostname:       '127.0.0.1',
        port:           9000,
        livereload:     false,
        watch:          false,
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
        '*.php',
        '**/*.php',
        '<%= dir.views %>/**/*.php',
        '<%= dir.dist %>/css/*.css',
        '<%= dir.dist %>/js/*.js',
        '<%= dir.dist %>/html/*.html',
    ],

    imagemin: {
        optimizationLevel: 5,
        progressive: true,
        interlaced: true,
        svgoPlugins: [{ removeUnknownsAndDefaults: false }]
    },

    // @see https://www.npmjs.com/package/gulp-minify-html
    minifyhtml: {
        comments: false,
        conditionals: true,
        spare: false,
        empty: true
    },

    jshint: {
        browser:        false,
        camelcase:      false,
        curly:          false,
        devel:          false,
        eqeqeq:         false,
        esnext:         false,
        expr:           false,
        freeze:         false,
        globals:        {
            angular: false
        },
        globalstrict:   false,
        jquery:         false,
        latedef:        false,
        newcap:         false,
        nonbsp:         false,
        strict:         false,
        undef:          false,
        unused:         false
    },

    webpack: {
        resolve: {
            extensions: ['', '.js'],
            root: [
                path.resolve('./Resources/assets/js'),
                path.join(__dirname, 'bower_components')
            ]
        },
        plugins: [
            new webpack.ResolverPlugin(
                new webpack.ResolverPlugin.DirectoryDescriptionFilePlugin('bower.json', ['main'])
            ),
            new webpack.ProvidePlugin({
                $: 'jquery'
            })
        ],
        externals: {
            angular: 'angular',
            jquery: 'jQuery'
        },
        module: {
            loaders: [
                { test: /jquery\.js$/, loader: 'expose?jQuery!expose?$' },
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components|plugins)/,
                    // @see https://github.com/babel/babel-loader#options
                    loaders: [
                        'ng-annotate?' + JSON.stringify({
                            add: true,
                            single_quotes: true
                        }),
                        'babel?' + JSON.stringify({
                            cacheDirectory: true,
                            optional: ['runtime'],
                            stage: 0
                        })
                    ]
                }
            ]
        }
    }
};
