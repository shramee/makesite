<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makesite
 */

$sidebar_active_1 = is_active_sidebar( 'sidebar-1' );

/**
 * Hide or show the sidebar
 * @hook filter makesite_show_sidebar
 */
$show_sidebar = apply_filters( 'makesite_show_sidebar', $sidebar_active_1 );

// If show sidebar is falsy, return
if ( $show_sidebar ) {

	/**
	 * Makesite render sidebar
	 * @hook action makesite_sidebar
	 * @param bool $sidebar_active_1 Is sidebar-1 active
	 * @hooked makesite_sb_open    -  7
	 * @hooked makesite_sb_widgets - 25
	 * @hooked makesite_sb_close   - 97
	 */
	ms_do_action(
		'sidebar',
		'<aside id="sidebars" class="widget-area widget-area-1" role="complementary">',
		'</aside><!-- #sidebars -->',
		array( $sidebar_active_1 )
	);

}

$sidebar_active_2 = is_active_sidebar( 'sidebar-2' );

/**
 * Hide or show the sidebar
 * @hook filter makesite_show_sidebar
 */
$show_sidebar = apply_filters( 'makesite_show_sidebar', $sidebar_active_2 );

// If show sidebar is falsy, return
if ( $show_sidebar ) {

	/**
	 * Makesite render sidebar
	 * @hook action makesite_sidebar
	 * @param bool $sidebar_active_2 Is sidebar-2 active
	 * @hooked makesite_sb_open    -  7
	 * @hooked makesite_sb_widgets - 25
	 * @hooked makesite_sb_close   - 97
	 */
	ms_do_action(
		'sidebar2',
		'<aside id="tertiary" class="widget-area widget-area-2" role="complementary">',
		'</aside><!-- #tertiary -->',
		array( $sidebar_active_2 )
	);

}