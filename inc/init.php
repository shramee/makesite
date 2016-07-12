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

if ( ! empty( $_GET['action'] ) ) {
	/** Structure functions and hooks. */
	require_once dirname( __FILE__ ) . '/design/class-makesite-design.php';
}