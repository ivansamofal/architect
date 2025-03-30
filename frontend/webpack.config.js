const Encore = require('@symfony/webpack-encore');

// Если окружение не настроено, настроим его по NODE_ENV
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

// Encore
//     .setOutputPath('public/build/')
//     .setPublicPath('/build')
//     .addEntry('app', './assets/main.js')
//     .enableVueLoader()
//     .cleanupOutputBeforeBuild()
//     .enableSingleRuntimeChunk()
//     .enableSourceMaps(!Encore.isProduction())
//     .enableVersioning(Encore.isProduction());
//
// module.exports = Encore.getWebpackConfig();

const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    entry: './assets/main.js',
    output: {
        filename: 'bundle.js', // собранный файл
        path: path.resolve(__dirname, 'public/js/dist'),
    },
    mode: 'development', // или 'production'
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
};
