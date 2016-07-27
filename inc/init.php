<?php
/**
 * makesite init functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package makesite
 */

/** Theme functions init */
require_once dirname( __FILE__ ) . '/functions/init.php';

/** Customizer additions. */
require_once dirname( __FILE__ ) . '/customizer/customizer.php';

/** Structure functions and hooks. */
require_once dirname( __FILE__ ) . '/structure/init.php';

/** Structure functions and hooks. */
require_once dirname( __FILE__ ) . '/design/class-makesite-design.php';

$theme = wp_get_theme();

/** @var Makesite Version */
define( 'MS_VER', $theme->get( 'Version' ) );

/** @var Makesite theme URL */
define( 'MS_SITE', $theme->get( 'ThemeURI' ) );

/** @var Makesite theme URL */
define( 'MS_URL', get_template_directory_uri() );

/** @var Makesite theme directory */
define( 'MS_DIR', get_template_directory() );

spl_autoload_register( function( $class ){
	
} );