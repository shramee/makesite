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
	makesite_do_action(
		'sidebar',
		array(
			'tag'   => 'aside',
			'attrs' => array(
				'id'    => "secondary",
				'class' => "widget-area widget-area-1",
				'role'  => "complementary",
			),
		),
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
	makesite_do_action(
		'sidebar2',
		array(
			'tag'   => 'aside',
			'attrs' => array(
				'id'    => "tertiary",
				'class' => "widget-area widget-area-2",
				'role'  => "complementary",
			),
		),
		array( $makesite->sb2 )
	);
}