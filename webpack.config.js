var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('bootstrap.bundle.min', './assets/js/bootstrap.bundle.min.js')
    .addEntry('core', './assets/js/core.js')
    .addEntry('fullscreen', './assets/js/fullscreen.js')
    .addEntry('guestures', './assets/js/guestures.js')
    .addEntry('hash', './assets/js/hash.js')
    .addEntry('jquery.fancybox.min_1', './assets/js/jquery.fancybox.min.js')
    .addEntry('jquery-3.4.1.min', './assets/js/jquery-3.4.1.min.js')
    .addEntry('media', './assets/js/media.js')
    .addEntry('modal-redirect', './assets/js/modal-redirect.js')
    .addEntry('parallax', './assets/js/parallax.js')
    .addEntry('share', './assets/js/share.js')
    .addEntry('slideshow', './assets/js/slideshow.js')
    .addEntry('thumbs', './assets/js/thumbs.js')
    .addEntry('wheel', './assets/js/wheel.js')
    .addEntry('bootstrap.min', './assets/css/bootstrap.min.css')
    .addEntry('index', './assets/css/index.css')
    .addEntry('jquery.fancybox.min', './assets/css/jquery.fancybox.min.css')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    //.enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
