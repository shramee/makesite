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
define( 'MAKESITE_VER', $theme->get( 'Version' ) );

// TODO Remove @ sign
/** @var Makesite theme URL */
@define( 'MAKESITE_SITE', $theme->get( 'ThemeURI' ) );

/** @var Makesite theme URL */
define( 'MAKESITE_URL', get_template_directory_uri() . '/' );

/** @var Makesite theme directory */
define( 'MAKESITE_DIR', get_template_directory() );

/**
 * Class autoloader
 */
spl_autoload_register(
	function( $class ) {
		$class = strtolower( str_replace( [ 'Makesite_', '_' ], [ '', '-' ], $class ) );
		$path = explode( '-', $class );
		$inc   = MAKESITE_DIR . "/inc/$path[0]/class-$class.php";
		if ( file_exists( $inc ) ) {
			include_once $inc;
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
