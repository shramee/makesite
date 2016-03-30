<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

if ( ! function_exists( 'makesite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * @action after_setup_theme
	 */
	function makesite_setup() {

		// Load text domain, translations in /languages/ directory.
		load_theme_textdomain( 'makesite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			apply_filters(
				'makesite_nav_menus',
				array(
					'primary-desktop' => esc_html__( 'Primary Desktop', 'makesite' ),
					'primary-mobile'  => esc_html__( 'Primary Mobile', 'makesite' ),
				)
			)
		);

		//Switch default core markup for search form, comment form, and comments to HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'makesite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif;

if ( ! function_exists( 'makesite_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 * @action after_setup_theme - 0
	 * @global int $content_width
	 */
	function makesite_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'makesite_content_width', 640 );
	}
endif;

if ( ! function_exists( 'makesite_widgets_init' ) ) :
	/**
	 * Register widget area.
	 * @action widgets_init
	 */
	function makesite_widgets_init() {

		$sidebars = apply_filters(
			'makesite_widget_areas',
			array(
				'sidebar-1' => esc_html__( 'Secondary Sidebar', 'makesite' ),
				'sidebar-2' => esc_html__( 'Tertiary Sidebar', 'makesite' ),
				'left-slide' => esc_html__( 'Slide in left', 'makesite' ),
				'right-slide' => esc_html__( 'Slide in right', 'makesite' ),
			)
		);

		foreach ( $sidebars as $id => $sb ) {

			if ( is_string( $sb ) ) {
				$name = $sb;
				$sb = array();
				$sb['name'] = $name;
				$sb['id'] = $id;
			}

			$sb = wp_parse_args( $sb, array(
				'description'   => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
			register_sidebar( $sb );

		}

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'makesite' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
endif;

if ( ! function_exists( 'makesite_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 * @action wp_enqueue_scripts
	 */
	function makesite_scripts() {

		wp_enqueue_style( 'makesite-style', get_stylesheet_uri() );
		wp_enqueue_style( 'makesite-fa', get_stylesheet_directory_uri() . '/css/font-awesome.css' );

		wp_enqueue_script( 'makesite-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
		wp_enqueue_script( 'makesite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;

if ( ! function_exists( 'makesite_jetpack_setup' ) ) :
	/**
	 * Jetpack setup function.
	 * @action after_setup_theme
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 */
	function makesite_jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'makesite_infinite_scroll_render',
			'footer'    => 'page',
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}
endif;

if ( ! function_exists( 'makesite_infinite_scroll_render' ) ) :
	/**
	 * Custom render function for Infinite Scroll.
	 */
	function makesite_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_format() );
			endif;
		}
	}
endif;
