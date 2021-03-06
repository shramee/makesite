<?php
/**
 * @developer shramee.me <me@shramee.me>
 */

global $makesite;

/**
 * Class Makesite
 * @property bool $sb1				Sidebar 1 active
 * @property bool $show_sb1 show	Show sidebar 1
 * @property bool $sb2				Sidebar 2 active
 * @property bool $show_sb2 show	Show sidebar 2
 */
class Makesite {

	protected $dt = array();

	public function __construct() {
		add_action( 'after_setup_theme',	array( $this, 'setup' ) );
		add_action( 'after_setup_theme',	array( $this, 'content_width' ), 0 );
		add_action( 'widgets_init',			array( $this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts',	array( $this, 'scripts' ) );
		add_action( 'after_setup_theme',	array( $this, 'jetpack_setup' ) );
		add_action( 'body_class',			array( $this, 'body_class' ) );
		add_action( 'admin_bar',			array( $this, 'body_class' ) );
		// Add class to top level menu items
		add_filter( 'wp_nav_menu_objects', array( $this, 'menu_objects' ) );
	}

	/**
	 * Adds `menu-item-top-level` class to top level menu items
	 * @param array $item
	 * @return array
	 */
	public function menu_objects( $items ) {
		foreach ( $items as &$item ) {
			if ( ! $item->menu_item_parent ) {
				$item->classes[] = 'menu-item-top-level';
			}
		}

		return $items;
	}

	public function __get( $name ) {
		if ( array_key_exists( $name, $this->dt ) ) {
			return $this->dt[ $name ];
		} else {
			return false;
		}
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_class( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
			$classes[] = 'archive';
		}

		$classes = array_merge( $classes, Makesite_Design::instance()->body_class );
		$this->sidebar_classes( $classes );

		return $classes;
	}

	public function sidebar_classes( &$classes ) {

		$this->dt['sb1'] = is_active_sidebar( 'sidebar-1' );
		/**
		 * Hide or show the sidebar
		 * @hook filter makesite_show_sidebar
		 */
		if ( $this->dt['show_sb1'] = apply_filters( 'makesite_show_sidebar_1', $this->dt['sb1'] ) ) {
			$classes[] = 'sb1-active';
		}

		$this->dt['sb2'] = is_active_sidebar( 'sidebar-2' );
		/**
		 * Hide or show the sidebar
		 * @hook filter makesite_show_sidebar
		 */
		if ( $this->dt['show_sb2'] = apply_filters( 'makesite_show_sidebar_2', $this->dt['sb2'] ) ) {
			$classes[] = 'sb2-active';
		}
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * @action after_setup_theme
	 */
	public function setup() {

		// Load text domain, translations in /languages/ directory.
		load_theme_textdomain( 'makesite', get_template_directory() . '/languages' );

		// Editor styles
		add_editor_style( get_template_directory_uri() . '/style.css' );

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
					'top-menu' => esc_html__( 'Top Menu', 'makesite' ),
					'primary-desktop-menu' => esc_html__( 'Primary Desktop', 'makesite' ),
					'primary-mobile-menu'  => esc_html__( 'Primary Mobile', 'makesite' ),
					'header-left-menu' => esc_html__( 'Header Left Desktop', 'makesite' ),
					'header-right-menu' => esc_html__( 'Header Right Desktop', 'makesite' ),
					'left-slide-in-menu' => esc_html__( 'Left Slide-in Menu', 'makesite' ),
					'right-slide-in-menu' => esc_html__( 'Right Slide-in Menu', 'makesite' ),
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

		add_theme_support( 'custom-header', array(
			'height'      => 300,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_theme_support( 'custom-logo', array(
			'height'      => 110,
			'width'       => 470,
			'flex-width'  => true,
		) );

		add_theme_support( "custom-background" );
	}

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 * @action after_setup_theme - 0
	 * @global int $content_width
	 */
	public function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'makesite_content_width', 640 );
	}

	/**
	 * Register widget areas.
	 * @action widgets_init
	 */
	public function widgets_init() {

		$widget_areas = apply_filters(
			'makesite_widget_areas',
			array(
				'sidebar-1' => esc_html__( 'Secondary Sidebar', 'makesite' ),
				'sidebar-2' => esc_html__( 'Tertiary Sidebar', 'makesite' ),
				'left-slide' => esc_html__( 'Slide in left', 'makesite' ),
				'right-slide' => esc_html__( 'Slide in right', 'makesite' ),
			)
		); // Get widget areas to register
		foreach ( $widget_areas as $id => $args ) {
			$this->register_widget_area( $args, $id );
		}
	}

	/**
	 * Register widget area.
	 * @param array|string $args
	 * @param string $id
	 */
	public function register_widget_area( $args, $id ) {
		if ( is_string( $args ) ) {
			$name = $args;
			$args = array();
			$args['name'] = $name;
		} // If widget is a string set it as name of widget area
		$args = wp_parse_args( $args, array(
			'id'            => $id,
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) ); // Widget area args
		register_sidebar( $args ); // Register the widget area
	}

	/**
	 * Enqueue scripts and styles.
	 * @action wp_enqueue_scripts
	 */
	public function scripts() {
		$design = Makesite_Design::instance();

		// Theme styles
		wp_enqueue_style( 'makesite-style', get_template_directory_uri() . '/style.css' );
		// Theme design customizations
		wp_add_inline_style( 'makesite-style', $design->css );

		// Google fonts
		if ( $design->gf_url )
			wp_enqueue_style( 'makesite-google-fonts', $design->gf_url );

		wp_enqueue_script( 'makesite-public-js', get_template_directory_uri() . '/js/public.min.js', array( 'jquery' ), MAKESITE_VER, true );
		wp_enqueue_script( 'makesite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array( 'jquery' ), '20151215', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Jetpack setup function.
	 * @action after_setup_theme
	 * See: https://jetpack.com/support/infinite-scroll/
	 * See: https://jetpack.com/support/responsive-videos/
	 */
	public function jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => array( $this, 'infinite_scroll_render' ),
			'footer'    => 'page',
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}

	/**
	 * Custom render function for Infinite Scroll.
	 */
	public function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_format() );
			endif;
		}
	}

}

/** @var Makesite $makesite */
$makesite = new Makesite();

/** Custom template tags for this theme. */
require_once dirname( __FILE__ ) . '/template-tags.php';

/** Custom functions that act independently of the theme templates. */
require_once dirname( __FILE__ ) . '/extras.php';
