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
<?php
	/**
	 * Makesite right after opening body tag
	 * @hook action makesite_before_site
	 */
	do_action( 'makesite_before_site' );
?>
<div id="page" class="site">
	<?php
	/**
	 * Makesite render header
	 * @hook action makesite_header
	 * @hooked makesite_hd_skiplinks
	 * @hooked makesite_hd_branding
	 * @hooked makesite_hd_navigation
	 * @hooked makesite_hd_close
	 */
	ms_do_action(
		'header',
		'<header id="masthead" class="site-header" role="banner"><div class="col-full">',
		'</div><!-- .col-full --></header><!-- #masthead -->'
	);
	?>