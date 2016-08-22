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
		if ( ! (
			( isset( $_REQUEST['wp_customize'] ) && 'on' == $_REQUEST['wp_customize'] ) ||
			( is_admin() && 'customize.php' == basename( $_SERVER['PHP_SELF'] ) )
		) ) {
			return;
		}

		$style_filed_types = array(
			'heading'     => 'Makesite_Customizer_CSS_Control',
			'slider'      => 'Makesite_Customizer_CSS_Control',
			'shadow'      => 'Makesite_Customizer_CSS_Control',
			'border'      => 'Makesite_Customizer_CSS_Control',
			'all-border'  => 'Makesite_Customizer_CSS_Control',
			'font'        => 'Makesite_Customizer_CSS_Control',
			'text_shadow' => 'Makesite_Customizer_CSS_Control',
			'spacing'     => 'Makesite_Customizer_CSS_Control',
		);

		$args = array(
			'controls_classes'      => $style_filed_types,
			'token'                 => 'ms',
			//'add_control_callback'  => array( $this, 'add_control' ),
			'priority'              => 0,
		);

		$ms_fields = self::fields();

		$idCount = [];
		$count = [ 0, 0, 0, ];

		foreach ( $ms_fields as $title => $fields ) {

			$args['title'] = $title;
			$args['fields'] = $fields;
			$args['priority']++;

			new Makesite_Customizer_Manager( $args );

			foreach ( $fields as $id => $f ) {
				$idCount[ $id ][] = 1;
			}
		}

		if ( filter_input( INPUT_GET, 'dump_custo_fields' ) ) {
			echo '<table>';
			foreach( $idCount as $id => $count ) {
				$count = count( $count );
				echo "<tr><td>$id</td><td>$count</td></tr>";
			}
			echo '</table>';
			die();
		}

		add_filter( 'liby_customizer_fields', array( $this, 'liby_fields' ) );

	}

	static function fields() {
		$response = wp_remote_get( MS_SITE . '/wp-admin/admin-ajax.php?action=design_fields&site=' . site_url() );
		if( is_array($response) ) {
			$fields = $response['body']; // use the content
		}
		if ( $fields ) {
			$fields = json_decode( $fields, 'assoc_array' );

			return apply_filters( 'makesite_design_fields', $fields );
		}
		return array();
	}



	private function setup() {
		add_action( 'ms_design_enqueue', array( $this, 'enqueue', ) );
		add_action( 'ms_design_fields', array( $this, 'fields', ) );
		add_action( '__', array( $this, '__', ) );
	}

}