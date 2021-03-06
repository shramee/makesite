<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makesite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<?php
	/**
	 * Executes before header
	 * @hook action makesite_before_site
	 */
	do_action( 'makesite_before_header' );
	?>
	<?php
	/**
	 * Makesite render header
	 * @hook action makesite_header
	 * @hooked makesite_hd_skiplinks
	 * @hooked makesite_hd_top_nav
	 * @hooked makesite_hd_right_nav
	 * @hooked makesite_hd_left_nav
	 * @hooked makesite_hd_branding
	 * @hooked makesite_hd_navigation
	 */
	makesite_do_action(
		'header',
		array(
			'tag'    => 'header',
			'attrs'  => array(
				'id'    => "masthead",
				'class' => "site-header",
				'role'  => "banner",
				'style' => ( get_header_image() ? "background-image:url('" . get_header_image() . "');" : '' ) . ( get_theme_mod( 'header_textcolor' ) ? 'color:#' . get_theme_mod( 'header_textcolor' ) . ';' : '' ),
			),
			'before' => '<div class="container">',
			'after'  => '</div><!--.container-->',
		)
	);

	/**
	 * Executes after header
	 * @hook action makesite_after_header
	 */
	do_action( 'makesite_after_header' );
