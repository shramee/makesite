module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		/** Autoprefixing */
		autoprefixer: {
			options : {
				browsers : ['last 2 versions'],
			},
			multiple_files : {
				expand : true,
				flatten : true,
				src : '*.css',
				dest : ''
			}
		},

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
				sourcemap: 'none',
				files: {
					'style.css' : 'sass/style.scss'
				}
			}
		},

		/** Watcher */
		watch : {
			css: {
				files: '**/*.scss',
				tasks: [ 'sass', 'autoprefixer' ]
			}
		}
	});

	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default',['watch']);
};