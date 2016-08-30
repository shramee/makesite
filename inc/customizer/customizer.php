<?php
/**
 * makesite Theme Customizer.
 *
 * @package makesite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function makesite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
}
add_action( 'customize_register', 'makesite_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function makesite_customize_preview_js() {
	wp_enqueue_script( 'makesite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'makesite_customize_preview_js' );

new Makesite_Customizer_Manager( array(
	'title' => 'Customization key',
	'fields' => array(
		array(
			'id' => 'site-customization-key',
			'type' => 'text',
			'label' => 'Site customization key',
		),
	)
) );