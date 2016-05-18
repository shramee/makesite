<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package makesite
 */

/**
 * Minify HTML
 * @param string $html HTML to minify
 * @return string Minified HTML
 * @since 1.0.0
 */
function ms_minify( $html ) {
	$html = str_replace( array( "\n", "\t", ), '', $html );
	return $html;
}