module.exports = function ( grunt ) {
	// Project configuration.
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		copy: {
			main: {
				options: {
					mode: true,
				},
				src: [
					'**',
					'!.git/**',
					'!.gitignore',
					'!.gitattributes',
					'!*.sh',
					'!*.zip',
					'!eslintrc.json',
					'!README.md',
					'!Gruntfile.js',
					'!package.json',
					'!package-lock.json',
					'!composer.json',
					'!composer.lock',
					'!phpcs.xml',
					'!phpcs.xml.dist',
					'!phpunit.xml.dist',
					'!phpstan.neon',
					'!phpstan-baseline.neon',
					'!node_modules/**',
					'!vendor/**',
					'!artifact/**',
					'!tests/**',
					'!scripts/**',
					'!config/**',
					'!tests/**',
					'!assets/css/feedback.css',
					'!assets/css/feedback-rtl.css',
					'!assets/js/feedback.js',
					'!bin/**',
				],
				dest: 'deactivation-survey/',
			},
		},
		compress: {
			main: {
				options: {
					archive: 'deactivation-survey-<%= pkg.version %>.zip',
					mode: 'zip',
				},
				files: [
					{
						src: [ './deactivation-survey/**' ],
					},
				],
			},
		},
		clean: {
			main: [ 'deactivation-survey' ],
			zip: [ '*.zip' ],
		},
		rtlcss: {
			options: {
				// rtlcss options
				config: {
					preserveComments: true,
					greedy: true,
				},
				// generate source maps
				map: false,
			},
			dist: {
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.css', '!*-rtl.css', '!*-rtl.min.css' ],
						dest: 'assets/css',
						ext: '-rtl.css',
					},
				],
			},
		},

		/* Minify Js and Css */
		cssmin: {
			options: {
				keepSpecialComments: 0,
			},
			css: {
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.css' ],
						dest: 'assets/css',
						ext: '.min.css',
					},
				],
			},
		},

		uglify: {
			js: {
				options: {
					compress: {
						drop_console: true, // <-
					},
				},
				files: [
					{
						expand: true,
						cwd: 'assets/js',
						src: [ '*.js' ],
						dest: 'assets/js',
						ext: '.min.js',
					},
				],
			},
		},
	} );

	/* Load Tasks */
	grunt.loadNpmTasks( 'grunt-rtlcss' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	grunt.registerTask( 'minify', [ 'rtlcss', 'cssmin:css', 'uglify:js' ] );

	/* Register task started */
	grunt.registerTask( 'release', [
		'clean:zip',
		'copy',
		'compress',
		'clean:main',
	] );
};
