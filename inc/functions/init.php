<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
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

	function __construct() {
		add_action( 'after_setup_theme',	array( $this, 'setup' ) );
		add_action( 'after_setup_theme',	array( $this, 'content_width' ), 0 );
		add_action( 'widgets_init',			array( $this, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts',	array( $this, 'scripts' ) );
		add_action( 'after_setup_theme',	array( $this, 'jetpack_setup' ) );
		add_action( 'body_class',			array( $this, 'body_class' ) );
		add_action( 'admin_bar',			array( $this, 'body_class' ) );
		add_action( 'admin_bar_menu',		array( $this, 'admin_bar_menu' ), 999 );
	}

	function __get( $name ) {
		if ( array_key_exists( $name, $this->dt ) ) {
			return $this->dt[ $name ];
		} else {
			return false;
		}
	}

	/**
	 * Adds customization link to admin bar
	 * @param WP_Admin_Bar $admin_bar
	 * @action admin_bar_menu
	 */
	function admin_bar_menu( $admin_bar ) {
		?>
		<style>
			#wp-admin-bar-design a:before {
				content: '\f116';
				margin-top: 3px;
			}
		</style>
		<?php
		$url = 'http://makesite.dev/customize?url=' . urlencode( site_url() );
		$admin_bar->add_menu( array(
//			'parent' => 'new-content',
			'id'     => 'design',
			'title'  => 'Design',
			'href'   => $url . '',
		) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function body_class( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
			$classes[] = 'archive';
		}

		$this->sidebar_classes( $classes );

		return $classes;
	}

	function sidebar_classes( &$classes ) {

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
	function setup() {

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

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 * @action after_setup_theme - 0
	 * @global int $content_width
	 */
	function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'makesite_content_width', 640 );
	}

	/**
	 * Register widget areas.
	 * @action widgets_init
	 */
	function widgets_init() {

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
	function register_widget_area( $args, $id ) {
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
	function scripts() {

		wp_enqueue_style( 'makesite-style', get_stylesheet_uri() );
		wp_enqueue_style( 'makesite-fa', get_stylesheet_directory_uri() . '/css/font-awesome.css' );

		wp_enqueue_script( 'makesite-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20151215', true );
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
	function jetpack_setup() {
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
	function infinite_scroll_render() {
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
