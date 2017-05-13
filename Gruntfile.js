module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		/** Sass decompiling */
		sass: {
			dev: {
				options: {
					style : 'expanded',
					sourcemap: 'none'
				},
				files: {
					'style.dev.css' : 'sass/style.scss'
				}
			},
			dist: {
				options: {
					style : 'compressed',
					sourcemap: 'none'
				},
				files: [
					{
						expand: true,
						src: ['sass/*.scss','**/sass/*.scss'],
						ext: '.css',
						rename: function( dest, src ) {
							return src.replace( 'sass/', '' );
						},
					},
				],
			}
		},

		/** Autoprefixing */
		autoprefixer: {
			options : {
				browsers : ['last 5 versions'],
			},
			multiple_files : {
				expand : true,
				flatten : true,
				src : '*.css',
				dest : ''
			}
		},

		/** RTL css */
		rtlcss: {
			styleToRtl:{
				options: {
					map: false,
					opts: {
						clean:false
					},
					saveUnmodified: true,
				},
				expand : true,
				src: ['style.css'],
				ext: '.css',
				rename: function( dest, src ) {
					return src.replace( 'style', 'rtl' );
				},
			}
		},

		/** CoffeeScript decompiling */
		coffee: {
			coffee_to_js: {
				options: {
					bare: true
				},
				expand: true,
				flatten: false,
				src: ['**/*.coffee'],
				ext: ".js",
			}
		},

		/** Minify JS */
		uglify: {
			minify: {
				files: [
					{
						expand: true,
						src: ['**/src/*.js'],
						ext: '.min.js',
						extDot: 'first',
						rename: function( dest, src ) {
							return src.replace( 'src/', '' );
						},
					},
				],
			},
		},

		/** Watcher */
		watch: {
			css: {
				files: '**/*.scss',
				tasks: [ 'sass', 'autoprefixer', 'rtlcss' ]
			},
			js: {
				files: '**/*.coffee',
				tasks: [ 'coffee', 'uglify' ]
			}
		},
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-rtlcss');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask( 'default', ['sass', 'autoprefixer', 'rtlcss', 'coffee', 'uglify', 'watch',] );
};