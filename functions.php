<?php
/**
 * makesite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package makesite
 */

function makesite_php_incompatible() {
	$heading = __( 'Irks! Makesite theme needs php 5.4 or newer.', 'makesite' );
	$message = sprintf( __( 'Please ask you host for a newer php version, you are using version %s. Try new and shiny version 7.0.0+ for best results :)', 'makesite' ), PHP_VERSION );

	printf( '<div class="notice notice-error"><h3>%1$s</h3><p>%2$s</p></div>', esc_html( $heading ), esc_html( $message ) );
}

if (version_compare(PHP_VERSION, '5.4', '<')) {

	function makesite() {
		$heading = __( 'Server compatibility issue!', 'makesite' );
		$message = sprintf( __( 'Please check back in a few minutes. If you are the site administrator please visit admin end for details.', 'makesite' ), PHP_VERSION );

		printf( '<h2>%1$s</h2><p>%2$s</p>', esc_html( $heading ), esc_html( $message ) );
	}

	add_action( 'admin_notices', 'makesite_php_incompatible' );
} else {
	/**
	 * Initiate the theme functions
	 */
	require_once get_template_directory() . '/inc/init.php';
}

