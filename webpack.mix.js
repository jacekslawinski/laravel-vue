const mix = require('laravel-mix');
const path = require('path');
require('vuetifyjs-mix-extension');

mix
    .options({
        terser: {
            extractComments: false
        }
    })
    .ts('resources/assets/js/main.ts', 'js')
    .version()
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader'
                }
            ]
        },
        resolve: {
            alias: {
                '@root': path.resolve(__dirname, 'resources/assets/js'),
                '@component': path.resolve(__dirname, 'resources/assets/js/components'),
                '@sass': path.resolve(__dirname, 'resources/assets/sass')
            }
        },
        output: {
            path: path.resolve(__dirname, 'public')
        }
    })
    .vue({ version: 2});
    if (!mix.inProduction()) {
        mix.sourceMaps();
        mix.webpackConfig({ devtool: 'inline-source-map'});
    }
