<?php

/**
 * Created by PhpStorm.
 * User: shramee
 * Date: 11/07/16
 * Time: 5:12 PM
 */
class Makesite_Design {

	/** @var Makesite_Design Instance */
	protected static $instance;

	/**
	 * Returns instance of Makesite_Admin_Customizer
	 * @return Makesite_Design Instance
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( Makesite_Design::$instance ) ) {
			Makesite_Design::$instance = new Makesite_Design();
		}

		return Makesite_Design::$instance;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	public function __construct() {

		$args = array(
			'controls_classes'      => array(
				'heading'     => 'Makesite_Customize_Control',
				'slider'      => 'Makesite_Customize_Control',
				'shadow'      => 'Makesite_Customize_Control',
				'border'      => 'Makesite_Customize_Control',
				'all-border'  => 'Makesite_Customize_Control',
				'font'        => 'Makesite_Customize_Control',
				'text_shadow' => 'Makesite_Customize_Control',
				'spacing'     => 'Makesite_Customize_Control',
			),
			'include'               => dirname( __FILE__ ) . '/class-ms-customize-control.php',
			'token'                 => 'ms',
			'add_control_callback'  => array( $this, 'add_control' ),
		);

		$ms_fields = get_option( 'ms_customizer_admin_fields', array() );
		foreach ( $ms_fields as $title => $fields ) {
			$args['title'] = $title;
			$args['fields'] = $fields;

			new Makesite_Customizer_Manager( $args );
		}

		add_filter( 'liby_customizer_fields', array( $this, 'liby_fields' ) );

	}

	private function setup() {
		add_action( 'ms_design_enqueue', array( $this, 'enqueue', ) );
		add_action( 'ms_design_fields', array( $this, 'fields', ) );
		add_action( '__', array( $this, '__', ) );
	}

	public function enqueue() {
		wp_enqueue_script( 'ms-design', MS_DESIGN_URL . '/assets/script.js', array( 'jquery', 'wp-color-picker' ) );
		wp_enqueue_style( 'wp-color-picker' );
	}

	public function fields() {
		
		$fields = json_decode(  );
		if ( class_exists( 'Makesite_Design_Fields' ) ) {
			new Makesite_Design_Fields( '' );
		}
	}
}

new Makesite_Design();