var path = require('path');
var webpack = require('webpack');

module.exports = {
    devtool: 'source-map',
    externals: {
        jquery: 'jQuery',
    },
    module: {
        loaders: [
            { test: /jquery\.js$/, loader: 'expose?jQuery!expose?$' },
            {
                test: /\.js$/,
                loader: 'babel',
                exclude: /node_modules/,
                query: {
                    cacheDirectory: true,
                    presets: ['es2015']
                }
            }
        ]
    },
    plugins: [
        new webpack.ResolverPlugin([
            new webpack.ResolverPlugin.DirectoryDescriptionFilePlugin('bower.json', ['main']),
        ]),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
        }),
    ],
    resolve: {
        extensions: ['', '.js'],
        root: [
            path.join(__dirname, 'bower_components'),
            path.join(__dirname, 'node_modules'),
        ]
    },
};
