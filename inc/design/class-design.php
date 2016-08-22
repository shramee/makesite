<?php

/**
 * Class Makesite_Design
 * Initiate Makesite design
 */
class Makesite_Design {

	/** @var Makesite_Design Instance */
	protected static $instance;

	/** @var array  */
	protected $panel_args = array(
		'controls_classes' => array(
			'heading'     => 'Makesite_Customizer_CSS_Control',
			'slider'      => 'Makesite_Customizer_CSS_Control',
			'shadow'      => 'Makesite_Customizer_CSS_Control',
			'border'      => 'Makesite_Customizer_CSS_Control',
			'all-border'  => 'Makesite_Customizer_CSS_Control',
			'font'        => 'Makesite_Customizer_CSS_Control',
			'text_shadow' => 'Makesite_Customizer_CSS_Control',
			'spacing'     => 'Makesite_Customizer_CSS_Control',
		),
		'token'            => 'ms',
		'priority'         => 7,
	);

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
		global $wp_customize;
		if ( $wp_customize instanceof WP_Customize_Manager ) {
			return;
		}

		$custo_args = $this->panel_args;

		$ms_fields = self::fields();

		foreach ( $ms_fields as $title => $fields ) {

			$custo_args['title'] = $title;
			$custo_args['fields'] = $fields;
			$custo_args['priority']++;

			new Makesite_Customizer_Manager( $custo_args );

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

		if ( ! empty( $fields ) ) {
			$fields = json_decode( $fields, 'assoc_array' );
			return apply_filters( 'makesite_design_fields', $fields );
		}
		return array();
	}
}