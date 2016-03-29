<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package makesite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function makesite_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'makesite_body_classes' );

/**
 * Minify HTML
 * @param string $html HTML to minify
 * @return string Minified HTML
 * @since 1.0.0
 */
function ms_minify_html( $html ) {
	$html = str_replace( array( "\n", "\t", ), '', $html );
	return $html;
}