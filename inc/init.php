<?php
/**
 * makesite init functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package makesite
 */

$theme = wp_get_theme();

/** @var Makesite Version */
define( 'MS_VER', $theme->get( 'Version' ) );

// TODO Remove @ sign
/** @var Makesite theme URL */
@define( 'MS_SITE', $theme->get( 'ThemeURI' ) );

/** @var Makesite theme URL */
define( 'MS_URL', get_template_directory_uri() . '/' );

/** @var Makesite theme directory */
define( 'MS_DIR', get_template_directory() );

/**
 * Class autoloader
 */
spl_autoload_register(
	function( $class ) {
		$debug = "<pre>$class : ";

		$class = strtolower( str_replace( array( 'Makesite_', '_', ), array( '', '-', ), $class ) );
		$path = explode( '-', $class );
		$inc   = MS_DIR . "/inc/$path[0]/class-$class.php";

		if ( file_exists( $inc ) ) {
			include_once $inc;
		} else {
			echo "$debug$inc" . debug_backtrace()[3]['function'] . "</pre>\n";
		}
	}
);

/** Theme functions init */
require_once dirname( __FILE__ ) . '/functions/init.php';

/** Customizer additions. */
require_once dirname( __FILE__ ) . '/customizer/customizer.php';

/** Structure functions and hooks. */
require_once dirname( __FILE__ ) . '/structure/init.php';

/** Theme design */
Makesite_Design::instance();

Makesite_Design_Css::instance();