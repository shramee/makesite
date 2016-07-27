<?php
/**
 * Register customizer panels, sections and controls
 * @package makesite
 * @since 1.0.0
 */

class Makesite_Admin_Customizer {

	/** @var Makesite_Admin_Customizer Instance */
	protected static $instance;

	/**
	 * Returns instance of Makesite_Admin_Customizer
	 * @return Makesite_Admin_Customizer
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
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
			'include'               => dirname( __FILE__ ) . '/class-customize-control.php',
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

	/**
	 * Adds makesite fields to liby customizer fields
	 * @filter liby_customizer_fields
	 * @param array $fields Fields to merge ms fields with
	 * @return array Fields including makesite fields
	 * @since 1.0.0
	 */
	public function liby_fields( $fields ) {

		$ms_fields = get_option( 'ms_customizer_admin_fields', array() );
		$fields = array_merge( $fields, $ms_fields );

		return $fields;
	}

	/**
	 * @param array $option
	 * @param array $setting_args
	 * @param string $settings_class
	 * @param Makesite_Customizer_Manager $liby_cm
	 */
	public function add_control( $option, $setting_args, $settings_class, Makesite_Customizer_Manager $liby_cm ) {

		if ( 'all-custo' == $option['type'] ) {

			$i = 0;
			$id    = str_replace( ']', '', $option['id'], $i );
			$label = $option['label'];
			$id_suffix = '';
			if ( $i ) {
				$id_suffix = ']';
			}

			//BG Color
			$option['id']   = $id . '-bg-color' . $id_suffix;
			$option['type'] = 'alpha-color';
			$option['label'] = $label . ' Background Color';
			$liby_cm->add_control( $option, $setting_args, $settings_class );

			//Border
			$option['id']   = $id . '-border' . $id_suffix;
			$option['type'] = 'all-border';
			$option['label'] = $label . ' Border';
			$liby_cm->add_control( $option, $setting_args, $settings_class );

			//Shadow
			$option['id']   = $id . '-shadow' . $id_suffix;
			$option['type'] = 'shadow';
			$option['label'] = $label . ' Shadow';
			$liby_cm->add_control( $option, $setting_args, $settings_class );

			//Rounded corners
			$option['id']   = $id . '-border-radius' . $id_suffix;
			$option['type'] = 'slider';
			$option['label'] = $label . ' Rounded Corners';
			$liby_cm->add_control( $option, $setting_args, $settings_class );

			//Padding
			$option['id']   = $id . '-padding' . $id_suffix;
			$option['type'] = 'spacing';
			$option['label'] = $label . ' Padding';
			$liby_cm->add_control( $option, $setting_args, $settings_class );

		} else {
			$liby_cm->add_control( $option, $setting_args, $settings_class );
		}
	}

	function debug() { if ( $this->controls ) var_dump( $this->controls ); }

	/**
	 * Sets makesite token for liby fields
	 * @filter liby_token
	 * @param string $token Token
	 * @return string Makesite token
	 * @since 1.0.0
	 */
	public function token( $fields ) {
		return 'ms';
	}
}