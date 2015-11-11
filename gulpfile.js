var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    // Application Scripts
    mix.scripts([
    	// packages
    	'./bower_components/angularjs-geolocation/src/geolocation.js',
    	// site
        'app.module.js',
        'app.routes.js',
        'components/**/*.js',
        'components/**/*.js',
    ]);

});
