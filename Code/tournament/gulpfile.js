const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js');

    mix.scripts([
    	'js/file-upload/js/load-image.all.min.js',
		'js/file-upload/js/canvas-to-blob.min.js',
		'js/file-upload/js/vendor/jquery.ui.widget.js',
		'js/file-upload/js/jquery.iframe-transport.js',
		'js/file-upload/js/jquery.fileupload.js',
		'js/file-upload/js/jquery.fileupload-process.js',
		'js/file-upload/js/jquery.fileupload-image.js',
		'js/file-upload/js/jquery.fileupload-audio.js',
		'js/file-upload/js/jquery.fileupload-video.js',
		'js/file-upload/js/jquery.fileupload-ui.js'
    ], 'public/js/file-upload/compiled.js', 'public');
});
