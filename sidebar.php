<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makesite
 */

/** @var Makesite Instance */
global $makesite;

// If show sidebar is falsy, return
if ( $makesite->show_sb1 ) {

	/**
	 * Makesite render sidebar
	 * @hook action makesite_sidebar
	 * @param bool $sidebar_active_1 Is sidebar-1 active
	 * @hooked makesite_sb_widgets - 25
	 */
	ms_do_action(
		'sidebar',
		'<aside id="sidebars" class="widget-area widget-area-1" role="complementary">',
		'</aside><!-- #sidebars -->',
		array( $makesite->sb1 )
	);

}

// If show sidebar is falsy, return
if ( $makesite->show_sb2 ) {

	/**
	 * Makesite render sidebar
	 * @hook action makesite_sidebar
	 * @param bool $sidebar_active_2 Is sidebar-2 active
	 * @hooked makesite_sb_widgets - 25
	 */
	ms_do_action(
		'sidebar2',
		'<aside id="tertiary" class="widget-area widget-area-2" role="complementary">',
		'</aside><!-- #tertiary -->',
		array( $makesite->sb2 )
	);

}