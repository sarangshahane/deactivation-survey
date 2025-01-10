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

		bumpup: {
			options: {
				updateProps: {
					pkg: 'package.json',
				},
			},
			file: 'package.json',
		},

		replace: {
			plugin_main: {
				src: [ 'deactivation-survey.php' ],
				overwrite: true,
				replacements: [
					{
						from: /Version: \bv?(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)(?:-[\da-z-A-Z-]+(?:\.[\da-z-A-Z-]+)*)?(?:\+[\da-z-A-Z-]+(?:\.[\da-z-A-Z-]+)*)?\b/g,
						to: 'Version: <%= pkg.version %>',
					},
				],
			},
			plugin_const: {
				src: [ 'deactivation-survey.php' ],
				overwrite: true,
				replacements: [
					{
						from: /UDS_VER', '.*?'/g,
						to: "UDS_VER', '<%= pkg.version %>'",
					},
				],
			},
			plugin_function_comment: {
				src: [
					'*.php',
					'**/*.php',
					'!node_modules/**',
					'!php-tests/**',
					'!bin/**',
					'!tests/**',
					'!vendor/**',
				],
				overwrite: true,
				replacements: [
					{
						from: 'x.x.x',
						to: '<%=pkg.version %>',
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
	grunt.loadNpmTasks( 'grunt-bumpup' );
	grunt.loadNpmTasks( 'grunt-text-replace' );

	grunt.registerTask( 'minify', [ 'rtlcss', 'cssmin:css', 'uglify:js' ] );

	// Bump Version - `grunt version-bump --ver=<version-number>`
	grunt.registerTask( 'version-bump', function ( ver ) {
		let newVersion = grunt.option( 'ver' );
		if ( newVersion ) {
			newVersion = newVersion ? newVersion : 'patch';

			grunt.task.run( 'bumpup:' + newVersion );
			grunt.task.run( 'replace' );
		}
	} );

	/* Register task started */
	grunt.registerTask( 'release', [
		'clean:zip',
		'copy',
		'compress',
		'clean:main',
	] );
};
