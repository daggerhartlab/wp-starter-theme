let mix = require('laravel-mix');

mix
	.sass('assets/scss/styles.scss', 'assets/css', {
		// https://sass-lang.com/documentation/js-api/interfaces/Options
		sassOptions: {
			sourceMap: true,
			outputStyle: 'expanded',
		}
	})
	.js('assets/js/*.es6.js', 'assets/js/scripts.js')
