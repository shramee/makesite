<?php

/**
 * Created by PhpStorm.
 * User: shramee
 * Date: 11/07/16
 * Time: 5:12 PM
 */
class Makesite_Design {

	public function __construct() {
		add_action( 'wp_ajax_makesite_design', array( $this, 'tpl' ) );
	}

	public function tpl() {
		/** @constant Design directory URL */
		define( 'MS_DESIGN_URL', str_replace( get_template_directory(), get_template_directory_uri( ), __DIR__ ) );
		require 'tpl-design.php';
		die();
	}
}

new Makesite_Design();