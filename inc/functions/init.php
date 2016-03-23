<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */

/** Theme setup */
require dirname( __FILE__ ) . '/setup.php';
// Setup hooks
add_action( 'after_setup_theme', 'makesite_setup' );
add_action( 'after_setup_theme', 'makesite_content_width', 0 );
add_action( 'widgets_init', 'makesite_widgets_init' );
add_action( 'wp_enqueue_scripts', 'makesite_scripts' );
add_action( 'after_setup_theme', 'makesite_jetpack_setup' );

/** Custom template tags for this theme. */
require dirname( __FILE__ ) . '/template-tags.php';

/** Custom functions that act independently of the theme templates. */
require dirname( __FILE__ ) . '/extras.php';
