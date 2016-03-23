<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makesite
 */

$sidebar_active = is_active_sidebar( 'sidebar-1' );

/**
 * Hide or show the sidebar
 * @hook filter makesite_show_sidebar
 */
$show_sidebar = apply_filters( 'makesite_show_sidebar', $sidebar_active );

// If show sidebar is falsy, return
if ( $show_sidebar ) {

	/**
	 * Makesite render sidebar
	 * @hook action makesite_sidebar
	 * @param bool $sidebar_active Is sidebar-1 active
	 * @hooked makesite_sb_open    -  7
	 * @hooked makesite_sb_widgets - 25
	 * @hooked makesite_sb_close   - 97
	 */
	do_action( 'makesite_sidebar', $sidebar_active );

}
?>