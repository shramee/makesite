<?php

/**
 * Class Makesite_Design_Customizer_Register
 * Initiate Makesite design
 */
class Makesite_Design_Customizer_Register {

	/** @var Makesite_Design_Customizer_Register Instance */
	protected static $instance;

	/** @var array  */
	protected $panel_args = array(
		'controls_classes' => array(
			'slider'      => 'Makesite_Customizer_CSS_Control',
			'shadow'      => 'Makesite_Customizer_CSS_Control',
			'border'      => 'Makesite_Customizer_CSS_Control',
			'all-border'  => 'Makesite_Customizer_CSS_Control',
			'font'        => 'Makesite_Customizer_CSS_Control',
			'text_shadow' => 'Makesite_Customizer_CSS_Control',
			'spacing'     => 'Makesite_Customizer_CSS_Control',
		),
		'token'            => 'makesite',
		'priority'         => 7,
	);

	/**
	 * Returns instance of Makesite_Admin_Customizer
	 * @return Makesite_Design_Customizer_Register Instance
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( Makesite_Design_Customizer_Register::$instance ) ) {
			Makesite_Design_Customizer_Register::$instance = new Makesite_Design_Customizer_Register();
		}

		return Makesite_Design_Customizer_Register::$instance;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {

		$custo_args = $this->panel_args;

		$makesite_fields = Makesite_Design::fields();

		foreach ( $makesite_fields as $title => $fields ) {

			$custo_args['title'] = $title;
			$custo_args['fields'] = $fields;
			$custo_args['priority']++;

			new Makesite_Customizer_Manager( $custo_args );

			$this->dev_dump( $title, $fields );
		}

	}

	/**
	 * Data dump for dev analysis
	 * @param $title string Panel title
	 * @param $fields array Panel args
	 * @todo Remove in v1.0.0
	 */
	protected function dev_dump( $title, $fields ) {
		if ( filter_input( INPUT_GET, 'dump_custo_fields' ) ) {

			foreach ( $fields as $id => $f )
				$idCount[ $id ][] = 1;

			echo '<table>';
			foreach ( $idCount as $id => $count ) {
				$count = count( $count );
				echo "<tr><td>$id</td><td>$count</td></tr>";
			}
			echo '</table>';
			die();
		}
	}

	/**
	 * Get fields data
	 * @return array Fields data
	 */
	static function fields() {
			return Makesite_Design::fields();
	}
}