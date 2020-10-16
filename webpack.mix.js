const mix = require("laravel-mix");

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = "../../../public/vendor/ggphp/shipping/assets";
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.sass(__dirname + '/src/Resources/assets/sass/app.scss', 'css/shipping.css')
    .copyDirectory(__dirname + '/src/Resources/assets/icomoon', publicPath + '/icomoon')
    .options({
        processCssUrls: false
    });

mix.js([__dirname + '/src/Resources/assets/js/app.js'], 'js/shipping.js');

if (!mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}
